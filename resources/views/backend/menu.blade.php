@extends('backend.layouts.layout')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background: #f5f7fa;
    }

    .menu-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0;
    }

    .menu-header {
        margin-bottom: 14px;
        padding: 0 20px;
    }

    .menu-title {
        font-family: 'Sora', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: #0a214f;
        margin-bottom: 4px;
        letter-spacing: -0.02em;
    }

    .menu-subtitle {
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Alert Styles */
    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7;
        color: #065f46;
        padding: 10px 12px;
        border-radius: 8px;
        margin: 0 20px 14px;
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
        margin: 0 20px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 500;
        font-size: 12px;
    }

    .alert .btn-close {
        opacity: 1;
        filter: invert(0);
    }

    /* Card Styles */
    .menu-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10, 33, 79, 0.08);
        overflow: hidden;
        margin: 0 20px 16px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .menu-card:hover {
        box-shadow: 0 12px 32px rgba(10, 33, 79, 0.12);
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

    .card-body {
        padding: 16px;
    }

    /* Form Styles */
    .form-label {
        font-family: 'Sora', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #0a214f;
        margin-bottom: 6px;
        display: block;
    }

    .form-label small {
        display: block;
        font-size: 10px;
        font-weight: 500;
        color: #6b7280;
        margin-top: 2px;
    }

    .form-control,
    .form-select {
        border: 1.5px solid #e5e7eb;
        border-radius: 6px;
        padding: 7px 10px;
        font-size: 12px;
        font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1872B5;
        box-shadow: 0 0 0 3px rgba(24, 114, 181, 0.1);
        outline: none;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #ef4444;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 11px;
        margin-top: 4px;
        display: block;
    }

    /* Form Row */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }

    .form-group {
        margin-bottom: 0;
    }

    /* Buttons */
    .btn-group-custom {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
        margin-top: 14px;
        flex-wrap: wrap;
    }

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
        box-shadow: 0 4px 12px rgba(24, 114, 181, 0.3);
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(24, 114, 181, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #1f2937;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .btn-secondary:hover {
        background: #d1d5db;
        transform: translateY(-1px);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #78350f;
        font-weight: 700;
    }

    .btn-warning:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #f87171);
        color: white;
        font-weight: 700;
    }

    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 10px;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        margin-top: 2px;
    }

    .form-check-label {
        font-size: 12px;
        color: #0a214f;
        font-weight: 500;
    }

    /* Table Styles */
    .table-wrapper {
        overflow-x: auto;
        border-radius: 8px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-size: 12px;
    }

    .table thead {
        background: linear-gradient(135deg, #f0f4f8, #e8f0f8);
    }

    .table th {
        padding: 9px 10px;
        text-align: left;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 10px;
        color: #0a214f;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        border-bottom: 2px solid #1872B5;
    }

    .table td {
        padding: 10px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
        color: #374151;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background: #f9fafb;
    }

    .table-primary {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe) !important;
    }

    .table-primary:hover {
        background: linear-gradient(135deg, #bfdbfe, #93c5fd) !important;
    }

    .badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-secondary {
        background: #e5e7eb;
        color: #374151;
    }

    .badge-info {
        background: #bfdbfe;
        color: #1e40af;
    }

    .badge-warning {
        background: #fcd34d;
        color: #78350f;
    }

    code {
        background: #f3f4f6;
        color: #1f2937;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 11px;
        font-family: 'Courier New', monospace;
    }

    .empty-state {
        text-align: center;
        padding: 30px 20px;
    }

    .empty-icon {
        font-size: 40px;
        margin-bottom: 12px;
        opacity: 0.6;
    }

    .empty-text {
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 4px;
        justify-content: center;
    }

    .action-buttons form {
        margin: 0;
    }

    .text-muted {
        color: #6b7280;
        font-size: 11px;
    }

    strong {
        color: #0a214f;
    }

    /* Status Button */
    .status-btn {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .status-btn.active {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
    }

    .status-btn.inactive {
        background: #e5e7eb;
        color: #6b7280;
    }
.adas {
    width: 50%;
    margin-left: 43px;
}
    .form-check .form-check-label {
    display: block;
    margin-left: 0;
    font-size: 0.875rem;
    line-height: 1.5;
}
    /* Responsive */
    @media (max-width: 1024px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .menu-container {
            padding: 0;
        }

        .menu-header,
        .menu-card {
            margin-left: 0;
            margin-right: 0;
        }

        .menu-title {
            font-size: 18px;
        }

        .card-body {
            padding: 12px;
        }

        .btn-group-custom {
            flex-direction: column-reverse;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .table {
            font-size: 11px;
        }

        .table th,
        .table td {
            padding: 8px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 2px;
        }

        .action-buttons .btn {
            width: 100%;
            font-size: 9px;
            padding: 4px 8px;
        }
    }
</style>

<div class="menu-container">
    <!-- Header -->
    <div class="menu-header">
        <h1 class="menu-title">📋 Menu Management</h1>
        <p class="menu-subtitle">Create and manage navigation menus for your website</p>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert-success">
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Alert -->
    @if(session('error'))
        <div class="alert-danger">
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Add/Edit Form Card -->
    <div class="menu-card">
        <div class="card-header-gradient">
            <h2 class="card-header-title">
                @if(isset($editMenu))
                    <i class="fas fa-pen"></i> Edit Menu
                @else
                    <i class="fas fa-plus-circle"></i> Add New Menu
                @endif
            </h2>
        </div>

        <div class="card-body">
            <form action="{{ isset($editMenu) ? route('backend.menu.update', $editMenu->id) : route('backend.menu.store') }}" 
                  method="POST">
                @csrf
                @if(isset($editMenu))
                    @method('PUT')
                @endif
                
                <!-- Row 1 -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="title" class="form-label">
                            Menu Title <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', isset($editMenu) ? $editMenu->title : '') }}"
                               placeholder="Enter menu title"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="url" class="form-label">Menu URL</label>
                        <input type="text" 
                               class="form-control @error('url') is-invalid @enderror" 
                               id="url" 
                               name="url" 
                               value="{{ old('url', isset($editMenu) ? $editMenu->url : '') }}"
                               placeholder="/about or #">
                        <small class="text-muted">Use # for dropdowns</small>
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="parent_id" class="form-label">Parent Menu</label>
                        <select class="form-select @error('parent_id') is-invalid @enderror" 
                                id="parent_id" 
                                name="parent_id">
                            <option value="">── Main Menu ──</option>
                            @foreach($parentMenus as $parent)
                                <option value="{{ $parent->id }}" 
                                    {{ (old('parent_id', isset($editMenu) ? $editMenu->parent_id : '') == $parent->id) ? 'selected' : '' }}>
                                    {{ $parent->title }}
                                </option>
                                @if($parent->children && $parent->children->count() > 0)
                                    @foreach($parent->children as $child)
                                        <option value="{{ $child->id }}" 
                                            {{ (old('parent_id', isset($editMenu) ? $editMenu->parent_id : '') == $child->id) ? 'selected' : '' }}>
                                            &nbsp;&nbsp;└─ {{ $child->title }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                        <small class="text-muted">Leave empty for main menu</small>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="order" class="form-label">
                            Display Order <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="number" 
                               class="form-control @error('order') is-invalid @enderror" 
                               id="order" 
                               name="order" 
                               value="{{ old('order', isset($editMenu) ? $editMenu->order : 0) }}"
                               min="0"
                               placeholder="0"
                               required>
                        <small class="text-muted">Lower = first</small>
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="icon" class="form-label">Icon Class</label>
                        <input type="text" 
                               class="form-control @error('icon') is-invalid @enderror" 
                               id="icon" 
                               name="icon" 
                               value="{{ old('icon', isset($editMenu) ? $editMenu->icon : '') }}"
                               placeholder="fa-home, bi-house">
                        <small class="text-muted">Font Awesome or Bootstrap Icons</small>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="target" class="form-label">Link Target</label>
                        <select class="form-select @error('target') is-invalid @enderror" 
                                id="target" 
                                name="target">
                            <option value="_self" {{ (old('target', isset($editMenu) ? $editMenu->target : '_self') == '_self') ? 'selected' : '' }}>
                                Same Tab
                            </option>
                            <option value="_blank" {{ (old('target', isset($editMenu) ? $editMenu->target : '') == '_blank') ? 'selected' : '' }}>
                                New Tab
                            </option>
                        </select>
                        @error('target')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 4 - Checkbox -->
                <div class="adas" style="margin-bottom: 12px; margin-top: 8px;">
                    <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', isset($editMenu) ? $editMenu->is_active : 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active (Show on website)
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="btn-group-custom">
                    @if(isset($editMenu))
                        <a href="{{ route('backend.menu.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update
                        </button>
                    @else
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Menu
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Menu List Card -->
    <div class="menu-card">
        <div class="card-header-gradient">
            <h2 class="card-header-title">
                <i class="fas fa-list"></i> All Menu Items
            </h2>
        </div>

        <div class="card-body">
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 45px;">ID</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Parent</th>
                            <th style="width: 60px;">Order</th>
                            <th>Icon</th>
                            <th style="width: 65px;">Status</th>
                            <th style="width: 110px;">Created</th>
                            <th style="width: 80px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                            {{-- Main Menu Row --}}
                            <tr class="table-primary">
                                <td><strong>#{{ $menu->id }}</strong></td>
                                <td><strong>{{ $menu->title }}</strong></td>
                                <td><code>{{ $menu->url ?: '#' }}</code></td>
                                <td><span class="badge badge-secondary">Main</span></td>
                                <td style="text-align: center;">{{ $menu->order }}</td>
                                <td>
                                    @if($menu->icon)
                                        <i class="{{ $menu->icon }}" style="font-size: 13px;"></i>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <form action="{{ route('backend.menu.toggle', $menu->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="status-btn {{ $menu->is_active ? 'active' : 'inactive' }}">
                                            {{ $menu->is_active ? 'On' : 'Off' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <small><strong>{{ $menu->created_at->format('d M Y') }}</strong></small><br>
                                    <small class="text-muted">{{ $menu->created_at->format('h:i A') }}</small>
                                </td>
                                <td style="text-align: center;">
                                    <div class="action-buttons">
                                        <a href="{{ route('backend.menu.edit', $menu->id) }}" 
                                           class="btn btn-warning btn-sm"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('backend.menu.destroy', $menu->id) }}" 
                                              method="POST"
                                              onsubmit="return confirm('Delete this menu?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Children/Submenu Rows --}}
                            @if($menu->children && $menu->children->count() > 0)
                                @foreach($menu->children as $child)
                                    <tr>
                                        <td>#{{ $child->id }}</td>
                                        <td><i class="fas fa-arrow-right" style="font-size: 11px;"></i> {{ $child->title }}</td>
                                        <td><code>{{ $child->url ?: '#' }}</code></td>
                                        <td><span class="badge badge-info">{{ $menu->title }}</span></td>
                                        <td style="text-align: center;">{{ $child->order }}</td>
                                        <td>
                                            @if($child->icon)
                                                <i class="{{ $child->icon }}" style="font-size: 13px;"></i>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <form action="{{ route('backend.menu.toggle', $child->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="status-btn {{ $child->is_active ? 'active' : 'inactive' }}">
                                                    {{ $child->is_active ? 'On' : 'Off' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <small><strong>{{ $child->created_at->format('d M Y') }}</strong></small><br>
                                            <small class="text-muted">{{ $child->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="action-buttons">
                                                <a href="{{ route('backend.menu.edit', $child->id) }}" 
                                                   class="btn btn-warning btn-sm"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('backend.menu.destroy', $child->id) }}" 
                                                      method="POST"
                                                      onsubmit="return confirm('Delete this submenu?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm"
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Nested Children (3rd level) --}}
                                    @if($child->children && $child->children->count() > 0)
                                        @foreach($child->children as $subchild)
                                            <tr>
                                                <td>#{{ $subchild->id }}</td>
                                                <td><i class="fas fa-arrow-right" style="font-size: 11px; margin-left: 12px;"></i> {{ $subchild->title }}</td>
                                                <td><code>{{ $subchild->url ?: '#' }}</code></td>
                                                <td><span class="badge badge-warning">{{ $child->title }}</span></td>
                                                <td style="text-align: center;">{{ $subchild->order }}</td>
                                                <td>
                                                    @if($subchild->icon)
                                                        <i class="{{ $subchild->icon }}" style="font-size: 13px;"></i>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    <form action="{{ route('backend.menu.toggle', $subchild->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="status-btn {{ $subchild->is_active ? 'active' : 'inactive' }}">
                                                            {{ $subchild->is_active ? 'On' : 'Off' }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <small><strong>{{ $subchild->created_at->format('d M Y') }}</strong></small><br>
                                                    <small class="text-muted">{{ $subchild->created_at->format('h:i A') }}</small>
                                                </td>
                                                <td style="text-align: center;">
                                                    <div class="action-buttons">
                                                        <a href="{{ route('backend.menu.edit', $subchild->id) }}" 
                                                           class="btn btn-warning btn-sm"
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('backend.menu.destroy', $subchild->id) }}" 
                                                              method="POST"
                                                              onsubmit="return confirm('Delete this submenu?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-danger btn-sm"
                                                                    title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-icon">📭</div>
                                        <p class="empty-text">No menus yet. Create your first menu item above!</p>
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

@endsection
