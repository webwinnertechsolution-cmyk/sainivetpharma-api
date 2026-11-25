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

    // Selected variant ki measurement hi use hogi; product fallback nahi.
    // No variant selected: product measurement use hogi. No defaults.
    protected function itemDimension($item, string $field): float
    {
        if ($item->variant_id !== null) {
            if (!$item->variant) {
                throw new \InvalidArgumentException('Selected variant not found for order item ' . $item->id);
            }
            return max(0, (float) ($item->variant->{$field} ?? 0));
        }

        if (!$item->product) {
            throw new \InvalidArgumentException('Product not found for order item ' . $item->id);
        }
        return max(0, (float) ($item->product->{$field} ?? 0));
    }

    // Order ka physical parcel. Missing values ko invent nahi karenge.
    public function packageDetails(Order $order): array
    {
        $order->loadMissing('items.product', 'items.variant');
        if ($order->items->isEmpty()) {
            throw new \InvalidArgumentException('Order has no items.');
        }

        $weight = 0.0;
        $length = 0.0;
        $breadth = 0.0;
        $height = 0.0;

        foreach ($order->items as $item) {
            $qty = (int) $item->quantity;
            if ($qty < 1) {
                throw new \InvalidArgumentException('Invalid quantity for order item ' . $item->id);
            }

            $w = $this->itemDimension($item, 'weight');
            $l = $this->itemDimension($item, 'length');
            $b = $this->itemDimension($item, 'breadth');
            $h = $this->itemDimension($item, 'height');

            if (max($w, $l, $b, $h) <= 0) {
                throw new \InvalidArgumentException('No physical measurement for order item ' . $item->id);
            }
            if ($w <= 0) {
                throw new \InvalidArgumentException('Weight missing for order item ' . $item->id . '; Shiprocket quote cannot be calculated.');
            }

            $weight += $w * $qty;
            $length = max($length, $l);
            $breadth = max($breadth, $b);
            $height += $h * $qty;
        }

        return [
            'weight' => round($weight, 3),
            'length' => round($length, 2),
            'breadth' => round($breadth, 2),
            'height' => round($height, 2),
        ];
    }

    // Read-only serviceability quote: does not create orders, AWB or pickup.
    // Weight in kg; dimensions (if available) in cm.
    public function getShippingQuote(string $deliveryPostcode, float $weight, bool $cod = false, ?float $declaredValue = null): array
    {
        $deliveryPostcode = trim($deliveryPostcode);
        if (!preg_match('/^[1-9][0-9]{5}$/', $deliveryPostcode)) {
            throw new \InvalidArgumentException('Valid 6-digit delivery PIN code required.');
        }
        if (!is_finite($weight) || $weight <= 0) {
            throw new \InvalidArgumentException('Actual product weight is required; no default weight allowed.');
        }

        $pickup = (string) config('services.shiprocket.pickup_postcode', '140507');
        $params = [
            'pickup_postcode' => $pickup,
            'delivery_postcode' => $deliveryPostcode,
            'weight' => $weight,
            'cod' => $cod ? 1 : 0,
        ];
        if ($declaredValue !== null && is_finite($declaredValue) && $declaredValue >= 0) {
            $params['declared_value'] = $declaredValue;
        }

        $response = $this->request('GET', '/courier/serviceability/', $params);
        $couriers = $response['data']['available_courier_companies'] ?? [];
        $options = [];
        foreach ($couriers as $courier) {
            $rate = $courier['rate'] ?? null;
            $id = $courier['courier_company_id'] ?? null;
            if (!is_numeric($rate) || (float) $rate <= 0 || !$id) {
                continue;
            }
            $options[] = [
                'courier_company_id' => (int) $id,
                'courier_name' => (string) ($courier['courier_name'] ?? 'Courier'),
                'charge' => round((float) $rate, 2),
                'estimated_delivery_days' => $courier['estimated_delivery_days'] ?? null,
            ];
        }
        usort($options, fn ($a, $b) => $a['charge'] <=> $b['charge']);
        if (!$options) {
            throw new \RuntimeException('No Shiprocket courier available for this PIN and parcel weight.');
        }

        return [
            'success' => true,
            'pickup_postcode' => $pickup,
            'delivery_postcode' => $deliveryPostcode,
            'weight' => $weight,
            'payment_method' => $cod ? 'cod' : 'prepaid',
            'selected' => $options[0],
            'methods' => $options,
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

            // Free item (Buy X Get Y) ka SKU alag rakho, warna duplicate SKU ho jayega
            if ((float) $item->unit_price <= 0) {
                $sku .= '-FREE';
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

    // ============================================
    // 7. FULL FLOW: order → AWB → pickup → label
    // Checkout aur admin button dono yahi use karte hain.
    // Har step ke baad DB save hota hai, to beech mein fail ho
    // to dobara chalane par wahi se aage badhega.
    // ============================================
    public function shipOrder(Order $order): array
    {
        $steps = [];

        try {
            // ── Step 1: Shiprocket par order banao ──
            if (!$order->shiprocket_order_id) {
                $res = $this->createOrder($order);

                if (empty($res['order_id']) || empty($res['shipment_id'])) {
                    throw new \Exception('Order create failed: ' . json_encode($res));
                }

                $order->update([
                    'shiprocket_order_id'    => $res['order_id'],
                    'shiprocket_shipment_id' => $res['shipment_id'],
                    'shipping_status'        => 'created',
                    'shiprocket_error'       => null,
                ]);

                $steps[] = 'order_created';
            }

            // Auto ship band hai to yahin ruk jao (client panel se khud ship karega)
            if (!filter_var(config('services.shiprocket.auto_ship', true), FILTER_VALIDATE_BOOLEAN)) {
                return ['success' => true, 'steps' => $steps];
            }

            $shipmentId = (int) $order->shiprocket_shipment_id;

            // ── Step 2: Courier + AWB ──
            if (!$order->awb_code) {
                $res = $this->assignAwb($shipmentId);
                $data = $res['response']['data'] ?? [];

                if (empty($data['awb_code'])) {
                    throw new \Exception('AWB assign failed: ' . ($res['message'] ?? json_encode($res)));
                }

                $order->update([
                    'awb_code'         => $data['awb_code'],
                    'courier_name'     => $data['courier_name'] ?? null,
                    'shipping_status'  => 'awb_assigned',
                    'shiprocket_error' => null,
                ]);

                $steps[] = 'awb_assigned';
            }

            // ── Step 3: Pickup request ──
            if (!$order->pickup_scheduled_at) {
                $this->generatePickup($shipmentId);

                $order->update([
                    'pickup_scheduled_at' => now(),
                    'shipping_status'     => 'pickup_scheduled',
                    'order_status'        => 'processing',
                    'shiprocket_error'    => null,
                ]);

                $steps[] = 'pickup_scheduled';
            }

            // ── Step 4: Label PDF ──
            if (!$order->label_url) {
                $res = $this->generateLabel($shipmentId);

                if (!empty($res['label_url'])) {
                    $order->update(['label_url' => $res['label_url']]);
                    $steps[] = 'label_generated';
                }
            }

            return ['success' => true, 'steps' => $steps];

        } catch (\Throwable $e) {
            $order->update(['shiprocket_error' => $e->getMessage()]);

            Log::error('Shiprocket shipOrder failed', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);

            return ['success' => false, 'steps' => $steps, 'error' => $e->getMessage()];
        }
    }
}
