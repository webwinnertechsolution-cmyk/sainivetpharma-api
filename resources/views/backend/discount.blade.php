{{-- resources/views/backend/discount.blade.php --}}
@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Discounts</h2>
                <a href="{{ route('discount.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Discount
                </a>
            </div>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Discounts Table --}}
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Discounts</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Title / Code</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Method</th>
                                    <th>Uses</th>
                                    <th>Status</th>
                                    <th>Dates</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($discounts as $discount)
                                <tr>
                                    <td>
                                        <strong>{{ $discount->title }}</strong>
                                        @if($discount->code)
                                            <br><span class="badge bg-secondary">{{ $discount->code }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $typeLabels = [
                                                'amount_off_products' => ['label' => 'Amount off products', 'color' => 'primary'],
                                                'buy_x_get_y'         => ['label' => 'Buy X Get Y',         'color' => 'info'],
                                                'amount_off_order'    => ['label' => 'Amount off order',    'color' => 'warning'],
                                                'free_shipping'       => ['label' => 'Free shipping',       'color' => 'success'],
                                            ];
                                            $t = $typeLabels[$discount->type] ?? ['label' => $discount->type, 'color' => 'secondary'];
                                        @endphp
                                        <span class="badge bg-{{ $t['color'] }}">{{ $t['label'] }}</span>
                                    </td>
                                    <td>
                                        @if($discount->type === 'free_shipping')
                                            <span class="text-success">Free</span>
                                        @elseif($discount->type === 'buy_x_get_y')
                                            <span class="text-info">BXGY</span>
                                        @else
                                            @if($discount->value_type === 'percentage')
                                                {{ $discount->value }}%
                                            @else
                                                ₹{{ number_format($discount->value, 2) }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $discount->method === 'discount_code' ? 'dark' : 'light text-dark border' }}">
                                            {{ $discount->method === 'discount_code' ? 'Code' : 'Automatic' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $discount->usages->count() }} uses
                                        </span>
                                    </td>
                                    <td>
                                        @if($discount->isValid())
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            @if($discount->starts_at)
                                                Start: {{ $discount->starts_at->format('d M Y') }}<br>
                                            @endif
                                            @if($discount->ends_at)
                                                End: {{ $discount->ends_at->format('d M Y') }}
                                            @else
                                                <span class="text-success">No end date</span>
                                            @endif
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('discount.edit', $discount->id) }}"
                                           class="btn btn-sm btn-warning mb-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('discount.toggle', $discount->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-sm btn-{{ $discount->is_active ? 'secondary' : 'success' }} mb-1">
                                                <i class="fas fa-{{ $discount->is_active ? 'pause' : 'play' }}"></i>
                                                {{ $discount->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('discount.delete', $discount->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this discount?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger mb-1">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-tag fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted">No discounts found.</p>
                                        <a href="{{ route('discount.create') }}" class="btn btn-primary btn-sm">
                                            Create your first discount
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection