<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShiprocketService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.shiprocket.base_url', 'https://apiv2.shiprocket.in/v1/external'), '/');
    }

    // ============================================
    // AUTH TOKEN (10 din valid, 9 din cache)
    // ============================================
    public function getToken(bool $fresh = false): string
    {
        if ($fresh) {
            Cache::forget('shiprocket_token');
        }

        return Cache::remember('shiprocket_token', now()->addDays(9), function () {
            $response = Http::acceptJson()->timeout(30)->post($this->baseUrl . '/auth/login', [
                'email'    => config('services.shiprocket.email'),
                'password' => config('services.shiprocket.password'),
            ]);

            if (!$response->successful() || !$response->json('token')) {
                Log::error('Shiprocket login failed', ['response' => $response->body()]);
                throw new \Exception('Shiprocket login failed: ' . $response->body());
            }

            return $response->json('token');
        });
    }

    // ============================================
    // COMMON REQUEST (401 aaye to token refresh karke retry)
    // ============================================
    protected function request(string $method, string $endpoint, array $data = []): array
    {
        $send = function (string $token) use ($method, $endpoint, $data) {
            $http = Http::withToken($token)->acceptJson()->timeout(30);

            return $method === 'GET'
                ? $http->get($this->baseUrl . $endpoint, $data)
                : $http->post($this->baseUrl . $endpoint, $data);
        };

        $response = $send($this->getToken());

        if ($response->status() === 401) {
            $response = $send($this->getToken(true));
        }

        $json = $response->json() ?? [];

        if (!$response->successful()) {
            Log::error('Shiprocket API error', [
                'endpoint' => $endpoint,
                'status'   => $response->status(),
                'response' => $response->body(),
            ]);
            throw new \Exception('Shiprocket error (' . $endpoint . '): ' . ($json['message'] ?? $response->body()));
        }

        return $json;
    }

    // ============================================
    // ITEM KA WEIGHT/SIZE: variant → product → default
    // ============================================
    protected function itemDimension($item, string $field): float
    {
        $variantValue = $item->variant->{$field} ?? null;
        if ($variantValue !== null && (float) $variantValue > 0) {
            return (float) $variantValue;
        }

        $productValue = $item->product->{$field} ?? null;
        if ($productValue !== null && (float) $productValue > 0) {
            return (float) $productValue;
        }

        return (float) config('services.shiprocket.default_' . $field);
    }

    // ============================================
    // PACKAGE WEIGHT + DIMENSIONS (poore order ka box)
    // ============================================
    public function packageDetails(Order $order): array
    {
        $order->loadMissing('items.product', 'items.variant');

        $weight = 0;
        $length = 0;
        $breadth = 0;
        $height = 0;

        foreach ($order->items as $item) {
            $qty = max(1, (int) $item->quantity);

            $weight += $this->itemDimension($item, 'weight') * $qty;
            $length = max($length, $this->itemDimension($item, 'length'));
            $breadth = max($breadth, $this->itemDimension($item, 'breadth'));
            $height += $this->itemDimension($item, 'height') * $qty;
        }

        return [
            'weight'  => round(max($weight, 0.1), 3),
            'length'  => round(max($length, 1), 2),
            'breadth' => round(max($breadth, 1), 2),
            'height'  => round(max($height, 1), 2),
        ];
    }

    // ============================================
    // 1. CREATE ORDER
    // ============================================
    public function createOrder(Order $order): array
    {
        $order->loadMissing('items.product', 'items.variant');

        $items = [];
        foreach ($order->items as $item) {
            $name = $item->product_name;
            if (!empty($item->variant_name)) {
                $name .= ' - ' . $item->variant_name;
            }

            $sku = $item->variant->sku ?? null;
            if (empty($sku)) {
                $sku = $item->product_sku ?: ('SKU-' . $item->product_id . ($item->variant_id ? '-' . $item->variant_id : ''));
            }

            $items[] = [
                'name'          => $name,
                'sku'           => $sku,
                'units'         => (int) $item->quantity,
                'selling_price' => (float) $item->unit_price,
                'discount'      => 0,
                'tax'           => 0,
            ];
        }

        $package = $this->packageDetails($order);

        $payload = [
            'order_id'              => (string) $order->order_number,
            'order_date'            => $order->created_at->format('Y-m-d H:i'),
            'pickup_location'       => config('services.shiprocket.pickup_location'),
            'billing_customer_name' => $order->first_name,
            'billing_last_name'     => $order->last_name ?? '',
            'billing_address'       => $order->address,
            'billing_address_2'     => $order->apartment ?? '',
            'billing_city'          => $order->city,
            'billing_pincode'       => (string) $order->zip,
            'billing_state'         => $order->state,
            'billing_country'       => $order->country ?: 'India',
            'billing_email'         => $order->email,
            'billing_phone'         => (string) $order->phone,
            'shipping_is_billing'   => true,
            'order_items'           => $items,
            'payment_method'        => $order->payment_method === 'cod' ? 'COD' : 'Prepaid',
            'shipping_charges'      => (float) $order->shipping_cost,
            'total_discount'        => 0,
            'sub_total'             => (float) $order->total,
            'length'                => $package['length'],
            'breadth'               => $package['breadth'],
            'height'                => $package['height'],
            'weight'                => $package['weight'],
        ];

        return $this->request('POST', '/orders/create/adhoc', $payload);
    }

    // ============================================
    // 2. ASSIGN AWB (courier auto select)
    // ============================================
    public function assignAwb(int $shipmentId, ?int $courierId = null): array
    {
        $data = ['shipment_id' => $shipmentId];

        if ($courierId) {
            $data['courier_id'] = $courierId;
        }

        return $this->request('POST', '/courier/assign/awb', $data);
    }

    // ============================================
    // 3. GENERATE PICKUP
    // ============================================
    public function generatePickup(int $shipmentId): array
    {
        return $this->request('POST', '/courier/generate/pickup', [
            'shipment_id' => [$shipmentId],
        ]);
    }

    // ============================================
    // 4. GENERATE LABEL (PDF url)
    // ============================================
    public function generateLabel(int $shipmentId): array
    {
        return $this->request('POST', '/courier/generate/label', [
            'shipment_id' => [$shipmentId],
        ]);
    }

    // ============================================
    // 5. TRACK BY AWB
    // ============================================
    public function trackByAwb(string $awb): array
    {
        return $this->request('GET', '/courier/track/awb/' . $awb);
    }

    // ============================================
    // 6. CANCEL ORDER
    // ============================================
    public function cancelOrder(int $shiprocketOrderId): array
    {
        return $this->request('POST', '/orders/cancel', [
            'ids' => [$shiprocketOrderId],
        ]);
    }
}
