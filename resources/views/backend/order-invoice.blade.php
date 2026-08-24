<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice {{ $order->order_number }}</title>
<style>
*{box-sizing:border-box} @page{size:A4;margin:10mm} body{margin:0;background:#eef2f7;color:#111827;font-family:Arial,Helvetica,sans-serif}.toolbar{max-width:900px;margin:18px auto 10px;display:flex;justify-content:flex-end;gap:10px}.toolbar a,.toolbar button{border:0;border-radius:7px;padding:10px 16px;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none}.btn-back{background:#e5e7eb;color:#1f2937}.btn-print{background:#1872B5;color:#fff}.invoice{width:210mm;min-height:277mm;margin:0 auto 25px;background:#fff;padding:12mm;box-shadow:0 4px 20px rgba(0,0,0,.10)}.invoice-header{display:grid;grid-template-columns:1.3fr .7fr;gap:25px;padding-bottom:18px;border-bottom:2px solid #0a214f}.brand{display:flex;gap:16px;align-items:flex-start}.brand-logo{width:88px;height:88px;object-fit:contain}.brand h1{margin:0 0 8px;color:#0a214f;font-size:22px}.brand p{margin:3px 0;font-size:11px;line-height:1.45;color:#374151}.invoice-meta{text-align:right}.invoice-meta h2{margin:0 0 12px;color:#0a214f;font-size:30px}.meta-row{display:flex;justify-content:flex-end;gap:8px;margin:5px 0;font-size:11px}.meta-label{font-weight:700;color:#4b5563}.meta-value{min-width:125px}.address-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:18px}.address-box{border:1px solid #cfd8e3;border-radius:6px;padding:14px;min-height:125px}.box-title{display:inline-block;background:#0a4e8a;color:#fff;padding:6px 10px;border-radius:4px;font-size:11px;font-weight:700;margin-bottom:10px}.address-box p{margin:3px 0;font-size:11px;line-height:1.5}.items-table{width:100%;border-collapse:collapse;margin-top:18px;font-size:11px}.items-table th{background:#0a4e8a;color:#fff;padding:9px 8px;text-align:left;border:1px solid #0a4e8a}.items-table td{padding:9px 8px;border:1px solid #dbe1e8;vertical-align:middle}.num,.qty{text-align:center}.money{text-align:right;white-space:nowrap}.product-wrap{display:flex;align-items:center;gap:10px}.product-image{width:38px;height:38px;object-fit:contain;border:1px solid #e5e7eb;border-radius:4px}.summary-wrap{width:42%;margin-left:auto;margin-top:12px;border:1px solid #dbe1e8;border-radius:6px;padding:10px 12px}.summary-row{display:flex;justify-content:space-between;gap:15px;padding:6px 0;font-size:11px}.summary-row.total{margin-top:4px;padding-top:10px;border-top:2px solid #cfd8e3;color:#0a214f;font-size:14px;font-weight:800}.payment-grid{display:grid;grid-template-columns:1fr 1fr;margin-top:18px;border:1px solid #dbe1e8;border-radius:6px;overflow:hidden}.payment-box{padding:12px 14px;min-height:72px}.payment-box+.payment-box{border-left:1px solid #dbe1e8}.payment-label{font-size:10px;color:#6b7280;font-weight:700;margin-bottom:8px}.payment-value{font-size:12px;font-weight:700}.paid,.pending{display:inline-block;padding:4px 9px;border-radius:20px;font-size:10px;font-weight:700}.paid{background:#d1fae5;color:#065f46}.pending{background:#fef3c7;color:#92400e}.footer{margin-top:24px;padding-top:14px;border-top:2px solid #0a214f;text-align:center}.footer strong{color:#0a214f;font-size:13px}.footer p{margin:5px 0 0;color:#6b7280;font-size:10px}@media print{body{background:#fff}.toolbar{display:none!important}.invoice{width:100%;min-height:auto;margin:0;padding:0;box-shadow:none}}
</style>
</head>
<body>
<div class="toolbar"><a class="btn-back" href="{{ route('order.view', $order->id) }}">← Back to Order</a><button class="btn-print" onclick="window.print()">🖨 Print / Save PDF</button></div>
<div class="invoice">
<div class="invoice-header">
<div class="brand"><img class="brand-logo" src="https://api.sainivetpharma.com/uploads/logo/1781064546_logo.png" alt="Saini Vet Pharma"><div><h1>SAINI VET PHARMA</h1><p>Issapur Rd, roni, Issapur Rouni,</p><p>Dera Bassi, Punjab 140507</p><p>sainivetpharma0555@gmail.com</p><p>98150 90555</p></div></div>
<div class="invoice-meta"><h2>INVOICE</h2><div class="meta-row"><span class="meta-label">Invoice #:</span><span class="meta-value">INV-{{ $order->order_number }}</span></div><div class="meta-row"><span class="meta-label">Order #:</span><span class="meta-value">{{ $order->order_number }}</span></div><div class="meta-row"><span class="meta-label">Date:</span><span class="meta-value">{{ $order->created_at->format('d M Y, h:i A') }}</span></div></div>
</div>
<div class="address-grid">
<div class="address-box"><div class="box-title">BILL TO</div><p><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p><p>{{ $order->phone }}</p><p>{{ $order->email }}</p><p>{{ $order->address }}@if($order->apartment), {{ $order->apartment }}@endif</p><p>{{ $order->city }}, {{ $order->state }} - {{ $order->zip }}</p><p>{{ $order->country }}</p></div>
<div class="address-box"><div class="box-title">SHIP TO</div><p><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p><p>{{ $order->address }}@if($order->apartment), {{ $order->apartment }}@endif</p><p>{{ $order->city }}, {{ $order->state }} - {{ $order->zip }}</p><p>{{ $order->country }}</p><p>{{ $order->phone }}</p><p>{{ $order->email }}</p></div>
</div>
<table class="items-table"><thead><tr><th class="num">#</th><th>Product</th><th class="qty">Qty</th><th class="money">Unit Price</th><th class="money">Total</th></tr></thead><tbody>
@foreach($order->items as $index => $item)
@php
$imageUrl = null;
if ($item->product_image) {
    $imageUrl = \Illuminate\Support\Str::startsWith($item->product_image, ['http://','https://']) ? $item->product_image : asset('uploads/products/' . ltrim($item->product_image, '/'));
}
@endphp
<tr><td class="num">{{ $index + 1 }}</td><td><div class="product-wrap">@if($imageUrl)<img src="{{ $imageUrl }}" class="product-image" alt="{{ $item->product_name }}">@endif<div><strong>{{ $item->product_name }}</strong>@if($item->product_sku)<div style="font-size:9px;color:#6b7280;margin-top:3px;">SKU: {{ $item->product_sku }}</div>@endif</div></div></td><td class="qty">{{ $item->quantity }}</td><td class="money">₹{{ number_format($item->unit_price, 2) }}</td><td class="money"><strong>₹{{ number_format($item->total_price, 2) }}</strong></td></tr>
@endforeach
</tbody></table>
<div class="summary-wrap"><div class="summary-row"><span>Subtotal</span><strong>₹{{ number_format($order->subtotal, 2) }}</strong></div><div class="summary-row"><span>Shipping</span><strong>₹{{ number_format($order->shipping_cost, 2) }}</strong></div><div class="summary-row total"><span>Total</span><span>₹{{ number_format($order->total, 2) }}</span></div></div>
<div class="payment-grid"><div class="payment-box"><div class="payment-label">PAYMENT METHOD</div><div class="payment-value">{{ str_replace('_',' ',ucfirst($order->payment_method)) }}</div>@if($order->payment_transaction_id)<div style="font-size:9px;color:#6b7280;margin-top:7px;word-break:break-all;">Transaction: {{ $order->payment_transaction_id }}</div>@endif</div><div class="payment-box"><div class="payment-label">PAYMENT STATUS</div>@if(strtolower($order->payment_status)==='paid')<span class="paid">Paid</span>@else<span class="pending">{{ ucfirst($order->payment_status) }}</span>@endif @if($order->paid_at)<div style="font-size:9px;color:#6b7280;margin-top:7px;">Paid at: {{ \Carbon\Carbon::parse($order->paid_at)->format('d M Y, h:i A') }}</div>@endif</div></div>
<div class="footer"><strong>Thank you for your order!</strong><p>We appreciate your business.</p></div>
</div>
</body>
</html>
