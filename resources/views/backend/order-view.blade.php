@extends('backend.layouts.layout')
@section('title', 'Order Detail')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1300px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 20px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 12px; color: #6b7280; font-weight: 500; }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7; color: #065f46;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        font-weight: 500; font-size: 12px;
    }

    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 5px; text-decoration: none;
    }
    .btn-secondary { background: #e5e7eb; color: #1f2937; }
    .btn-secondary:hover { background: #d1d5db; }
    .btn-primary { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; }

    .two-col { display: grid; grid-template-columns: 1fr 340px; gap: 16px; align-items: start; }

    .page-card {
        background: #fff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb; margin-bottom: 16px;
    }
    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .card-body { padding: 16px 20px; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 10px; border-radius: 20px; font-size: 11px;
        font-family: 'Sora', sans-serif; font-weight: 700;
    }
    .status-pending    { background: #fef3c7; color: #92400e; }
    .status-processing { background: #dbeafe; color: #1e40af; }
    .status-shipped     { background: #e0e7ff; color: #3730a3; }
    .status-delivered  { background: #d1fae5; color: #065f46; }
    .status-cancelled  { background: #fee2e2; color: #7f1d1d; }
    .pay-pending  { background: #fef3c7; color: #92400e; }
    .pay-paid     { background: #d1fae5; color: #065f46; }
    .pay-failed   { background: #fee2e2; color: #7f1d1d; }
    .pay-refunded { background: #f3f4f6; color: #6b7280; }

    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    thead th {
        padding: 9px 10px; font-family: 'Sora', sans-serif; font-weight: 700;
        color: #0a214f; font-size: 11px; border-bottom: 2px solid #e5e7eb; text-align: left;
    }
    tbody td { padding: 9px 10px; color: #374151; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    .item-thumb { width: 44px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid #e5e7eb; background: #f9fafb; }

    .info-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 12px; border-bottom: 1px dashed #f0f0f0; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #6b7280; font-weight: 600; }
    .info-value { color: #0a214f; font-weight: 700; text-align: right; }

    .totals-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 12px; }
    .totals-row.grand { font-size: 15px; font-weight: 800; color: #0a214f; padding-top: 10px; margin-top: 6px; border-top: 2px solid #e5e7eb; }

    .status-form { display: flex; gap: 8px; align-items: center; }
    .status-form select {
        border: 1.5px solid #e5e7eb; border-radius: 6px; padding: 6px 8px;
        font-size: 12px; font-family: 'Nunito', sans-serif;
    }

    address { font-style: normal; font-size: 12px; line-height: 1.7; color: #374151; }

    @media (max-width: 1024px) { .two-col { grid-template-columns: 1fr; } }
</style>

<div class="page-container">

    <div class="page-header">
        <div>
            <h1 class="page-title">🧾 Order {{ $order->order_number }}</h1>
            <p class="page-subtitle">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>

        <div style="
            display:flex;
            align-items:center;
            gap:8px;
            flex-wrap:wrap;
        ">

            <a
                href="{{ route('order.invoice', $order->id) }}"
                target="_blank"
                class="btn btn-primary"
            >
                <i class="fas fa-print"></i>
                Print Invoice
            </a>

            <a href="{{ route('orders') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Orders
            </a>

        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="two-col">

        {{-- LEFT: Items + Address --}}
        <div>
            <div class="page-card">
                <div class="card-header-gradient">
                    <h2 class="card-header-title"><i class="fas fa-box"></i> Order Items</h2>
                </div>
                <div class="card-body" style="padding:0;">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:60px;">Image</th>
                                <th>Product</th>
                                <th style="text-align:center;">Qty</th>
                                <th style="text-align:right;">Unit Price</th>
                                <th style="text-align:right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    @if($item->product_image)
                                        @php
                                            $img = $item->product_image;
                                            $imgUrl = \Illuminate\Support\Str::startsWith($img, ['http://', 'https://'])
                                                ? $img
                                                : asset('uploads/product/' . ltrim($img, '/'));
                                        @endphp
                                        <img src="{{ $imgUrl }}" class="item-thumb" alt="{{ $item->product_name }}"
                                             onerror="this.onerror=null;this.src='{{ asset('uploads/products/' . ltrim($item->product_image, '/')) }}'">
                                    @else
                                        <div class="item-thumb"></div>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight:700;color:#0a214f;">{{ $item->product_name }}</div>
                                    @if($item->product_sku)
                                        <div style="font-size:10px;color:#6b7280;">SKU: {{ $item->product_sku }}</div>
                                    @endif
                                </td>
                                <td style="text-align:center;">{{ $item->quantity }}</td>
                                <td style="text-align:right;">₹{{ number_format($item->unit_price, 2) }}</td>
                                <td style="text-align:right;font-weight:700;color:#0a214f;">₹{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="page-card">
                <div class="card-header-gradient">
                    <h2 class="card-header-title"><i class="fas fa-map-marker-alt"></i> Shipping Address</h2>
                </div>
                <div class="card-body">
                    <address>
                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                        {{ $order->address }}@if($order->apartment), {{ $order->apartment }}@endif<br>
                        {{ $order->city }}, {{ $order->state }} - {{ $order->zip }}<br>
                        {{ $order->country }}<br><br>
                        📞 {{ $order->phone }}<br>
                        ✉️ {{ $order->email }}
                    </address>
                </div>
            </div>
        </div>

        {{-- RIGHT: Status + Summary --}}
        <div>
            <div class="page-card">
                <div class="card-header-gradient">
                    <h2 class="card-header-title"><i class="fas fa-truck"></i> Order Status</h2>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Current Status</span>
                        <span class="badge status-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span>
                    </div>
                    <form action="{{ route('order.update.status', $order->id) }}" method="POST" class="status-form" style="margin-top:10px;">
                        @csrf
                        <select name="order_status" style="flex:1;">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                                <option value="{{ $status }}" {{ $order->order_status == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>

                    <hr style="margin:14px 0;border:none;border-top:1px solid #e5e7eb;">

                    <div class="info-row">
                        <span class="info-label">Payment Status</span>
                        <span class="badge pay-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                    </div>
                    <form action="{{ route('order.update.payment.status', $order->id) }}" method="POST" class="status-form" style="margin-top:10px;">
                        @csrf
                        <select name="payment_status" style="flex:1;">
                            @foreach(['pending','paid','failed','refunded'] as $pstatus)
                                <option value="{{ $pstatus }}" {{ $order->payment_status == $pstatus ? 'selected' : '' }}>
                                    {{ ucfirst($pstatus) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>

                    <div class="info-row" style="margin-top:10px;">
                        <span class="info-label">Payment Method</span>
                        <span class="info-value">{{ str_replace('_',' ', ucfirst($order->payment_method)) }}</span>
                    </div>
                    @if($order->payment_transaction_id)
                    <div class="info-row">
                        <span class="info-label">Transaction ID</span>
                        <span class="info-value">{{ $order->payment_transaction_id }}</span>
                    </div>
                    @endif
                    @if($order->paid_at)
                    <div class="info-row">
                        <span class="info-label">Paid At</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($order->paid_at)->format('d M Y, h:i A') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="page-card">
                <div class="card-header-gradient">
                    <h2 class="card-header-title"><i class="fas fa-receipt"></i> Order Summary</h2>
                </div>
                <div class="card-body">
                    <div class="totals-row">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="totals-row">
                        <span>Shipping</span>
                        <span>₹{{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="totals-row grand">
                        <span>Total</span>
                        <span>₹{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
