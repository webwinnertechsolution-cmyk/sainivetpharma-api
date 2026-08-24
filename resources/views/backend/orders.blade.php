@extends('backend.layouts.layout')
@section('title', 'Orders')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }

    body {
        font-family: 'Nunito', sans-serif;
        background: #f5f7fa;
    }

    .page-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0;
    }

    .page-header {
        margin-bottom: 14px;
    }

    .page-title {
        font-family: 'Sora', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: #0a214f;
        margin-bottom: 4px;
        letter-spacing: -0.02em;
    }

    .page-subtitle {
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7;
        color: #065f46;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 500;
        font-size: 12px;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5;
        color: #7f1d1d;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 500;
        font-size: 12px;
    }

    /* Stats */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 16px;
    }

    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 14px 18px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #fff;
        flex-shrink: 0;
    }

    .stat-icon.total {
        background: linear-gradient(135deg, #0a214f, #1872B5);
    }

    .stat-icon.pending {
        background: linear-gradient(135deg, #b45309, #f59e0b);
    }

    .stat-icon.paid {
        background: linear-gradient(135deg, #059669, #34d399);
    }

    .stat-value {
        font-family: 'Sora', sans-serif;
        font-size: 18px;
        font-weight: 800;
        color: #0a214f;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 11px;
        color: #6b7280;
        font-weight: 600;
    }

    /* Card */
    .page-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden;
        border: 1px solid #e5e7eb;
        margin-bottom: 16px;
    }

    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px;
        color: #ffffff;
    }

    .card-header-title {
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .table-count {
        font-size: 11px;
        background: rgba(255,255,255,0.2);
        color: #fff;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 700;
    }

    /* Filters */
    .filter-bar {
        padding: 14px 16px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-bar input,
    .filter-bar select {
        border: 1.5px solid #e5e7eb;
        border-radius: 6px;
        padding: 7px 10px;
        font-size: 12px;
        font-family: 'Nunito', sans-serif;
    }

    .filter-bar input {
        flex: 1;
        min-width: 200px;
    }

    /* Buttons */
    .btn {
        padding: 7px 14px;
        border-radius: 6px;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 11px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1872B5, #2596e1);
        color: white;
        box-shadow: 0 4px 12px rgba(24,114,181,0.3);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        color: white;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }

    .btn-sm {
        padding: 4px 9px;
        font-size: 10px;
    }

    /* Table */
    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    thead tr {
        background: #f9fafb;
    }

    thead th {
        padding: 10px 12px;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        color: #0a214f;
        font-size: 11px;
        border-bottom: 2px solid #e5e7eb;
        white-space: nowrap;
    }

    tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.15s;
    }

    tbody tr:hover {
        background: #f9fafb;
    }

    tbody td {
        padding: 10px 12px;
        color: #374151;
        vertical-align: middle;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-order-id {
        background: #e0e7ff;
        color: #3730a3;
        font-size: 11px;
        padding: 4px 10px;
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER STATUS COLORS
    |--------------------------------------------------------------------------
    */

    .status-pending {
        background: #fef3c7 !important;
        color: #92400e !important;
    }

    .status-confirmed {
        background: #d1fae5 !important;
        color: #065f46 !important;
    }

    .status-processing {
        background: #dbeafe !important;
        color: #1e40af !important;
    }

    .status-shipped {
        background: #e0e7ff !important;
        color: #3730a3 !important;
    }

    .status-delivered {
        background: #d1fae5 !important;
        color: #065f46 !important;
    }

    .status-cancelled {
        background: #fee2e2 !important;
        color: #7f1d1d !important;
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT STATUS COLORS
    |--------------------------------------------------------------------------
    */

    .pay-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .pay-paid {
        background: #d1fae5;
        color: #065f46;
    }

    .pay-failed {
        background: #fee2e2;
        color: #7f1d1d;
    }

    .pay-refunded {
        background: #f3f4f6;
        color: #6b7280;
    }

    /* Status Dropdown */
    .order-status-select {
        border: none;
        cursor: pointer;
        outline: none;
        min-width: 115px;
        text-align: center;
        padding: 5px 26px 5px 12px;
        font-family: 'Sora', sans-serif;
        font-size: 10px;
        font-weight: 700;
        border-radius: 20px;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 36px;
        display: block;
        margin-bottom: 10px;
        opacity: 0.4;
    }

    .empty-state p {
        font-size: 12px;
        margin: 0;
    }

    .pagination-wrap {
        padding: 14px 16px;
        display: flex;
        justify-content: flex-end;
    }

    .pagination-wrap nav ul {
        display: flex;
        gap: 4px;
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 12px;
    }

    @media (max-width: 900px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-container">

    <div class="page-header">
        <h1 class="page-title">🧾 Orders</h1>
        <p class="page-subtitle">Manage and track all customer orders</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert-success">
            <span>✅ {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert-danger">
            <span>⚠️ {{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- Quick Stats --}}
    <div class="stats-row">

        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-receipt"></i>
            </div>

            <div>
                <div class="stat-value">{{ $totalOrders }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>

            <div>
                <div class="stat-value">{{ $pendingOrders }}</div>
                <div class="stat-label">Pending Orders</div>
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-icon paid">
                <i class="fas fa-check-circle"></i>
            </div>

            <div>
                <div class="stat-value">{{ $paidOrders }}</div>
                <div class="stat-label">Paid Orders</div>
            </div>
        </div>

    </div>


    {{-- Orders Table --}}
    <div class="page-card">

        <div class="card-header-gradient">
            <div class="card-header-row">

                <h2 class="card-header-title">
                    <i class="fas fa-list"></i>
                    All Orders
                </h2>

                <span class="table-count">
                    Total: {{ $orders->total() }}
                </span>

            </div>
        </div>


        {{-- Filter Bar --}}
        <form method="GET"
              action="{{ route('orders') }}"
              class="filter-bar">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by order #, name, email, phone..."
            >


            {{-- Order Status Filter --}}
            <select name="status">

                <option value="">
                    All Order Status
                </option>

                @foreach([
                    'pending',
                    'confirmed',
                    'processing',
                    'shipped',
                    'delivered',
                    'cancelled'
                ] as $status)

                    <option
                        value="{{ $status }}"
                        {{ request('status') == $status ? 'selected' : '' }}
                    >
                        {{ ucfirst($status) }}
                    </option>

                @endforeach

            </select>


            {{-- Payment Status Filter --}}
            <select name="payment_status">

                <option value="">
                    All Payment Status
                </option>

                @foreach([
                    'pending',
                    'paid',
                    'failed',
                    'refunded'
                ] as $pstatus)

                    <option
                        value="{{ $pstatus }}"
                        {{ request('payment_status') == $pstatus ? 'selected' : '' }}
                    >
                        {{ ucfirst($pstatus) }}
                    </option>

                @endforeach

            </select>


            <button
                type="submit"
                class="btn btn-primary btn-sm"
            >
                <i class="fas fa-filter"></i>
                Filter
            </button>


            <a
                href="{{ route('orders') }}"
                class="btn btn-secondary btn-sm"
            >
                <i class="fas fa-redo"></i>
                Reset
            </a>

        </form>


        {{-- Orders Table --}}
        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>

                        <th>Order #</th>

                        <th>Customer</th>

                        <th style="text-align:center;">
                            Items
                        </th>

                        <th>Total</th>

                        <th>Payment</th>

                        <th>Status</th>

                        <th style="text-align:center;">
                            Date
                        </th>

                        <th style="text-align:center;">
                            Actions
                        </th>

                    </tr>
                </thead>


                <tbody>

                    @forelse($orders as $order)

                        <tr>

                            {{-- Order Number --}}
                            <td>

                                <span class="badge badge-order-id">
                                    {{ $order->order_number }}
                                </span>

                            </td>


                            {{-- Customer --}}
                            <td>

                                <div style="
                                    font-weight:700;
                                    color:#0a214f;
                                    font-size:12px;
                                ">
                                    {{ $order->first_name }}
                                    {{ $order->last_name }}
                                </div>


                                <div style="
                                    font-size:10px;
                                    color:#6b7280;
                                ">
                                    {{ $order->email }}
                                </div>


                                <div style="
                                    font-size:10px;
                                    color:#6b7280;
                                ">
                                    {{ $order->phone }}
                                </div>

                            </td>


                            {{-- Items --}}
                            <td style="text-align:center;">

                                {{ $order->items->sum('quantity') }}

                            </td>


                            {{-- Total --}}
                            <td style="
                                font-weight:700;
                                color:#0a214f;
                            ">

                                ₹{{ number_format($order->total, 2) }}

                            </td>


                            {{-- Payment --}}
                            <td>

                                <span class="badge pay-{{ strtolower($order->payment_status) }}">

                                    {{ ucfirst($order->payment_status) }}

                                </span>

                                <br>

                                <span style="
                                    font-size:10px;
                                    color:#6b7280;
                                ">

                                    {{ str_replace(
                                        '_',
                                        ' ',
                                        ucfirst($order->payment_method)
                                    ) }}

                                </span>

                            </td>


                            {{-- Order Status --}}
                            <td>

                                <form
                                    action="{{ route('order.update.status', $order->id) }}"
                                    method="POST"
                                >

                                    @csrf


                                    <select
                                        name="order_status"
                                        onchange="this.form.submit()"
                                        class="
                                            order-status-select
                                            status-{{ strtolower($order->order_status) }}
                                        "
                                    >

                                        @foreach([
                                            'pending',
                                            'confirmed',
                                            'processing',
                                            'shipped',
                                            'delivered',
                                            'cancelled'
                                        ] as $status)

                                            <option
                                                value="{{ $status }}"
                                                {{ $order->order_status == $status ? 'selected' : '' }}
                                            >

                                                {{ ucfirst($status) }}

                                            </option>

                                        @endforeach

                                    </select>

                                </form>

                            </td>


                            {{-- Date --}}
                            <td style="text-align:center;">

                                <div style="
                                    font-size:11px;
                                    color:#0a214f;
                                    font-weight:600;
                                ">

                                    {{ $order->created_at->format('d M Y') }}

                                </div>


                                <div style="
                                    font-size:10px;
                                    color:#6b7280;
                                ">

                                    {{ $order->created_at->format('h:i A') }}

                                </div>

                            </td>


                            {{-- Actions --}}
                            <td style="text-align:center;">

                                <div style="
                                    display:flex;
                                    justify-content:center;
                                    align-items:center;
                                    gap:6px;
                                    flex-wrap:wrap;
                                ">

                                    <a
                                        href="{{ route('order.view', $order->id) }}"
                                        class="btn btn-primary btn-sm"
                                    >
                                        <i class="fas fa-eye"></i>
                                        View
                                    </a>

                                    <a
                                        href="{{ route('order.invoice', $order->id) }}"
                                        target="_blank"
                                        class="btn btn-secondary btn-sm"
                                        title="Print Invoice"
                                    >
                                        <i class="fas fa-print"></i>
                                        Print
                                    </a>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="8">

                                <div class="empty-state">

                                    <i class="fas fa-receipt"></i>

                                    <p>
                                        No orders found.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($orders->hasPages())

            <div class="pagination-wrap">

                {{ $orders->links() }}

            </div>

        @endif

    </div>

</div>


<script>

    // Auto remove alerts
    setTimeout(() => {

        document
            .querySelectorAll('.alert-success, .alert-danger')
            .forEach(el => el.remove());

    }, 5000);

</script>

@endsection
