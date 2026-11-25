<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Customer;

use App\Services\ShiprocketService;

use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    // ============================================
    // 0. CALCULATE CHECKOUT
    // ============================================
    public function apiCalculateCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.variant' => 'nullable|string|max:255',
            'items.*.is_free' => 'nullable|boolean',
            'zip' => ['required', 'regex:/^[1-9][0-9]{5}$/'],
            'payment_method' => 'required|in:cod,bank,razorpay',
        ]);
        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        try {
            $pricing = $this->calculateVerifiedQuote($request->items, $request->zip, $request->payment_method);
            unset($pricing['resolved']);
            return response()->json(['success' => true] + $pricing);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            Log::warning('Shipping quote unavailable', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Shipping quote unavailable. Please retry.'], 503);
        }
    }

    // ============================================
    // 1. GET RAZORPAY KEY
    // ============================================
    public function apiGetRazorpayKey(Request $request)
    {
        return response()->json([
            'success' => true,
            'key' => config('services.razorpay.key'),
        ]);
    }


    // ============================================
    // 2. PLACE ORDER
    // ============================================
    public function apiPlaceOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',

            'address' => 'required|string|max:500',
            'apartment' => 'nullable|string|max:255',

            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip' => 'required|string|max:20',

            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.variant' => 'nullable|string|max:255',
            'items.*.is_free' => 'nullable|boolean',

            'subtotal' => 'nullable|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',

            'payment_method' => 'required|string|in:cod,bank,razorpay',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate and quote BEFORE creating any customer/order/payment record.
        try {
            $pricing = $this->calculateVerifiedQuote($request->items, $request->zip, $request->payment_method);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            Log::warning('Checkout quote unavailable', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Shipping quote unavailable. Please retry.'], 503);
        }

        DB::beginTransaction();

        try {

            // ============================================
            // PHONE NORMALIZE
            // ============================================
            $phone = preg_replace('/\D+/', '', $request->phone);

            // +91 9876543210 -> 9876543210
            if (
                strlen($phone) > 10 &&
                str_starts_with($phone, '91')
            ) {
                $phone = substr($phone, -10);
            }

            if (strlen($phone) < 10) {
                throw new \Exception('Invalid phone number.');
            }


            // ============================================
            // FIND OR CREATE CUSTOMER
            // ============================================
            $customer = Customer::where('phone', $phone)->first();

            if (!$customer) {
                $customer = Customer::create([
                    'phone' => $phone,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                ]);
            } else {
                $customer->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                ]);
            }


            // ============================================
            // GENERATE ORDER NUMBER
            // ============================================
            $orderNumber = Order::generateOrderNumber();


            // ============================================
            // CREATE ORDER
            // ============================================
            $order = Order::create([
                'customer_id' => $customer->id,

                'order_number' => $orderNumber,
                'order_status' => 'pending',

                'email' => $request->email,
                'phone' => $phone,

                'first_name' => $request->first_name,
                'last_name' => $request->last_name,

                'address' => $request->address,
                'apartment' => $request->apartment,

                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zip' => $request->zip,

                'subtotal' => $pricing['subtotal'],
                'shipping_cost' => $pricing['shipping'],
                'total' => $pricing['total'],

                'currency' => 'INR',

                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',

                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);


            // ============================================
            // CREATE ORDER ITEMS (variant ke saath)
            // ============================================
            foreach ($pricing['resolved'] as $line) {
                $product = $line['product'];
                $variant = $line['variant'];
                $unitPrice = $line['unit_price'];
                $quantity = $line['quantity'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'variant_id' => $variant?->id,
                    'product_name' => $product->title,
                    'variant_name' => $variant?->name,
                    'product_slug' => $product->slug,
                    'product_sku' => ($variant && $variant->sku) ? $variant->sku : $product->sku,
                    'product_image' => $product->featured_image,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'total_price' => round($unitPrice * $quantity, 2),
                ]);
            }

            // ============================================
            // RAZORPAY ORDER
            // ============================================
            $razorpayOrderId = null;

            if ($request->payment_method === 'razorpay') {

                $api = new Api(
                    config('services.razorpay.key'),
                    config('services.razorpay.secret')
                );

                $razorpayOrder = $api->order->create([
                    'receipt' => $order->order_number,
                    'amount' => (int) round($order->total * 100),
                    'currency' => 'INR',
                    'notes' => [
                        'order_id' => $order->id,
                        'customer_id' => $customer->id,
                        'phone' => $customer->phone,
                        'email' => $order->email,
                    ],
                ]);

                $razorpayOrderId = $razorpayOrder['id'];

                $order->payment_transaction_id = $razorpayOrderId;
                $order->save();
            }


            DB::commit();


            // ============================================
            // COD ORDER → turant Shiprocket par bhejo
            // (Razorpay order payment verify ke baad jayega)
            // ============================================
            if ($request->payment_method === 'cod') {
                $this->sendToShiprocketAfterResponse($order->id);
            }


            // ============================================
            // SUCCESS RESPONSE
            // ============================================
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',

                'customer' => [
                    'id' => $customer->id,
                    'phone' => $customer->phone,
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'email' => $customer->email,
                    'name' => trim($customer->first_name . ' ' . $customer->last_name),
                ],

                'order' => [
                    'id' => $order->id,
                    'customer_id' => $customer->id,
                    'order_number' => $order->order_number,
                    'total' => $order->total,
                    'payment_method' => $order->payment_method,
                    'razorpay_order_id' => $razorpayOrderId,
                ],

            ], 201);


        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Order placement failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Order failed: ' . $e->getMessage(),
            ], 500);
        }
    }


    // ============================================
    // 3. RAZORPAY PAYMENT VERIFICATION
    // ============================================
    public function apiRazorpayVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'nullable|string',
            'razorpay_signature' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $order = Order::findOrFail($request->order_id);

            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );


            // ============================================
            // VERIFY PAYMENT SIGNATURE
            // ============================================
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);


            // ============================================
            // PAYMENT SUCCESS
            // ============================================
            $order->update([
                'payment_status' => 'paid',
                'payment_transaction_id' => $request->razorpay_payment_id,
                'order_status' => 'confirmed',
                'paid_at' => now(),
            ]);


            // ============================================
            // PAYMENT HO GAYA → Shiprocket par bhejo
            // (response jaane ke baad chalega, customer wait nahi karega)
            // ============================================
            $this->sendToShiprocketAfterResponse($order->id);


            $customer = null;

            if ($order->customer_id) {
                $customer = Customer::find($order->customer_id);
            }


            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully!',
                'order' => $order,
                'customer' => $customer,
            ]);


        } catch (\Exception $e) {

            if (isset($order)) {
                $order->update([
                    'payment_status' => 'failed'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage(),
            ], 400);
        }
    }


    // ============================================
    // 4. GET CUSTOMER ORDERS BY PHONE
    // ============================================
    public function apiGetCustomerOrders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number required.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $phone = preg_replace('/\D+/', '', $request->phone);

        if (
            strlen($phone) > 10 &&
            str_starts_with($phone, '91')
        ) {
            $phone = substr($phone, -10);
        }

        $customer = Customer::where('phone', $phone)->first();

        if (!$customer) {
            return response()->json([
                'success' => true,
                'customer' => null,
                'count' => 0,
                'orders' => [],
            ]);
        }

        $orders = Order::with('items')
            ->where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'customer' => $customer,
            'count' => $orders->count(),
            'orders' => $orders,
        ]);
    }


    // ============================================
    // 5. GET SINGLE ORDER
    // ============================================
    public function apiGetOrder($orderNumber)
    {
        try {

            $order = Order::with('items')
                ->where('order_number', $orderNumber)
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'order' => $order,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch order: ' . $e->getMessage(),
            ], 500);
        }
    }


    // ============================================
    // HELPERS
    // ============================================

    /**
     * Cart ka variant text saaf karo: "__FREE__2__5 L" -> "5 L"
     */
    // Centralized server-side pricing and Shiprocket quote; no client totals trusted.
    private function calculateVerifiedQuote(array $items, string $zip, string $paymentMethod): array
    {
        if (!preg_match('/^[1-9][0-9]{5}$/', trim($zip))) {
            throw new \InvalidArgumentException('Valid Indian 6-digit delivery PIN required.');
        }
        $subtotal = 0.0;
        $weight = 0.0;
        $resolved = [];
        foreach ($items as $item) {
            $product = Product::with('variants')->where('status', 'published')->find($item['id']);
            if (!$product) throw new \InvalidArgumentException('Product not available: ' . $item['id']);
            $variantText = $item['variant'] ?? null;
            $variant = $this->findVariant($product, $variantText);
            if ($this->cleanVariantName($variantText) !== '' && !$variant) {
                throw new \InvalidArgumentException('Selected variant not found for ' . $product->title);
            }
            $source = $variant ?: $product;
            $dimensions = [];
            foreach (['weight', 'length', 'breadth', 'height'] as $field) {
                $value = $source->{$field} ?? null;
                $dimensions[$field] = is_numeric($value) && (float)$value > 0 ? (float)$value : 0.0;
            }
            if (max($dimensions) <= 0) throw new \InvalidArgumentException('No measurements entered for ' . $product->title);
            if ($dimensions['weight'] <= 0) throw new \InvalidArgumentException('Actual weight missing for ' . $product->title . '; shipping cannot be quoted.');
            if (!empty($item['is_free'])) {
                // Do not trust the browser to grant itself free products.
                throw new \InvalidArgumentException('Free promotional items require server-side promotion verification.');
            }
            $price = $variant && (float)$variant->price > 0 ? (float)$variant->price : (float)($product->sale_price ?? $product->price);
            if ($price < 0) throw new \InvalidArgumentException('Invalid product price.');
            $qty = (int)$item['quantity'];
            $subtotal += $price * $qty;
            $weight += $dimensions['weight'] * $qty;
            $resolved[] = ['product' => $product, 'variant' => $variant, 'quantity' => $qty, 'unit_price' => $price];
        }
        $subtotal = round($subtotal, 2);
        $quote = app(ShiprocketService::class)->getShippingQuote(trim($zip), round($weight, 3), $paymentMethod === 'cod', $subtotal);
        $selected = $quote['selected'];
        $shipping = (float)$selected['charge'];
        return [
            'subtotal' => $subtotal, 'shipping' => $shipping,
            'total' => round($subtotal + $shipping, 2),
            'courier' => $selected, 'resolved' => $resolved,
        ];
    }

    private function cleanVariantName(?string $variant): string
    {
        if (!$variant) return '';
        return trim(preg_replace('/__FREE__\d*__/', '', $variant));
    }

    /**
     * Cart ke variant naam se product ka variant dhundo
     */
    private function findVariant(Product $product, ?string $variantText): ?ProductVariant
    {
        $name = $this->cleanVariantName($variantText);

        if ($name === '' || $product->variants->isEmpty()) {
            return null;
        }

        // 1. Exact naam match
        $exact = $product->variants->first(fn ($v) => trim($v->name) === $name);
        if ($exact) return $exact;

        // 2. Spaces/case ignore karke match ("5L" == "5 L")
        $normalize = fn ($s) => strtolower(preg_replace('/[^a-z0-9]/i', '', (string) $s));
        $target = $normalize($name);

        $loose = $product->variants->first(fn ($v) => $normalize($v->name) === $target);
        if ($loose) return $loose;

        // 3. "Size: 5 L" jaisa text ho to end match
        return $product->variants->first(function ($v) use ($normalize, $target) {
            $vn = $normalize($v->name);
            return $vn !== '' && str_ends_with($target, $vn);
        });
    }

    /**
     * Response bhejne ke baad Shiprocket par order bhejo.
     * Shiprocket fail ho to bhi customer ka order safe rahega.
     */
    private function sendToShiprocketAfterResponse(int $orderId): void
    {
        app()->terminating(function () use ($orderId) {
            try {
                $order = Order::find($orderId);

                if ($order) {
                    app(ShiprocketService::class)->shipOrder($order);
                }
            } catch (\Throwable $e) {
                Log::error('Shiprocket push failed for order ' . $orderId . ': ' . $e->getMessage());
            }
        });
    }
}
