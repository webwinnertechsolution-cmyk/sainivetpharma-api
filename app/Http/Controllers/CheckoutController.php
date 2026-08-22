<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;

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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $subtotal = 0;

        foreach ($request->items as $item) {
            $product = Product::find($item['id']);

            if ($product) {
                $unitPrice = $product->sale_price ?? $product->price;
                $subtotal += $unitPrice * $item['quantity'];
            }
        }

        $shipping = $subtotal >= 999 ? 0 : 60;

        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping,
        ]);
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

            'subtotal' => 'required|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',

            'payment_method' => 'required|string|in:cod,bank,razorpay',
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

            // ============================================
            // PHONE NORMALIZE
            // ============================================
            $phone = preg_replace('/\D+/', '', $request->phone);

            // Example:
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

                // New phone = new customer
                $customer = Customer::create([
                    'phone' => $phone,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                ]);

            } else {

                // Same phone = same customer
                // latest checkout details update
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

                'subtotal' => $request->subtotal,
                'shipping_cost' => $request->shipping ?? 0,
                'total' => $request->total,

                'currency' => 'INR',

                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',

                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);


            // ============================================
            // CREATE ORDER ITEMS
            // ============================================
            foreach ($request->items as $item) {

                $product = Product::find($item['id']);

                if (!$product) {
                    throw new \Exception(
                        "Product not found: {$item['id']}"
                    );
                }

                $unitPrice = $product->sale_price ?? $product->price;

                $totalPrice =
                    $unitPrice * $item['quantity'];

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

                    'amount' => (int) round(
                        $order->total * 100
                    ),

                    'currency' => 'INR',

                    'notes' => [
                        'order_id' => $order->id,
                        'customer_id' => $customer->id,
                        'phone' => $customer->phone,
                        'email' => $order->email,
                    ],
                ]);

                $razorpayOrderId =
                    $razorpayOrder['id'];

                $order->payment_transaction_id =
                    $razorpayOrderId;

                $order->save();
            }


            DB::commit();


            // ============================================
            // SUCCESS RESPONSE
            // ============================================
            return response()->json([
                'success' => true,

                'message' =>
                    'Order placed successfully!',

                // customer frontend ko milega
                'customer' => [
                    'id' => $customer->id,
                    'phone' => $customer->phone,
                    'first_name' => $customer->first_name,
                    'last_name' => $customer->last_name,
                    'email' => $customer->email,

                    'name' => trim(
                        $customer->first_name .
                        ' ' .
                        $customer->last_name
                    ),
                ],

                'order' => [
                    'id' => $order->id,
                    'customer_id' => $customer->id,

                    'order_number' =>
                        $order->order_number,

                    'total' =>
                        $order->total,

                    'payment_method' =>
                        $order->payment_method,

                    'razorpay_order_id' =>
                        $razorpayOrderId,
                ],

            ], 201);


        } catch (\Exception $e) {

            DB::rollBack();

            \Log::error(
                'Order placement failed: ' .
                $e->getMessage()
            );

            return response()->json([
                'success' => false,

                'message' =>
                    'Order failed: ' .
                    $e->getMessage(),

            ], 500);
        }
    }


    // ============================================
    // 3. RAZORPAY PAYMENT VERIFICATION
    // ============================================
    public function apiRazorpayVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' =>
                'required|integer|exists:orders,id',

            'razorpay_payment_id' =>
                'required|string',

            'razorpay_order_id' =>
                'nullable|string',

            'razorpay_signature' =>
                'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $order = Order::findOrFail(
                $request->order_id
            );

            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );


            // ============================================
            // VERIFY PAYMENT SIGNATURE
            // ============================================
            $attributes = [
                'razorpay_order_id' =>
                    $request->razorpay_order_id,

                'razorpay_payment_id' =>
                    $request->razorpay_payment_id,

                'razorpay_signature' =>
                    $request->razorpay_signature,
            ];

            $api->utility->verifyPaymentSignature(
                $attributes
            );


            // ============================================
            // PAYMENT SUCCESS
            // ============================================
            $order->update([
                'payment_status' => 'paid',

                'payment_transaction_id' =>
                    $request->razorpay_payment_id,

                'order_status' => 'confirmed',

                'paid_at' => now(),
            ]);


            $customer = null;

            if ($order->customer_id) {
                $customer = Customer::find(
                    $order->customer_id
                );
            }


            return response()->json([
                'success' => true,

                'message' =>
                    'Payment verified successfully!',

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

                'message' =>
                    'Payment verification failed: ' .
                    $e->getMessage(),

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


        $phone = preg_replace(
            '/\D+/',
            '',
            $request->phone
        );

        if (
            strlen($phone) > 10 &&
            str_starts_with($phone, '91')
        ) {
            $phone = substr($phone, -10);
        }


        $customer = Customer::where(
            'phone',
            $phone
        )->first();


        if (!$customer) {
            return response()->json([
                'success' => true,
                'customer' => null,
                'count' => 0,
                'orders' => [],
            ]);
        }


        $orders = Order::with('items')
            ->where(
                'customer_id',
                $customer->id
            )
            ->orderBy(
                'created_at',
                'desc'
            )
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
                ->where(
                    'order_number',
                    $orderNumber
                )
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

                'message' =>
                    'Failed to fetch order: ' .
                    $e->getMessage(),

            ], 500);
        }
    }
}
