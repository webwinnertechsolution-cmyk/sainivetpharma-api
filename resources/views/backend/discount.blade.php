{{-- resources/views/backend/discount.blade.php --}}
@extends('backend.layouts.layout')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 10px; color: #6b7280; font-weight: 500; margin: 0; }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7; color: #065f46;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 11px;
    }
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 11px;
    }

    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }

    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-dark {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 10px; background: rgba(255,255,255,0.2); color: #fff; padding: 2px 10px; border-radius: 20px; font-weight: 700; }

    .btn {
        padding: 6px 13px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 10px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary   { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); color: white; }
    .btn-success   { background: linear-gradient(135deg, #059669, #34d399); color: white; box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
    .btn-success:hover { transform: translateY(-1px); color: white; }
    .btn-warning   { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-danger    { background: linear-gradient(135deg, #ef4444, #f87171); color: white; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-sm { padding: 4px 8px; font-size: 10px; }

    /* Table */
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 11px; }
    thead tr { background: #f9fafb; }
    thead th {
        padding: 9px 12px; font-family: 'Sora', sans-serif; font-weight: 700;
        color: #0a214f; font-size: 10px; border-bottom: 2px solid #e5e7eb; white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody td { padding: 9px 12px; color: #374151; vertical-align: middle; font-size: 11px; }

    .badge { font-size: 10px; padding: 3px 8px; border-radius: 20px; font-family: 'Sora', sans-serif; font-weight: 700; display: inline-block; }
    .badge-primary   { background: #dbeafe; color: #1e40af; }
    .badge-info      { background: #cffafe; color: #155e75; }
    .badge-warning   { background: #fef9c3; color: #854d0e; }
    .badge-success   { background: #dcfce7; color: #166534; }
    .badge-secondary { background: #e5e7eb; color: #374151; }
    .badge-dark      { background: #1f2937; color: #f9fafb; }
    .badge-code      { background: #1f2937; color: #f9fafb; }
    .badge-auto      { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
    .badge-uses      { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
    .badge-active    { background: #dcfce7; color: #166534; }
    .badge-inactive  { background: #fee2e2; color: #7f1d1d; }
    .badge-id        { background: #e0e7ff; color: #3730a3; }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 32px; display: block; margin-bottom: 10px; opacity: 0.35; }
    .empty-state p { font-size: 11px; margin: 0; }

    .actions-cell { display: flex; gap: 5px; align-items: center; justify-content: center; flex-wrap: wrap; }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">🏷️ Discounts</h1>
            <p class="page-subtitle">Manage the store's discounts and coupon codes.</p>
        </div>
        <a href="{{ route('discount.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Discount
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert-success">
            <span>✅ {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-danger">
            <span>⚠️ {{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Discounts Table Card --}}
    <div class="page-card">
        <div class="card-header-dark">
            <div class="card-header-row">
                <h2 class="card-header-title"><i class="fas fa-list"></i> All Discounts</h2>
                <span class="table-count">Total: {{ $discounts->count() }}</span>
            </div>
        </div>
        <div style="padding:0;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Title / Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Method</th>
                            <th>Uses</th>
                            <th>Status</th>
                            <th>Dates</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($discounts as $discount)
                        <tr>
                            <td>
                                <strong style="color:#0a214f;">{{ $discount->title }}</strong>
                                @if($discount->code)
                                    <br><span class="badge badge-secondary" style="margin-top:3px;">{{ $discount->code }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $typeLabels = [
                                        'amount_off_products' => ['label' => 'Amount off products', 'class' => 'badge-primary'],
                                        'buy_x_get_y'         => ['label' => 'Buy X Get Y',         'class' => 'badge-info'],
                                        'amount_off_order'    => ['label' => 'Amount off order',    'class' => 'badge-warning'],
                                        'free_shipping'       => ['label' => 'Free shipping',       'class' => 'badge-success'],
                                    ];
                                    $t = $typeLabels[$discount->type] ?? ['label' => $discount->type, 'class' => 'badge-secondary'];
                                @endphp
                                <span class="badge {{ $t['class'] }}">{{ $t['label'] }}</span>
                            </td>
                            <td style="font-size:12px; color:#374151;">
                                @if($discount->type === 'free_shipping')
                                    <span style="color:#059669; font-weight:700;">Free</span>
                                @elseif($discount->type === 'buy_x_get_y')
                                    <span style="color:#155e75; font-weight:700;">BXGY</span>
                                @else
                                    @if($discount->value_type === 'percentage')
                                        <strong>{{ $discount->value }}%</strong>
                                    @else
                                        <strong>₹{{ number_format($discount->value, 2) }}</strong>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($discount->method === 'discount_code')
                                    <span class="badge badge-code">Code</span>
                                @else
                                    <span class="badge badge-auto">Automatic</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-uses">{{ $discount->usages->count() }} uses</span>
                            </td>
                            <td>
                                @if($discount->isValid())
                                    <span class="badge badge-active">Active</span>
                                @else
                                    <span class="badge badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size:10px; color:#374151;">
                                    @if($discount->starts_at)
                                        <div>Start: {{ $discount->starts_at->format('d M Y') }}</div>
                                    @endif
                                    @if($discount->ends_at)
                                        <div>End: {{ $discount->ends_at->format('d M Y') }}</div>
                                    @else
                                        <div style="color:#059669; font-weight:600;">No end date</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('discount.edit', $discount->id) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('discount.toggle', $discount->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm {{ $discount->is_active ? 'btn-secondary' : 'btn-success' }}">
                                            <i class="fas fa-{{ $discount->is_active ? 'pause' : 'play' }}"></i>
                                            {{ $discount->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('discount.delete', $discount->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this discount?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Del
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-tag"></i>
                                    <p>No discounts found.</p>
                                    <a href="{{ route('discount.create') }}" class="btn btn-primary btn-sm" style="margin-top:10px;">
                                        <i class="fas fa-plus"></i> Create your first discount
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    setTimeout(() => {
        document.querySelectorAll('.alert-success, .alert-danger').forEach(el => el.remove());
    }, 5000);
</script>

@endsection
