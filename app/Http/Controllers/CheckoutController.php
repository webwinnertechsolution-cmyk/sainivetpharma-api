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
use App\Models\DiscountBxgy;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use App\Models\ShippingMethod;

class CheckoutController extends Controller
{
    // ============================================
    // 1. CALCULATE CHECKOUT (Discount + Shipping)
    // ============================================
    public function apiCalculateCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.variant_id' => 'nullable|integer|exists:product_variants,id',
            'country' => 'nullable|string|max:100',
            'cart_total' => 'nullable|numeric|min:0',
            'discount_code' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $items = $request->items;
            $country = strtolower(trim($request->get('country', 'India')));
            $cartTotal = 0;
            $subtotal = 0;
            $calculatedItems = [];

            // Calculate item prices
            foreach ($items as $item) {
                $product = Product::with(['variants', 'images'])->find($item['product_id']);
                if (!$product || $product->status !== 'published') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found or unavailable: ' . $item['product_id']
                    ], 404);
                }

                $variant = null;
                if (!empty($item['variant_id'])) {
                    $variant = $product->variants->where('id', $item['variant_id'])->first();
                }

                $originalPrice = $variant ? ($variant->price ?? $product->price) : $product->price;
                $salePrice = $variant ? ($variant->compare_price ?? $product->sale_price) : $product->sale_price;
                
                $unitPrice = $salePrice ?? $originalPrice;
                $itemTotal = $unitPrice * $item['quantity'];

                $calculatedItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->title,
                    'product_slug' => $product->slug,
                    'product_sku' => $variant ? $variant->sku : $product->sku,
                    'variant_id' => $variant ? $variant->id : null,
                    'variant_name' => $variant ? $variant->name : null,
                    'variant_attributes' => $variant ? $variant->attributes : null,
                    'original_price' => $originalPrice,
                    'sale_price' => $salePrice,
                    'unit_price' => $unitPrice,
                    'quantity' => $item['quantity'],
                    'item_total' => $itemTotal,
                    'product_image' => $product->featured_image,
                ];

                $subtotal += $itemTotal;
            }

            $cartTotal = $subtotal;

            // ============================================
            // DISCOUNT CALCULATION
            // ============================================
            $discountAmount = 0;
            $discountCode = null;
            $discountType = null;
            $discountDetails = null;
            $appliedDiscount = null;

            // Check discount code if provided
            if ($request->filled('discount_code')) {
                $appliedDiscount = $this->applyDiscountCode($request->discount_code, $calculatedItems, $cartTotal);
                if ($appliedDiscount['success']) {
                    $discountAmount = $appliedDiscount['discount_amount'];
                    $discountCode = $request->discount_code;
                    $discountType = $appliedDiscount['discount_type'];
                    $discountDetails = $appliedDiscount['discount_details'];
                    
                    // Update item prices with discount
                    $calculatedItems = $appliedDiscount['items'];
                }
            }

            // Check automatic discounts (if no code discount applied)
            if ($discountAmount == 0) {
                $autoDiscount = $this->applyAutomaticDiscounts($calculatedItems, $cartTotal);
                if ($autoDiscount['success']) {
                    $discountAmount = $autoDiscount['discount_amount'];
                    $discountType = $autoDiscount['discount_type'];
                    $discountDetails = $autoDiscount['discount_details'];
                    $calculatedItems = $autoDiscount['items'];
                }
            }

            // ============================================
            // SHIPPING CALCULATION
            // ============================================
            $shippingResult = $this->calculateShipping($cartTotal - $discountAmount, $country);
            $shippingCost = $shippingResult['cost'];
            $shippingDiscount = $shippingResult['discount'];
            $isFreeShipping = $shippingResult['is_free'];
            $shippingMethods = $shippingResult['methods'];

            // ============================================
            // FINAL CALCULATION
            // ============================================
            $taxAmount = 0; // Add tax logic if needed
            $total = $cartTotal - $discountAmount + $shippingCost - $shippingDiscount;

            return response()->json([
                'success' => true,
                'summary' => [
                    'subtotal' => round($subtotal, 2),
                    'discount_amount' => round($discountAmount, 2),
                    'discount_code' => $discountCode,
                    'discount_type' => $discountType,
                    'shipping_cost' => round($shippingCost, 2),
                    'shipping_discount' => round($shippingDiscount, 2),
                    'is_free_shipping' => $isFreeShipping,
                    'tax_amount' => round($taxAmount, 2),
                    'total' => round($total, 2),
                    'currency' => 'USD',
                ],
                'items' => $calculatedItems,
                'shipping_methods' => $shippingMethods,
                'discount_details' => $discountDetails,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Calculation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // 2. PLACE ORDER (Save to Database)
    // ============================================
    public function apiPlaceOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Customer
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            
            // Shipping Address
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:500',
            'shipping_apartment' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_country' => 'required|string|max:255',
            'shipping_zip' => 'required|string|max:20',
            
            // Billing Address (optional, defaults to shipping)
            'billing_same_as_shipping' => 'nullable|boolean',
            'billing_first_name' => 'nullable|string|max:255',
            'billing_last_name' => 'nullable|string|max:255',
            'billing_address' => 'nullable|string|max:500',
            'billing_city' => 'nullable|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_country' => 'nullable|string|max:255',
            'billing_zip' => 'nullable|string|max:20',
            
            // Order Items
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.variant_id' => 'nullable|integer|exists:product_variants,id',
            
            // Pricing (from frontend calculation)
            'subtotal' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_code' => 'nullable|string|max:100',
            'discount_type' => 'nullable|string|max:50',
            'shipping_method' => 'nullable|string|max:255',
            'shipping_rate_id' => 'nullable|integer',
            'shipping_cost' => 'required|numeric|min:0',
            'shipping_discount' => 'nullable|numeric|min:0',
            'is_free_shipping' => 'nullable|boolean',
            'tax_amount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            
            // Payment
            'payment_method' => 'required|string|max:100',
            
            // Optional
            'customer_note' => 'nullable|string|max:2000',
            'firebase_uid' => 'nullable|string|max:255',
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
            // Verify cart calculation
            $calcResult = $this->verifyCartCalculation($request);
            if (!$calcResult['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $calcResult['message']
                ], 400);
            }

            // Generate order number
            $orderNumber = Order::generateOrderNumber();

            // Prepare billing address
            $billingSameAsShipping = $request->get('billing_same_as_shipping', true);
            $billingFirstName = $billingSameAsShipping ? $request->shipping_first_name : $request->billing_first_name;
            $billingLastName = $billingSameAsShipping ? $request->shipping_last_name : $request->billing_last_name;
            $billingAddress = $billingSameAsShipping ? $request->shipping_address : $request->billing_address;
            $billingCity = $billingSameAsShipping ? $request->shipping_city : $request->billing_city;
            $billingState = $billingSameAsShipping ? $request->shipping_state : $request->billing_state;
            $billingCountry = $billingSameAsShipping ? $request->shipping_country : $request->billing_country;
            $billingZip = $billingSameAsShipping ? $request->shipping_zip : $request->billing_zip;

            // Create Order
            $order = Order::create([
                'order_number' => $orderNumber,
                'order_status' => 'pending',
                'customer_type' => $request->firebase_uid ? 'registered' : 'guest',
                'firebase_uid' => $request->firebase_uid,
                'email' => $request->email,
                'phone' => $request->phone,
                
                'shipping_first_name' => $request->shipping_first_name,
                'shipping_last_name' => $request->shipping_last_name,
                'shipping_address' => $request->shipping_address,
                'shipping_apartment' => $request->shipping_apartment,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_country' => $request->shipping_country,
                'shipping_zip' => $request->shipping_zip,
                'shipping_phone' => $request->phone,
                
                'billing_first_name' => $billingFirstName,
                'billing_last_name' => $billingLastName,
                'billing_address' => $billingAddress,
                'billing_city' => $billingCity,
                'billing_state' => $billingState,
                'billing_country' => $billingCountry,
                'billing_zip' => $billingZip,
                
                'subtotal' => $request->subtotal,
                'discount_amount' => $request->discount_amount ?? 0,
                'discount_code' => $request->discount_code,
                'discount_type' => $request->discount_type,
                'discount_details' => $request->discount_details ?? null,
                
                'shipping_method' => $request->shipping_method,
                'shipping_rate_id' => $request->shipping_rate_id,
                'shipping_cost' => $request->shipping_cost,
                'shipping_discount' => $request->shipping_discount ?? 0,
                'is_free_shipping' => $request->is_free_shipping ?? false,
                
                'tax_amount' => $request->tax_amount ?? 0,
                'total' => $request->total,
                'currency' => 'USD',
                
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                
                'customer_note' => $request->customer_note,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Create Order Items
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $variant = !empty($item['variant_id']) ? ProductVariant::find($item['variant_id']) : null;

                $originalPrice = $variant ? ($variant->price ?? $product->price) : $product->price;
                $salePrice = $variant ? ($variant->compare_price ?? $product->sale_price) : $product->sale_price;
                $unitPrice = $salePrice ?? $originalPrice;
                
                // Check if item has discount applied
                $itemDiscount = $item['discount_per_unit'] ?? 0;
                $finalUnitPrice = $unitPrice - $itemDiscount;
                $itemTotal = $finalUnitPrice * $item['quantity'];
                $itemDiscountTotal = $itemDiscount * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->title,
                    'product_slug' => $product->slug,
                    'product_sku' => $variant ? $variant->sku : $product->sku,
                    'variant_id' => $variant ? $variant->id : null,
                    'variant_name' => $variant ? $variant->name : null,
                    'variant_attributes' => $variant ? $variant->attributes : null,
                    'original_price' => $originalPrice,
                    'sale_price' => $salePrice,
                    'unit_price' => $finalUnitPrice,
                    'quantity' => $item['quantity'],
                    'total_price' => $itemTotal,
                    'discount_per_unit' => $itemDiscount,
                    'item_discount_total' => $itemDiscountTotal,
                    'discount_applied' => $item['discount_applied'] ?? null,
                    'is_free_item' => $item['is_free_item'] ?? false,
                    'parent_item_id' => $item['parent_item_id'] ?? null,
                    'bxgy_discount_id' => $item['bxgy_discount_id'] ?? null,
                    'product_image' => $product->featured_image,
                    'tax_amount' => 0,
                ]);
            }

            // Create Status History
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status_from' => null,
                'status_to' => 'pending',
                'changed_by' => 'system',
                'notes' => 'Order placed successfully',
            ]);

            // Record Discount Usage (if discount applied)
            if ($request->discount_code || $request->discount_type) {
                $discount = Discount::where('code', $request->discount_code)->first();
                if ($discount) {
                    DiscountUsage::create([
                        'discount_id' => $discount->id,
                        'order_id' => $order->id,
                        'customer_email' => $request->email,
                        'firebase_uid' => $request->firebase_uid,
                        'discount_amount' => $request->discount_amount ?? 0,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => $order->order_status,
                    'total' => $order->total,
                    'payment_status' => $order->payment_status,
                    'created_at' => $order->created_at,
                ],
                'redirect_url' => '/checkout/success?order=' . $order->order_number,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Order failed: ' . $e->getMessage(),
                'error' => $e->getTraceAsString(),
            ], 500);
        }
    }

    // ============================================
    // 3. GET ORDER DETAILS
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
    // 4. UPDATE PAYMENT STATUS
    // ============================================
    public function apiUpdatePayment(Request $request, $orderId)
    {
        $validator = Validator::make($request->all(), [
            'payment_status' => 'required|in:pending,paid,failed,refunded,partially_refunded',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = Order::findOrFail($orderId);
            
            $oldStatus = $order->payment_status;
            
            $order->update([
                'payment_status' => $request->payment_status,
                'payment_transaction_id' => $request->transaction_id,
                'paid_at' => $request->payment_status === 'paid' ? now() : $order->paid_at,
            ]);

            // Status history
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status_from' => $oldStatus,
                'status_to' => $request->payment_status,
                'changed_by' => 'payment_gateway',
                'notes' => 'Payment status updated to ' . $request->payment_status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated',
                'order' => $order,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // HELPER: Apply Discount Code
    // ============================================
    private function applyDiscountCode($code, $items, $cartTotal)
    {
        $now = now();
        
        $discount = Discount::where('code', strtoupper($code))
            ->where('is_active', 1)
            ->where('method', 'discount_code')
            ->where(function($q) use ($now) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function($q) use ($now) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            })
            ->with('rule')
            ->first();

        if (!$discount) {
            return ['success' => false, 'message' => 'Invalid or expired discount code'];
        }

        // Check max uses
        if ($discount->rule && $discount->rule->max_uses_total) {
            $usedCount = DiscountUsage::where('discount_id', $discount->id)->count();
            if ($usedCount >= $discount->rule->max_uses_total) {
                return ['success' => false, 'message' => 'Discount code usage limit reached'];
            }
        }

        return $this->calculateDiscount($discount, $items, $cartTotal);
    }

    // ============================================
    // HELPER: Apply Automatic Discounts
    // ============================================
    private function applyAutomaticDiscounts($items, $cartTotal)
    {
        $now = now();
        
        $discounts = Discount::where('is_active', 1)
            ->where('method', 'automatic')
            ->where(function($q) use ($now) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function($q) use ($now) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            })
            ->with('rule')
            ->orderBy('value', 'desc')
            ->get();

        $bestDiscount = null;
        $maxDiscount = 0;

        foreach ($discounts as $discount) {
            $result = $this->calculateDiscount($discount, $items, $cartTotal);
            if ($result['success'] && $result['discount_amount'] > $maxDiscount) {
                $maxDiscount = $result['discount_amount'];
                $bestDiscount = $result;
            }
        }

        return $bestDiscount ?? ['success' => false, 'message' => 'No automatic discount applicable'];
    }

    // ============================================
    // HELPER: Calculate Discount Amount
    // ============================================
    private function calculateDiscount($discount, $items, $cartTotal)
    {
        $rule = $discount->rule;
        $discountAmount = 0;
        $updatedItems = $items;

        // Check minimum requirements
        if ($rule) {
            if ($rule->min_requirement === 'min_amount' && $rule->min_amount && $cartTotal < $rule->min_amount) {
                return ['success' => false, 'message' => 'Minimum cart amount not met'];
            }
            if ($rule->min_requirement === 'min_quantity' && $rule->min_quantity) {
                $totalQty = collect($items)->sum('quantity');
                if ($totalQty < $rule->min_quantity) {
                    return ['success' => false, 'message' => 'Minimum quantity not met'];
                }
            }
        }

        switch ($discount->type) {
            case 'amount_off_products':
                // Percentage or Fixed off specific products
                $applicableItems = $this->getApplicableItems($items, $discount);
                foreach ($applicableItems as $key => $item) {
                    $itemDiscount = 0;
                    if ($discount->value_type === 'percentage') {
                        $itemDiscount = ($item['unit_price'] * $discount->value / 100) * $item['quantity'];
                    } else {
                        $itemDiscount = min($discount->value * $item['quantity'], $item['unit_price'] * $item['quantity']);
                    }
                    $discountAmount += $itemDiscount;
                    $updatedItems[$key]['discount_per_unit'] = $itemDiscount / $item['quantity'];
                    $updatedItems[$key]['item_discount_total'] = $itemDiscount;
                    $updatedItems[$key]['discount_applied'] = [
                        'discount_id' => $discount->id,
                        'discount_title' => $discount->title,
                        'discount_type' => $discount->type,
                        'value_type' => $discount->value_type,
                        'value' => $discount->value,
                    ];
                }
                break;

            case 'amount_off_order':
                // Percentage or Fixed off entire order
                if ($discount->value_type === 'percentage') {
                    $discountAmount = $cartTotal * $discount->value / 100;
                } else {
                    $discountAmount = min($discount->value, $cartTotal);
                }
                // Distribute evenly across items
                $perItemDiscount = $discountAmount / collect($items)->sum('quantity');
                foreach ($updatedItems as $key => $item) {
                    $updatedItems[$key]['discount_per_unit'] = $perItemDiscount;
                    $updatedItems[$key]['item_discount_total'] = $perItemDiscount * $item['quantity'];
                    $updatedItems[$key]['discount_applied'] = [
                        'discount_id' => $discount->id,
                        'discount_title' => $discount->title,
                        'discount_type' => $discount->type,
                        'value_type' => $discount->value_type,
                        'value' => $discount->value,
                    ];
                }
                break;

            case 'buy_x_get_y':
                // Buy X Get Y logic
                $bxgy = $discount->bxgy;
                if (!$bxgy) {
                    return ['success' => false, 'message' => 'BXGY configuration not found'];
                }
                
                $totalQty = collect($items)->sum('quantity');
                $applicableSets = floor($totalQty / $bxgy->buy_quantity);
                $freeQty = $applicableSets * $bxgy->get_quantity;
                
                if ($freeQty > 0) {
                    // Add free items
                    $cheapestItem = collect($items)->sortBy('unit_price')->first();
                    $updatedItems[] = [
                        'product_id' => $cheapestItem['product_id'],
                        'product_name' => $cheapestItem['product_name'] . ' (FREE)',
                        'product_slug' => $cheapestItem['product_slug'],
                        'product_sku' => $cheapestItem['product_sku'],
                        'variant_id' => $cheapestItem['variant_id'],
                        'variant_name' => $cheapestItem['variant_name'],
                        'original_price' => $cheapestItem['unit_price'],
                        'sale_price' => 0,
                        'unit_price' => 0,
                        'quantity' => $freeQty,
                        'item_total' => 0,
                        'is_free_item' => true,
                        'parent_item_id' => null,
                        'bxgy_discount_id' => $discount->id,
                        'product_image' => $cheapestItem['product_image'],
                        'discount_applied' => [
                            'discount_id' => $discount->id,
                            'discount_title' => $discount->title,
                            'discount_type' => 'buy_x_get_y',
                            'buy_qty' => $bxgy->buy_quantity,
                            'get_qty' => $bxgy->get_quantity,
                        ],
                    ];
                    $discountAmount = $cheapestItem['unit_price'] * $freeQty;
                }
                break;

            case 'free_shipping':
                // Shipping discount handled separately
                $discountAmount = 0;
                break;
        }

        return [
            'success' => true,
            'discount_amount' => round($discountAmount, 2),
            'discount_type' => $discount->type,
            'discount_details' => [
                'discount_id' => $discount->id,
                'title' => $discount->title,
                'code' => $discount->code,
                'type' => $discount->type,
                'value_type' => $discount->value_type,
                'value' => $discount->value,
            ],
            'items' => $updatedItems,
        ];
    }

    // ============================================
    // HELPER: Get Applicable Items for Discount
    // ============================================
    private function getApplicableItems($items, $discount)
    {
        $applicableProductIds = $discount->products()
            ->where('product_type', 'product')
            ->pluck('product_id')
            ->toArray();

        $applicableCollectionIds = $discount->products()
            ->where('product_type', 'collection')
            ->pluck('product_id')
            ->toArray();

        if (empty($applicableProductIds) && empty($applicableCollectionIds)) {
            // All products applicable
            return $items;
        }

        return collect($items)->filter(function($item) use ($applicableProductIds, $applicableCollectionIds) {
            if (in_array($item['product_id'], $applicableProductIds)) {
                return true;
            }
            // Check if product belongs to applicable collection
            $product = Product::find($item['product_id']);
            if ($product) {
                $productCollectionIds = $product->categories->pluck('id')->toArray();
                return !empty(array_intersect($productCollectionIds, $applicableCollectionIds));
            }
            return false;
        })->values()->toArray();
    }

    // ============================================
    // HELPER: Calculate Shipping
    // ============================================
    private function calculateShipping($cartTotal, $country)
    {
        $now = now();
        
        // Check free shipping discount
        $freeShippingDiscount = Discount::where('is_active', 1)
            ->where('type', 'free_shipping')
            ->where(function($q) use ($now) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function($q) use ($now) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            })
            ->with('rule')
            ->first();

        $isFreeShipping = false;
        $shippingDiscount = 0;

        if ($freeShippingDiscount && $freeShippingDiscount->rule) {
            $minAmount = $freeShippingDiscount->rule->min_amount ?? 0;
            if ($cartTotal >= $minAmount) {
                $isFreeShipping = true;
            }
        }

        // Find shipping zone
        $zones = ShippingZone::where('is_active', 1)->get();
        $matchedZone = null;

        foreach ($zones as $zone) {
            $countries = $zone->countries ?? [];
            $countriesLower = array_map('strtolower', array_map('trim', $countries));
            
            if (empty($countries)) {
                if (!$matchedZone) $matchedZone = $zone;
            } elseif (in_array($country, $countriesLower)) {
                $matchedZone = $zone;
                break;
            }
        }

        $methods = [];
        $shippingCost = 0;

        if ($matchedZone) {
            $rates = ShippingRate::with('method')
                ->where('zone_id', $matchedZone->id)
                ->where('is_active', 1)
                ->get();

            foreach ($rates as $rate) {
                if (!$rate->method || !$rate->method->is_active) continue;

                $charge = 0;
                $eligible = true;

                switch ($rate->rate_type) {
                    case 'free':
                        $charge = 0;
                        break;
                    case 'flat_rate':
                        $charge = $isFreeShipping ? 0 : (float) $rate->base_rate;
                        break;
                    case 'cart_value':
                        if ($rate->min_cart_value && $cartTotal < $rate->min_cart_value) {
                            $eligible = false;
                        } else {
                            $charge = $isFreeShipping ? 0 : (float) $rate->base_rate;
                        }
                        break;
                    case 'weight_based':
                        $charge = $isFreeShipping ? 0 : (float) $rate->base_rate;
                        break;
                }

                if (!$eligible) continue;

                $methods[] = [
                    'rate_id' => $rate->id,
                    'method_id' => $rate->method->id,
                    'name' => $rate->method->name,
                    'description' => $rate->method->description,
                    'delivery_time' => $rate->method->delivery_time,
                    'charge' => $charge,
                    'original_charge' => (float) $rate->base_rate,
                    'rate_type' => $rate->rate_type,
                    'cod_available' => $rate->cod_available,
                    'cod_charge' => (float) $rate->cod_charge,
                    'is_free' => $charge == 0,
                ];
            }

            usort($methods, fn($a, $b) => $a['charge'] <=> $b['charge']);
            
            if (!empty($methods)) {
                $shippingCost = $methods[0]['charge'];
                $shippingDiscount = $isFreeShipping ? $methods[0]['original_charge'] : 0;
            }
        }

        return [
            'cost' => $shippingCost,
            'discount' => $shippingDiscount,
            'is_free' => $isFreeShipping,
            'methods' => $methods,
            'zone' => $matchedZone ? $matchedZone->name : null,
        ];
    }

    // ============================================
    // HELPER: Verify Cart Calculation
    // ============================================
    private function verifyCartCalculation(Request $request)
    {
        // Recalculate to verify frontend numbers
        $calcRequest = new Request([
            'items' => $request->items,
            'country' => $request->shipping_country ?? 'India',
            'discount_code' => $request->discount_code,
        ]);

        $result = $this->apiCalculateCheckout($calcRequest);
        $data = $result->getData(true);

        if (!$data['success']) {
            return ['success' => false, 'message' => $data['message']];
        }

        // Allow small rounding differences (0.01)
        $frontendTotal = round($request->total, 2);
        $backendTotal = round($data['summary']['total'], 2);

        if (abs($frontendTotal - $backendTotal) > 0.02) {
            return [
                'success' => false,
                'message' => 'Cart total mismatch. Please refresh and try again.',
                'expected' => $backendTotal,
                'received' => $frontendTotal,
            ];
        }

        return ['success' => true];
    }
}
