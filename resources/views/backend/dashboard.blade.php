@extends('backend.layouts.layout')

@section('title', 'Dashboard - Admin')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | FALLBACK VALUES
    |--------------------------------------------------------------------------
    | Agar controller abhi data pass nahi kar raha to page error na de.
    | Baad me controller se real values pass kar sakte ho.
    */

    $dashboardTotalOrders = $totalOrders ?? \App\Models\Order::count();

    $dashboardPaidOrders = $paidOrders ?? \App\Models\Order::where('payment_status', 'paid')->count();

    $dashboardPendingOrders = $pendingOrders ?? \App\Models\Order::where('order_status', 'pending')->count();

    $dashboardRevenue = $totalRevenue ?? \App\Models\Order::where('payment_status', 'paid')->sum('total');

    $dashboardTodayOrders = $todayOrders ?? \App\Models\Order::whereDate('created_at', now()->toDateString())->count();

    $dashboardTodayRevenue = $todayRevenue ?? \App\Models\Order::where('payment_status', 'paid')
        ->whereDate('created_at', now()->toDateString())
        ->sum('total');

    $dashboardCustomers = $totalCustomers ?? (
        class_exists(\App\Models\Customer::class)
            ? \App\Models\Customer::count()
            : 0
    );

    $dashboardProducts = $totalProducts ?? \App\Models\Product::count();

    $recentOrders = $recentOrders ?? \App\Models\Order::with('items')
        ->latest()
        ->take(8)
        ->get();

    $processingOrders = \App\Models\Order::where('order_status', 'processing')->count();
    $shippedOrders = \App\Models\Order::where('order_status', 'shipped')->count();
    $deliveredOrders = \App\Models\Order::where('order_status', 'delivered')->count();

    $paidPercentage = $dashboardTotalOrders > 0
        ? round(($dashboardPaidOrders / $dashboardTotalOrders) * 100)
        : 0;

    $pendingPercentage = $dashboardTotalOrders > 0
        ? round(($dashboardPendingOrders / $dashboardTotalOrders) * 100)
        : 0;
@endphp


<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * {
        box-sizing: border-box;
    }

    body {
        background: #f5f7fb;
        font-family: 'Nunito', sans-serif;
    }

    .dashboard-wrap {
        max-width: 1500px;
        margin: 0 auto;
        padding: 4px 0 30px;
    }

    .dashboard-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .dashboard-title {
        margin: 0;
        color: #0a214f;
        font-family: 'Sora', sans-serif;
        font-weight: 800;
        font-size: 26px;
        letter-spacing: -0.03em;
    }

    .dashboard-subtitle {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .dashboard-date {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 15px;
        color: #0a214f;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(10, 33, 79, 0.06);
    }

    /* =========================
       STAT CARDS
    ========================== */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 18px;
        border: 1px solid #e8edf5;
        box-shadow: 0 6px 22px rgba(10, 33, 79, 0.07);
        transition: .25s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(10, 33, 79, 0.12);
    }

    .stat-card:before {
        content: '';
        position: absolute;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        right: -45px;
        top: -50px;
        background: rgba(24, 114, 181, .06);
    }

    .stat-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
    }

    .icon-blue {
        background: linear-gradient(135deg, #0a4e8a, #2596e1);
    }

    .icon-green {
        background: linear-gradient(135deg, #059669, #34d399);
    }

    .icon-orange {
        background: linear-gradient(135deg, #c2410c, #fb923c);
    }

    .icon-purple {
        background: linear-gradient(135deg, #6d28d9, #a78bfa);
    }

    .stat-label {
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-value {
        color: #0a214f;
        font-family: 'Sora', sans-serif;
        font-size: 25px;
        font-weight: 800;
        line-height: 1.1;
    }

    .stat-foot {
        font-size: 11px;
        color: #6b7280;
        margin-top: 9px;
    }

    .stat-foot strong {
        color: #059669;
    }

    /* =========================
       MAIN GRID
    ========================== */

    .dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(320px, .7fr);
        gap: 18px;
        margin-bottom: 20px;
    }

    .dashboard-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e8edf5;
        box-shadow: 0 6px 22px rgba(10, 33, 79, 0.07);
        overflow: hidden;
    }

    .card-head {
        padding: 15px 18px;
        border-bottom: 1px solid #edf0f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        color: #fff;
    }

    .card-title {
        margin: 0;
        font-family: 'Sora', sans-serif;
        font-size: 14px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .view-link {
        color: #fff;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        background: rgba(255,255,255,.15);
        padding: 6px 10px;
        border-radius: 7px;
    }

    .view-link:hover {
        color: #fff;
        background: rgba(255,255,255,.24);
    }

    .card-body {
        padding: 18px;
    }

    /* =========================
       RECENT ORDERS
    ========================== */

    .orders-table-wrap {
        overflow-x: auto;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .orders-table th {
        padding: 10px 11px;
        text-align: left;
        color: #6b7280;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .orders-table td {
        padding: 11px;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
        color: #374151;
    }

    .orders-table tr:last-child td {
        border-bottom: 0;
    }

    .order-number {
        color: #0a4e8a;
        font-weight: 800;
    }

    .customer-name {
        font-weight: 700;
        color: #0a214f;
    }

    .customer-email {
        font-size: 10px;
        color: #9ca3af;
    }

    .status-badge {
        display: inline-flex;
        padding: 4px 9px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 800;
        text-transform: capitalize;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-confirmed,
    .status-delivered,
    .status-paid {
        background: #d1fae5;
        color: #065f46;
    }

    .status-processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-shipped {
        background: #e0e7ff;
        color: #3730a3;
    }

    .status-cancelled,
    .status-failed {
        background: #fee2e2;
        color: #991b1b;
    }

    .table-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #1872B5;
        color: #fff;
        padding: 5px 9px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 10px;
        font-weight: 700;
    }

    .table-btn:hover {
        color: #fff;
        background: #105f9b;
    }

    /* =========================
       ORDER STATUS OVERVIEW
    ========================== */

    .status-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .status-row {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .status-circle {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-weight: 800;
    }

    .status-info {
        flex: 1;
    }

    .status-name {
        font-size: 12px;
        color: #374151;
        font-weight: 700;
    }

    .status-count {
        color: #0a214f;
        font-family: 'Sora', sans-serif;
        font-weight: 800;
        font-size: 15px;
    }

    .mini-progress {
        height: 5px;
        background: #edf2f7;
        border-radius: 20px;
        overflow: hidden;
        margin-top: 5px;
    }

    .mini-progress > span {
        display: block;
        height: 100%;
        border-radius: 20px;
        background: linear-gradient(90deg, #1872B5, #2596e1);
    }

    /* =========================
       BOTTOM GRID
    ========================== */

    .bottom-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .quick-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .quick-link {
        border: 1px solid #e5e7eb;
        border-radius: 11px;
        padding: 14px 12px;
        text-decoration: none;
        color: #0a214f;
        background: #f9fbfd;
        transition: .2s;
    }

    .quick-link:hover {
        background: #eff6ff;
        border-color: #93c5fd;
        color: #0a214f;
        transform: translateY(-2px);
    }

    .quick-icon {
        font-size: 19px;
        margin-bottom: 7px;
    }

    .quick-title {
        font-size: 11px;
        font-weight: 800;
    }

    .quick-desc {
        font-size: 9px;
        color: #9ca3af;
        margin-top: 3px;
    }

    .mini-number {
        font-family: 'Sora', sans-serif;
        color: #0a214f;
        font-size: 28px;
        font-weight: 800;
        margin-top: 8px;
    }

    .small-info {
        color: #6b7280;
        font-size: 11px;
        margin-top: 5px;
    }

    .empty-state {
        text-align: center;
        padding: 35px 15px;
        color: #9ca3af;
        font-size: 12px;
    }

    @media(max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .bottom-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width: 767px) {
        .stats-grid,
        .bottom-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-title {
            font-size: 21px;
        }

        .card-body {
            padding: 14px;
        }

        .quick-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>


<div class="dashboard-wrap">

    {{-- HEADER --}}
    <div class="dashboard-top">

        <div>
            <h1 class="dashboard-title">
                👋 Welcome Back
            </h1>

            <p class="dashboard-subtitle">
                Here’s what’s happening with Saini Vet Pharma today.
            </p>
        </div>

        <div class="dashboard-date">
            📅 {{ now()->format('d M Y, l') }}
        </div>

    </div>


    {{-- TOP STATS --}}
    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-head">
                <div>
                    <div class="stat-label">
                        Total Revenue
                    </div>

                    <div class="stat-value">
                        ₹{{ number_format($dashboardRevenue, 2) }}
                    </div>
                </div>

                <div class="stat-icon icon-green">
                    ₹
                </div>
            </div>

            <div class="stat-foot">
                Today:
                <strong>
                    ₹{{ number_format($dashboardTodayRevenue, 2) }}
                </strong>
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-head">
                <div>
                    <div class="stat-label">
                        Total Orders
                    </div>

                    <div class="stat-value">
                        {{ number_format($dashboardTotalOrders) }}
                    </div>
                </div>

                <div class="stat-icon icon-blue">
                    <i class="fas fa-receipt"></i>
                </div>
            </div>

            <div class="stat-foot">
                Today:
                <strong>
                    {{ $dashboardTodayOrders }} orders
                </strong>
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-head">
                <div>
                    <div class="stat-label">
                        Customers
                    </div>

                    <div class="stat-value">
                        {{ number_format($dashboardCustomers) }}
                    </div>
                </div>

                <div class="stat-icon icon-purple">
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <div class="stat-foot">
                Phone based customer accounts
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-head">
                <div>
                    <div class="stat-label">
                        Products
                    </div>

                    <div class="stat-value">
                        {{ number_format($dashboardProducts) }}
                    </div>
                </div>

                <div class="stat-icon icon-orange">
                    <i class="fas fa-box"></i>
                </div>
            </div>

            <div class="stat-foot">
                Active store catalogue
            </div>

        </div>

    </div>


    {{-- MAIN SECTION --}}
    <div class="dashboard-grid">

        {{-- RECENT ORDERS --}}
        <div class="dashboard-card">

            <div class="card-head">

                <h2 class="card-title">
                    <i class="fas fa-shopping-cart"></i>
                    Recent Orders
                </h2>

                <a
                    href="{{ route('orders') }}"
                    class="view-link"
                >
                    View All →
                </a>

            </div>


            <div class="orders-table-wrap">

                @if($recentOrders->count())

                    <table class="orders-table">

                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                        @foreach($recentOrders as $order)

                            <tr>

                                <td>
                                    <span class="order-number">
                                        #{{ $order->order_number }}
                                    </span>
                                </td>


                                <td>
                                    <div class="customer-name">
                                        {{ $order->first_name }}
                                        {{ $order->last_name }}
                                    </div>

                                    <div class="customer-email">
                                        {{ $order->email }}
                                    </div>
                                </td>


                                <td>
                                    <strong>
                                        ₹{{ number_format($order->total, 2) }}
                                    </strong>
                                </td>


                                <td>
                                    <span class="
                                        status-badge
                                        status-{{ strtolower($order->payment_status) }}
                                    ">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>


                                <td>
                                    <span class="
                                        status-badge
                                        status-{{ strtolower($order->order_status) }}
                                    ">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>


                                <td>
                                    {{ $order->created_at->format('d M') }}
                                </td>


                                <td>
                                    <a
                                        href="{{ route('order.view', $order->id) }}"
                                        class="table-btn"
                                    >
                                        <i class="fas fa-eye"></i>
                                        View
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="empty-state">
                        📦 No orders yet.
                    </div>

                @endif

            </div>

        </div>


        {{-- ORDER STATUS --}}
        <div class="dashboard-card">

            <div class="card-head">

                <h2 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    Order Overview
                </h2>

            </div>


            <div class="card-body">

                <div class="status-list">

                    <div class="status-row">

                        <div
                            class="status-circle"
                            style="
                                background:#fef3c7;
                                color:#92400e;
                            "
                        >
                            {{ $dashboardPendingOrders }}
                        </div>

                        <div class="status-info">

                            <div class="status-name">
                                Pending Orders
                            </div>

                            <div class="mini-progress">
                                <span
                                    style="
                                        width:
                                        {{ min(100, $pendingPercentage) }}%
                                    "
                                ></span>
                            </div>

                        </div>

                    </div>


                    <div class="status-row">

                        <div
                            class="status-circle"
                            style="
                                background:#dbeafe;
                                color:#1e40af;
                            "
                        >
                            {{ $processingOrders }}
                        </div>

                        <div class="status-info">
                            <div class="status-name">
                                Processing
                            </div>
                        </div>

                    </div>


                    <div class="status-row">

                        <div
                            class="status-circle"
                            style="
                                background:#e0e7ff;
                                color:#3730a3;
                            "
                        >
                            {{ $shippedOrders }}
                        </div>

                        <div class="status-info">
                            <div class="status-name">
                                Shipped
                            </div>
                        </div>

                    </div>


                    <div class="status-row">

                        <div
                            class="status-circle"
                            style="
                                background:#d1fae5;
                                color:#065f46;
                            "
                        >
                            {{ $deliveredOrders }}
                        </div>

                        <div class="status-info">
                            <div class="status-name">
                                Delivered
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- BOTTOM --}}
    <div class="bottom-grid">

        {{-- PAYMENTS --}}
        <div class="dashboard-card">

            <div class="card-head">
                <h2 class="card-title">
                    💳 Payments
                </h2>
            </div>

            <div class="card-body">

                <div class="stat-label">
                    Paid Orders
                </div>

                <div class="mini-number">
                    {{ $dashboardPaidOrders }}
                </div>

                <div class="small-info">
                    {{ $paidPercentage }}% of total orders are paid.
                </div>

                <div
                    class="mini-progress"
                    style="margin-top:14px;"
                >
                    <span
                        style="
                            width:
                            {{ min(100, $paidPercentage) }}%;
                            background:
                            linear-gradient(
                                90deg,
                                #059669,
                                #34d399
                            );
                        "
                    ></span>
                </div>

            </div>

        </div>


        {{-- TODAY --}}
        <div class="dashboard-card">

            <div class="card-head">
                <h2 class="card-title">
                    📈 Today
                </h2>
            </div>

            <div class="card-body">

                <div class="stat-label">
                    Orders Today
                </div>

                <div class="mini-number">
                    {{ $dashboardTodayOrders }}
                </div>

                <div class="small-info">
                    Revenue:
                    <strong style="color:#059669;">
                        ₹{{ number_format($dashboardTodayRevenue, 2) }}
                    </strong>
                </div>

            </div>

        </div>


        {{-- QUICK ACTIONS --}}
        <div class="dashboard-card">

            <div class="card-head">
                <h2 class="card-title">
                    ⚡ Quick Actions
                </h2>
            </div>

            <div class="card-body">

                <div class="quick-grid">

                    <a
                        href="{{ route('product.create') }}"
                        class="quick-link"
                    >
                        <div class="quick-icon">
                            ➕
                        </div>

                        <div class="quick-title">
                            Add Product
                        </div>

                        <div class="quick-desc">
                            Create new product
                        </div>
                    </a>


                    <a
                        href="{{ route('orders') }}"
                        class="quick-link"
                    >
                        <div class="quick-icon">
                            🧾
                        </div>

                        <div class="quick-title">
                            Orders
                        </div>

                        <div class="quick-desc">
                            Manage orders
                        </div>
                    </a>


                    <a
                        href="{{ route('discount.index') }}"
                        class="quick-link"
                    >
                        <div class="quick-icon">
                            🏷️
                        </div>

                        <div class="quick-title">
                            Discounts
                        </div>

                        <div class="quick-desc">
                            Manage offers
                        </div>
                    </a>


                    <a
                        href="{{ route('shipping.rate') }}"
                        class="quick-link"
                    >
                        <div class="quick-icon">
                            🚚
                        </div>

                        <div class="quick-title">
                            Shipping
                        </div>

                        <div class="quick-desc">
                            Manage rates
                        </div>
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')
<script>
    console.log('Saini Vet Pharma dashboard loaded');
</script>
@endpush
