@extends('backend.layouts.layout')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 10px; color: #6b7280; font-weight: 500; }

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
    .card-header-warning {
        background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
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

    .card-body { padding: 16px; }

    .form-label {
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
        color: #0a214f; margin-bottom: 5px; display: block;
    }
    .form-control {
        border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 6px 10px; font-size: 11px; font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease; width: 100%;
    }
    .form-control:focus {
        border-color: #1872B5; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); outline: none;
    }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 10px; margin-top: 3px; display: block; }
    .form-group { margin-bottom: 12px; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }
    .text-danger { color: #ef4444; }

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

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    /* Form switch */
    .form-check-switch { display: flex; align-items: center; gap: 8px; padding-left: 8px; margin-bottom: 12px; }
    .form-check-switch .form-check-input { width: 36px; height: 20px; accent-color: #1872B5; cursor: pointer; }
    .form-check-switch .form-check-label {
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
        color: #0a214f; cursor: pointer;
    }

    /* two-col layout */
    .two-col { display: grid; grid-template-columns: 420px 1fr; gap: 16px; align-items: start; }

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
    .badge-id       { background: #e0e7ff; color: #3730a3; }
    .badge-active   { background: #dcfce7; color: #166534; }
    .badge-inactive { background: #e5e7eb; color: #374151; }
    .badge-primary  { background: #dbeafe; color: #1e40af; }
    .badge-info     { background: #cffafe; color: #155e75; }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 32px; display: block; margin-bottom: 10px; opacity: 0.35; }
    .empty-state p { font-size: 11px; margin: 0; }

    @media (max-width: 1024px) { .two-col { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .btn-group-custom { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
    }
        .form-check.form-switch {
    width: 61%;
    margin-left: 42px!important;
}
    .form-check .form-check-label {
    display: block;
    margin-left: 0;
    font-size: 0.875rem;
    line-height: 1.5;
}
    .btn.btn-sm, .ajax-upload-dragdrop .btn-sm.ajax-file-upload, .btn-group-sm > .btn, .ajax-upload-dragdrop .btn-group-sm > .ajax-file-upload {
    font-size: 9px!important;
}

.form-group label {
    font-size: 12px;
    line-height: 1;
    vertical-align: top;
    margin-bottom: 0.5rem;
}
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">🚚 Shipping Methods</h1>
        <p class="page-subtitle">Manage the store's shipping methods and delivery options.</p>
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

    <div class="two-col">

        {{-- FORM CARD --}}
        <div class="page-card">
            <div class="{{ isset($editMethod) ? 'card-header-warning' : 'card-header-gradient' }}">
                <h2 class="card-header-title">
                    @if(isset($editMethod))
                        <i class="fas fa-edit"></i> Edit Method
                    @else
                        <i class="fas fa-plus-circle"></i> Add New Method
                    @endif
                </h2>
            </div>
            <div class="card-body">
                <form action="{{ isset($editMethod) ? route('shipping.method.update', $editMethod->id) : route('shipping.method.store') }}"
                      method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Method Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', isset($editMethod) ? $editMethod->name : '') }}"
                               placeholder="e.g. Standard Delivery, Express, Same Day">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"
                                  placeholder="Short description shown to customers">{{ old('description', isset($editMethod) ? $editMethod->description : '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Delivery Time</label>
                        <input type="text" name="delivery_time" class="form-control"
                               value="{{ old('delivery_time', isset($editMethod) ? $editMethod->delivery_time : '') }}"
                               placeholder="e.g. 3-5 business days, Next day">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               value="{{ old('sort_order', isset($editMethod) ? $editMethod->sort_order : 0) }}"
                               min="0">
                    </div>

                    <div class="form-check-switch">
                        <input class="form-check-input" type="checkbox" name="is_active"
                               id="is_active" role="switch"
                               {{ (!isset($editMethod) || $editMethod->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>

                    <hr>

                    <div class="btn-group-custom">
                        @if(isset($editMethod))
                            <a href="{{ route('shipping.method') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Method
                            </button>
                        @else
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Method
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="page-card">
            <div class="card-header-dark">
                <div class="card-header-row">
                    <h2 class="card-header-title"><i class="fas fa-list"></i> All Methods</h2>
                    <span class="table-count">Total: {{ $methods->count() }}</span>
                </div>
            </div>
            <div class="card-body" style="padding:0;">
                @if($methods->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-truck"></i>
                        <p>Koi shipping method nahi mila. Upar se add karein!</p>
                    </div>
                @else
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:40px;">#</th>
                                    <th>Method Name</th>
                                    <th>Delivery Time</th>
                                    <th>Rates</th>
                                    <th>Status</th>
                                    <th style="text-align:center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($methods as $method)
                                <tr>
                                    <td style="text-align:center;">
                                        <span class="badge badge-id">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        <strong style="color:#0a214f;">{{ $method->name }}</strong>
                                        @if($method->description)
                                            <div style="font-size:10px; color:#6b7280; margin-top:2px;">{{ $method->description }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($method->delivery_time)
                                            <span class="badge badge-info">
                                                <i class="fas fa-clock"></i> {{ $method->delivery_time }}
                                            </span>
                                        @else
                                            <span style="color:#9ca3af;">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $method->rates()->count() }} rates</span>
                                    </td>
                                    <td>
                                        @if($method->is_active)
                                            <span class="badge badge-active">Active</span>
                                        @else
                                            <span class="badge badge-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        <div style="display:flex; gap:5px; align-items:center; justify-content:center;">
                                            <a href="{{ route('shipping.method.edit', $method->id) }}"
                                               class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('shipping.method.delete', $method->id) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Delete this method?')">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Del
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
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
