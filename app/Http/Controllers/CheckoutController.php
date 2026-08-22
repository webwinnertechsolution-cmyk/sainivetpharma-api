<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\DiscountUsage;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Discount;
use App\Models\DiscountRule;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use App\Models\ShippingMethod;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    // ============================================
    // 1. GET RAZORPAY KEY (For Frontend)
    // ============================================
    public function apiGetRazorpayKey(Request $request)
    {
        return response()->json([
            'success' => true,
            'key' => env('RAZORPAY_KEY_ID'),
        ]);
    }

    // ============================================
    // 2. PLACE ORDER (Direct without payment)
    // ============================================
    public function apiPlaceOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Customer
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            
            // Shipping Address
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            
            // Order Items
            'items' => 'required|array|min:1',
            'items.*.id' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
            
            // Pricing
            'subtotal' => 'required|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            
            // Payment
            'payment_method' => 'required|string|in:cod,bank_transfer,razorpay',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Generate order number
            $orderNumber = Order::generateOrderNumber();

            // Create Order
            $order = Order::create([
                'order_number' => $orderNumber,
                'order_status' => $request->payment_method === 'razorpay' ? 'pending_payment' : 'pending',
                'customer_type' => 'guest',
                'email' => $request->email,
                'phone' => $request->phone,
                
                'shipping_first_name' => $request->first_name,
                'shipping_last_name' => $request->last_name,
                'shipping_address' => $request->address,
                'shipping_apartment' => $request->apartment,
                'shipping_city' => $request->city,
                'shipping_state' => $request->state,
                'shipping_country' => $request->country,
                'shipping_zip' => $request->zip,
                'shipping_phone' => $request->phone,
                
                'billing_first_name' => $request->first_name,
                'billing_last_name' => $request->last_name,
                'billing_address' => $request->address,
                'billing_city' => $request->city,
                'billing_state' => $request->state,
                'billing_country' => $request->country,
                'billing_zip' => $request->zip,
                
                'subtotal' => $request->subtotal,
                'shipping_cost' => $request->shipping ?? 0,
                'tax_amount' => 0,
                'total' => $request->total,
                'currency' => 'INR',
                
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Create Order Items
            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                
                if (!$product) {
                    throw new \Exception("Product not found: {$item['id']}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->title,
                    'product_slug' => $product->slug,
                    'product_sku' => $product->sku,
                    'unit_price' => $product->sale_price ?? $product->price,
                    'quantity' => $item['quantity'],
                    'total_price' => ($product->sale_price ?? $product->price) * $item['quantity'],
                    'product_image' => $product->featured_image,
                ]);
            }

            // Create Status History
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status_to' => $request->payment_method === 'razorpay' ? 'pending_payment' : 'pending',
                'changed_by' => 'system',
                'notes' => 'Order placed successfully',
            ]);

            DB::commit();

            // If Razorpay, return order ID for payment
            if ($request->payment_method === 'razorpay') {
                return response()->json([
                    'success' => true,
                    'message' => 'Order created. Ready for payment.',
                    'order' => [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'total' => $order->total,
                    ],
                ], 201);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => $order->order_status,
                    'total' => $order->total,
                    'payment_method' => $order->payment_method,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
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

            // Initialize Razorpay API
            $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

            // Verify signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            // This will throw exception if signature is invalid
            $api->utility->verifyPaymentSignature($attributes);

            // Signature verified - update order
            $order->update([
                'payment_status' => 'paid',
                'payment_transaction_id' => $request->razorpay_payment_id,
                'order_status' => 'confirmed',
                'paid_at' => now(),
            ]);

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status_from' => 'pending_payment',
                'status_to' => 'confirmed',
                'changed_by' => 'razorpay',
                'notes' => 'Payment verified. Transaction ID: ' . $request->razorpay_payment_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully!',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => $order->order_status,
                    'payment_status' => $order->payment_status,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage(),
            ], 400);
        }
    }

    // ============================================
    // 4. GET ORDER DETAILS
    // ============================================
    public function apiGetOrder($orderNumber)
    {
        try {
            $order = Order::with(['items', 'statusHistories'])
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
                'message' => 'Failed to fetch order: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // 5. CALCULATE CHECKOUT (For verification)
    // ============================================
    public function apiCalculateCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.id' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
            'country' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $items = $request->items;
            $subtotal = 0;
            $calculatedItems = [];

            // Calculate item prices
            foreach ($items as $item) {
                $product = Product::find($item['id']);
                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found: ' . $item['id']
                    ], 404);
                }

                $unitPrice = $product->sale_price ?? $product->price;
                $itemTotal = $unitPrice * $item['quantity'];

                $calculatedItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->title,
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'item_total' => $itemTotal,
                ];

                $subtotal += $itemTotal;
            }

            // Calculate shipping (simple logic - no free shipping for now)
            $country = strtolower(trim($request->get('country', 'India')));
            $shippingCost = $country === 'india' ? 0 : 100; // Flat rate outside India

            $total = $subtotal + $shippingCost;

            return response()->json([
                'success' => true,
                'summary' => [
                    'subtotal' => round($subtotal, 2),
                    'shipping_cost' => round($shippingCost, 2),
                    'total' => round($total, 2),
                    'currency' => 'INR',
                ],
                'items' => $calculatedItems,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Calculation failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
