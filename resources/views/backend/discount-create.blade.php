{{-- resources/views/backend/discount-create.blade.php --}}
@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('discount.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <h2 class="d-inline mb-0">
                        {{ isset($discount) ? 'Edit Discount' : 'Create Discount' }}
                    </h2>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Step 1: Select Type (only show when creating) --}}
            @if(!isset($discount))
            <div class="card mb-4" id="typeSelector">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Select Discount Type</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="type-card border rounded p-3 cursor-pointer h-100"
                                 onclick="selectType('amount_off_products')"
                                 id="type_amount_off_products">
                                <i class="fas fa-tag fa-2x text-primary mb-2 d-block"></i>
                                <h6>Amount off products</h6>
                                <small class="text-muted">Discount specific products or collections</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="type-card border rounded p-3 cursor-pointer h-100"
                                 onclick="selectType('buy_x_get_y')"
                                 id="type_buy_x_get_y">
                                <i class="fas fa-gift fa-2x text-info mb-2 d-block"></i>
                                <h6>Buy X Get Y</h6>
                                <small class="text-muted">Discount specific products or collections</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="type-card border rounded p-3 cursor-pointer h-100"
                                 onclick="selectType('amount_off_order')"
                                 id="type_amount_off_order">
                                <i class="fas fa-shopping-cart fa-2x text-warning mb-2 d-block"></i>
                                <h6>Amount off order</h6>
                                <small class="text-muted">Discount the total order amount</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="type-card border rounded p-3 cursor-pointer h-100"
                                 onclick="selectType('free_shipping')"
                                 id="type_free_shipping">
                                <i class="fas fa-truck fa-2x text-success mb-2 d-block"></i>
                                <h6>Free shipping</h6>
                                <small class="text-muted">Offer free shipping on an order</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Main Form --}}
            <form action="{{ isset($discount) ? route('discount.update', $discount->id) : route('discount.store') }}"
                  method="POST" id="discountForm" style="{{ !isset($discount) ? 'display:none' : '' }}">
                @csrf

                <input type="hidden" name="type" id="selectedType"
                       value="{{ isset($discount) ? $discount->type : '' }}">

                <div class="row">
                    {{-- Left Column --}}
                    <div class="col-md-8">

                        {{-- Title shown at top --}}
                        <div class="card mb-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0" id="formTypeTitle">Discount</h5>
                            </div>
                            <div class="card-body">

                                {{-- Method --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Method</label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="method"
                                               id="method_code" value="discount_code"
                                               {{ (!isset($discount) || $discount->method === 'discount_code') ? 'checked' : '' }}
                                               onchange="toggleMethod()">
                                        <label class="btn btn-outline-dark" for="method_code">
                                            Discount code
                                        </label>

                                        <input type="radio" class="btn-check" name="method"
                                               id="method_auto" value="automatic"
                                               {{ (isset($discount) && $discount->method === 'automatic') ? 'checked' : '' }}
                                               onchange="toggleMethod()">
                                        <label class="btn btn-outline-dark" for="method_auto">
                                            Automatic discount
                                        </label>
                                    </div>
                                </div>

                                {{-- Title --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <span id="titleLabel">Discount code</span>
                                    </label>
                                    <div class="input-group" id="codeInputGroup">
                                        <input type="text"
                                               class="form-control @error('code') is-invalid @enderror"
                                               name="code"
                                               id="codeInput"
                                               value="{{ old('code', isset($discount) ? $discount->code : '') }}"
                                               placeholder="e.g. SUMMER20">
                                        <button type="button" class="btn btn-outline-secondary"
                                                onclick="generateCode()">
                                            Generate random code
                                        </button>
                                    </div>
                                    <small class="text-muted">Customers must enter this code at checkout.</small>
                                    @error('code')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Auto Title --}}
                                <div class="mb-3" id="autoTitleGroup" style="display:none">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           name="title"
                                           value="{{ old('title', isset($discount) ? $discount->title : '') }}"
                                           placeholder="e.g. Summer Sale">
                                    <small class="text-muted">Customers will see this in their cart.</small>
                                    @error('title')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        {{-- Discount Value (hide for free_shipping & bxgy) --}}
                        <div class="card mb-4" id="valueSection">
                            <div class="card-header">
                                <h5 class="mb-0">Discount value</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-select" name="value_type" id="valueType">
                                            <option value="percentage"
                                                {{ (isset($discount) && $discount->value_type === 'percentage') ? 'selected' : '' }}>
                                                Percentage
                                            </option>
                                            <option value="fixed"
                                                {{ (isset($discount) && $discount->value_type === 'fixed') ? 'selected' : '' }}>
                                                Fixed amount
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   name="value"
                                                   value="{{ old('value', isset($discount) ? $discount->value : '') }}"
                                                   placeholder="0"
                                                   min="0" step="0.01">
                                            <span class="input-group-text" id="valueSuffix">%</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Applies To (only for amount_off_products) --}}
                                <div class="mt-3" id="appliesToSection">
                                    <label class="form-label fw-bold">Applies to</label>
                                    <select class="form-select" name="applies_to" id="appliesToSelect"
                                            onchange="toggleAppliesTo()">
                                        <option value="all_products"
                                            {{ (isset($discount) && $discount->rule?->applies_to === 'all_products') ? 'selected' : '' }}>
                                            All products
                                        </option>
                                        <option value="specific_collections"
                                            {{ (isset($discount) && $discount->rule?->applies_to === 'specific_collections') ? 'selected' : '' }}>
                                            Specific collections
                                        </option>
                                        <option value="specific_products"
                                            {{ (isset($discount) && $discount->rule?->applies_to === 'specific_products') ? 'selected' : '' }}>
                                            Specific products
                                        </option>
                                    </select>

                                    {{-- Collections Select --}}
                                    <div class="mt-2" id="collectionsSelect" style="display:none">
                                        <label class="form-label">Select Collections</label>
                                        <select class="form-select" name="collection_ids[]" multiple size="5">
                                            @foreach($collections as $col)
                                                <option value="{{ $col->id }}"
                                                    {{ (isset($discount) && $discount->products->where('product_type','collection')->pluck('product_id')->contains($col->id)) ? 'selected' : '' }}>
                                                    {{ $col->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Products Select --}}
                                    <div class="mt-2" id="productsSelect" style="display:none">
                                        <label class="form-label">Select Products</label>
                                        <select class="form-select" name="product_ids[]" multiple size="5">
                                            @foreach($products as $prod)
                                                <option value="{{ $prod->id }}"
                                                    {{ (isset($discount) && $discount->products->where('product_type','product')->pluck('product_id')->contains($prod->id)) ? 'selected' : '' }}>
                                                    {{ $prod->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Buy X Get Y Section --}}
                        <div class="card mb-4" id="bxgySection" style="display:none">
                            <div class="card-header">
                                <h5 class="mb-0">Customer buys</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Buy type</label>
                                        <select class="form-select" name="buy_type">
                                            <option value="min_quantity"
                                                {{ (isset($discount) && $discount->bxgy?->buy_type === 'min_quantity') ? 'selected' : '' }}>
                                                Minimum quantity of items
                                            </option>
                                            <option value="min_amount"
                                                {{ (isset($discount) && $discount->bxgy?->buy_type === 'min_amount') ? 'selected' : '' }}>
                                                Minimum purchase amount
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" class="form-control" name="buy_quantity"
                                               value="{{ old('buy_quantity', isset($discount) ? $discount->bxgy?->buy_quantity : '') }}"
                                               min="1" placeholder="1">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Any items from</label>
                                        <select class="form-select" name="buy_from">
                                            <option value="any_items">Any items</option>
                                            <option value="specific_products">Specific products</option>
                                            <option value="specific_collections">Specific collections</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Search products (buy)</label>
                                    <select class="form-select" name="buy_product_ids[]" multiple size="4">
                                        @foreach($products as $prod)
                                            <option value="{{ $prod->id }}">{{ $prod->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="card-header border-top">
                                <h5 class="mb-0">Customer gets</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" class="form-control" name="get_quantity"
                                               value="{{ old('get_quantity', isset($discount) ? $discount->bxgy?->get_quantity : 1) }}"
                                               min="1" placeholder="1">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Any items from</label>
                                        <select class="form-select" name="get_from">
                                            <option value="any_items">Any items</option>
                                            <option value="specific_products">Specific products</option>
                                            <option value="specific_collections">Specific collections</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Search products (get)</label>
                                    <select class="form-select" name="get_product_ids[]" multiple size="4">
                                        @foreach($products as $prod)
                                            <option value="{{ $prod->id }}">{{ $prod->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">At a discounted value</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="get_value_type"
                                               value="percentage" id="gvt_pct" checked>
                                        <label class="form-check-label" for="gvt_pct">Percentage</label>
                                    </div>
                                    <div class="input-group mt-1 mb-2" style="max-width:200px">
                                        <input type="number" class="form-control" name="get_value"
                                               value="{{ old('get_value', isset($discount) ? $discount->bxgy?->get_value : '') }}"
                                               placeholder="0" min="0">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="get_value_type"
                                               value="amount_off" id="gvt_amt">
                                        <label class="form-check-label" for="gvt_amt">Amount off each</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="get_value_type"
                                               value="free" id="gvt_free"
                                               {{ (isset($discount) && $discount->bxgy?->get_value_type === 'free') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gvt_free">Free</label>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="max_uses_per_order"
                                           id="maxUsesPerOrder" value="1">
                                    <label class="form-check-label" for="maxUsesPerOrder">
                                        Set a maximum number of uses per order
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Free Shipping Section --}}
                        <div class="card mb-4" id="shippingSection" style="display:none">
                            <div class="card-header">
                                <h5 class="mb-0">Countries</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="country_type"
                                           value="all" id="allCountries" checked>
                                    <label class="form-check-label" for="allCountries">All countries</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="country_type"
                                           value="selected" id="selectedCountries">
                                    <label class="form-check-label" for="selectedCountries">Selected countries</label>
                                </div>

                                <label class="form-label fw-bold">Shipping rates</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="exclude_shipping"
                                           id="excludeShipping">
                                    <label class="form-check-label" for="excludeShipping">
                                        Exclude shipping rates over a certain amount
                                    </label>
                                </div>
                                <div class="mt-2" id="excludeShippingAmount" style="display:none">
                                    <div class="input-group" style="max-width:200px">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control"
                                               name="exclude_shipping_over" placeholder="0" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Eligibility --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Eligibility</h5>
                            </div>
                            <div class="card-body">
                                <small class="text-muted d-block mb-2">Available on all sales channels</small>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="eligibility"
                                           value="all_customers" id="elig_all" checked>
                                    <label class="form-check-label" for="elig_all">All customers</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="eligibility"
                                           value="specific_segments" id="elig_seg">
                                    <label class="form-check-label" for="elig_seg">Specific customer segments</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="eligibility"
                                           value="specific_customers" id="elig_cust">
                                    <label class="form-check-label" for="elig_cust">Specific customers</label>
                                </div>
                            </div>
                        </div>

                        {{-- Minimum Purchase Requirements --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Minimum purchase requirements</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="min_requirement"
                                           value="none" id="min_none" checked onchange="toggleMinReq()">
                                    <label class="form-check-label" for="min_none">No minimum requirements</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="min_requirement"
                                           value="min_amount" id="min_amount" onchange="toggleMinReq()">
                                    <label class="form-check-label" for="min_amount">Minimum purchase amount (₹)</label>
                                </div>
                                <div class="mt-2 ms-4" id="minAmountInput" style="display:none">
                                    <div class="input-group" style="max-width:200px">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" name="min_amount"
                                               value="{{ old('min_amount', isset($discount) ? $discount->rule?->min_amount : '') }}"
                                               placeholder="0" min="0">
                                    </div>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="min_requirement"
                                           value="min_quantity" id="min_qty" onchange="toggleMinReq()">
                                    <label class="form-check-label" for="min_qty">Minimum quantity of items</label>
                                </div>
                                <div class="mt-2 ms-4" id="minQtyInput" style="display:none">
                                    <input type="number" class="form-control" name="min_quantity"
                                           style="max-width:200px"
                                           value="{{ old('min_quantity', isset($discount) ? $discount->rule?->min_quantity : '') }}"
                                           placeholder="0" min="0">
                                </div>
                            </div>
                        </div>

                        {{-- Maximum Discount Uses --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Maximum discount uses</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="limit_total_uses"
                                           id="limitTotal" onchange="toggleMaxUses('total')">
                                    <label class="form-check-label" for="limitTotal">
                                        Limit number of times this discount can be used in total
                                    </label>
                                </div>
                                <div class="mt-2 ms-4" id="maxUsesTotalInput" style="display:none">
                                    <input type="number" class="form-control" name="max_uses_total"
                                           style="max-width:200px"
                                           value="{{ old('max_uses_total', isset($discount) ? $discount->rule?->max_uses_total : '') }}"
                                           placeholder="0" min="1">
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="limit_per_customer"
                                           id="limitPerCustomer" onchange="toggleMaxUses('per')">
                                    <label class="form-check-label" for="limitPerCustomer">
                                        Limit to one use per customer
                                    </label>
                                </div>
                                <div class="mt-2 ms-4" id="maxUsesPerInput" style="display:none">
                                    <input type="number" class="form-control" name="max_uses_per_customer"
                                           style="max-width:200px"
                                           value="{{ old('max_uses_per_customer', isset($discount) ? $discount->rule?->max_uses_per_customer : '') }}"
                                           placeholder="1" min="1">
                                </div>
                            </div>
                        </div>

                        {{-- Combinations --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Combinations</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">This discount can be combined with:</p>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox"
                                           name="combine_product_discounts" id="combineProduct"
                                           {{ (isset($discount) && $discount->rule?->combine_product_discounts) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="combineProduct">Product discounts</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox"
                                           name="combine_order_discounts" id="combineOrder"
                                           {{ (isset($discount) && $discount->rule?->combine_order_discounts) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="combineOrder">Order discounts</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="combine_shipping_discounts" id="combineShipping"
                                           {{ (isset($discount) && $discount->rule?->combine_shipping_discounts) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="combineShipping">Shipping discounts</label>
                                </div>
                            </div>
                        </div>

                        {{-- Active Dates --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Active dates</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Start date</label>
                                        <input type="date" class="form-control" name="starts_at"
                                               value="{{ old('starts_at', isset($discount) && $discount->starts_at ? $discount->starts_at->format('Y-m-d') : date('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Start time</label>
                                        <input type="time" class="form-control" name="start_time"
                                               value="{{ date('H:i') }}">
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="setEndDate"
                                           onchange="toggleEndDate()"
                                           {{ (isset($discount) && $discount->ends_at) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="setEndDate">Set end date</label>
                                </div>

                                <div id="endDateSection" style="{{ (isset($discount) && $discount->ends_at) ? '' : 'display:none' }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">End date</label>
                                            <input type="date" class="form-control" name="ends_at"
                                                   value="{{ old('ends_at', isset($discount) && $discount->ends_at ? $discount->ends_at->format('Y-m-d') : '') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">End time</label>
                                            <input type="time" class="form-control" name="end_time"
                                                   value="23:59">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Right Column --}}
                    <div class="col-md-4">
                        <div class="card mb-4 sticky-top" style="top:20px">
                            <div class="card-header">
                                <h5 class="mb-0">Summary</h5>
                            </div>
                            <div class="card-body">
                                <div id="summaryContent">
                                    <p class="text-muted small">
                                        Select a discount type to see summary
                                    </p>
                                </div>
                                <hr>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save"></i>
                                        {{ isset($discount) ? 'Update Discount' : 'Save Discount' }}
                                    </button>
                                    <a href="{{ route('discount.index') }}" class="btn btn-outline-secondary">
                                        Discard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
.type-card {
    cursor: pointer;
    transition: all 0.2s;
}
.type-card:hover {
    border-color: #0d6efd !important;
    background: #f0f7ff;
}
.type-card.selected {
    border-color: #0d6efd !important;
    background: #e8f0fe;
}
</style>

<script>
// Type select karo
function selectType(type) {
    // Highlight selected
    document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
    const card = document.getElementById('type_' + type);
    if (card) card.classList.add('selected'); // ✅ pehle se hai

    // Set hidden input
    const selectedTypeInput = document.getElementById('selectedType');
    if (selectedTypeInput) selectedTypeInput.value = type; // ✅ null check

    // Show form
    const discountForm = document.getElementById('discountForm');
    if (discountForm) discountForm.style.display = 'block'; // ✅ null check

    // Type titles
    const titles = {
        'amount_off_products': 'Amount off products',
        'buy_x_get_y':         'Buy X Get Y',
        'amount_off_order':    'Amount off order',
        'free_shipping':       'Free shipping',
    };
    
    const formTypeTitle = document.getElementById('formTypeTitle');
    if (formTypeTitle) formTypeTitle.textContent = titles[type] || 'Discount'; // ✅ null check

    // Show/hide sections
    const valueSection    = document.getElementById('valueSection');
    const bxgySection     = document.getElementById('bxgySection');
    const shippingSection = document.getElementById('shippingSection');
    const appliesToSec    = document.getElementById('appliesToSection');

    if (valueSection)    valueSection.style.display    = 'block';
    if (bxgySection)     bxgySection.style.display     = 'none';
    if (shippingSection) shippingSection.style.display = 'none';
    if (appliesToSec)    appliesToSec.style.display    = 'block';

    if (type === 'buy_x_get_y') {
        if (valueSection) valueSection.style.display = 'none';
        if (bxgySection)  bxgySection.style.display  = 'block';
    } else if (type === 'free_shipping') {
        if (valueSection)    valueSection.style.display    = 'none';
        if (shippingSection) shippingSection.style.display = 'block';
    } else if (type === 'amount_off_order') {
        if (appliesToSec) appliesToSec.style.display = 'none';
    }

    updateSummary(type);
    
    if (discountForm) {
        discountForm.scrollIntoView({ behavior: 'smooth' });
    }
}

// Method toggle
function toggleMethod() {
    const isCode = document.getElementById('method_code').checked;
    document.getElementById('codeInputGroup').style.display  = isCode ? 'flex' : 'none';
    document.getElementById('autoTitleGroup').style.display  = isCode ? 'none' : 'block';
    document.getElementById('titleLabel').textContent        = isCode ? 'Discount code' : 'Title';
}

// Random code generate
function generateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 10; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('codeInput').value = code;
}

// Applies to toggle
function toggleAppliesTo() {
    const val = document.getElementById('appliesToSelect').value;
    document.getElementById('collectionsSelect').style.display = val === 'specific_collections' ? 'block' : 'none';
    document.getElementById('productsSelect').style.display    = val === 'specific_products'    ? 'block' : 'none';
}

// Min requirements toggle
function toggleMinReq() {
    const val = document.querySelector('input[name="min_requirement"]:checked').value;
    document.getElementById('minAmountInput').style.display = val === 'min_amount'   ? 'block' : 'none';
    document.getElementById('minQtyInput').style.display    = val === 'min_quantity' ? 'block' : 'none';
}

// Max uses toggle
function toggleMaxUses(type) {
    if (type === 'total') {
        const checked = document.getElementById('limitTotal').checked;
        document.getElementById('maxUsesTotalInput').style.display = checked ? 'block' : 'none';
    } else {
        const checked = document.getElementById('limitPerCustomer').checked;
        document.getElementById('maxUsesPerInput').style.display = checked ? 'block' : 'none';
    }
}

// End date toggle
function toggleEndDate() {
    const checked = document.getElementById('setEndDate').checked;
    document.getElementById('endDateSection').style.display = checked ? 'block' : 'none';
}

// Value suffix toggle
document.getElementById('valueType')?.addEventListener('change', function() {
    document.getElementById('valueSuffix').textContent = this.value === 'percentage' ? '%' : '₹';
});

// Exclude shipping toggle
document.getElementById('excludeShipping')?.addEventListener('change', function() {
    document.getElementById('excludeShippingAmount').style.display = this.checked ? 'block' : 'none';
});

// Summary update
function updateSummary(type) {
    const summaryMap = {
        'amount_off_products': `<ul class="small text-muted ps-3">
            <li>Type: Amount off products</li>
            <li>Applies to selected products/collections</li>
        </ul>`,
        'buy_x_get_y': `<ul class="small text-muted ps-3">
            <li>Type: Buy X Get Y</li>
            <li>Customer buys X items, gets Y free/discounted</li>
        </ul>`,
        'amount_off_order': `<ul class="small text-muted ps-3">
            <li>Type: Amount off order</li>
            <li>Discount on entire order total</li>
        </ul>`,
        'free_shipping': `<ul class="small text-muted ps-3">
            <li>Type: Free shipping</li>
            <li>Offer free shipping on order</li>
        </ul>`,
    };
    document.getElementById('summaryContent').innerHTML = summaryMap[type] || '';
}

// Edit mode mein auto select type
@if(isset($discount))
    selectType('{{ $discount->type }}');
@endif
</script>
@endsection