<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
            'subtotal' => 'required|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
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
                'order_status' => $request->payment_method === 'razorpay' ? 'pending' : 'pending',
                'email' => $request->email,
                'phone' => $request->phone,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zip' => $request->zip,
                'subtotal' => $request->subtotal,
                'shipping_cost' => $request->shipping ?? 0,
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

                $unitPrice = $product->sale_price ?? $product->price;
                $totalPrice = $unitPrice * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->title,
                    'product_slug' => $product->slug,
                    'product_sku' => $product->sku,
                    'product_image' => $product->featured_image,
                    'unit_price' => $unitPrice,
                    'quantity' => $item['quantity'],
                    'total_price' => $totalPrice,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
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

            $api->utility->verifyPaymentSignature($attributes);

            // Signature verified - update order
            $order->update([
                'payment_status' => 'paid',
                'payment_transaction_id' => $request->razorpay_payment_id,
                'order_status' => 'confirmed',
                'paid_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully!',
                'order' => $order,
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
            $order = Order::with('items')->where('order_number', $orderNumber)->first();

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
}
