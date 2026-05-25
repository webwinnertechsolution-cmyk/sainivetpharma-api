@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12"> 
            <h2 class="mb-4">Menu Management</h2>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Add/Edit Form -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" id="formTitle">
                        {{ isset($editMenu) ? 'Edit Menu' : 'Add New Menu' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editMenu) ? route('backend.menu.update', $editMenu->id) : route('backend.menu.store') }}" 
                          method="POST">
                        @csrf
                        @if(isset($editMenu))
                            @method('PUT')
                        @endif
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Menu Title *</label>
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

                                <div class="mb-3">
                                    <label for="url" class="form-label">Menu URL</label>
                                    <input type="text" 
                                           class="form-control @error('url') is-invalid @enderror" 
                                           id="url" 
                                           name="url" 
                                           value="{{ old('url', isset($editMenu) ? $editMenu->url : '') }}"
                                           placeholder="e.g., /about or # for dropdown">
                                    <small class="text-muted">Use # for menus with submenus</small>
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="parent_id" class="form-label">Parent Menu</label>
                                    <select class="form-control @error('parent_id') is-invalid @enderror" 
                                            id="parent_id" 
                                            name="parent_id">
                                        <option value="">-- Main Menu (No Parent) --</option>
                                        @foreach($parentMenus as $parent)
                                            <option value="{{ $parent->id }}" 
                                                {{ (old('parent_id', isset($editMenu) ? $editMenu->parent_id : '') == $parent->id) ? 'selected' : '' }}>
                                                {{ $parent->title }}
                                            </option>
                                            @if($parent->children && $parent->children->count() > 0)
                                                @foreach($parent->children as $child)
                                                    <option value="{{ $child->id }}" 
                                                        {{ (old('parent_id', isset($editMenu) ? $editMenu->parent_id : '') == $child->id) ? 'selected' : '' }}>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;└─ {{ $child->title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Leave empty for main menu item</small>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Display Order *</label>
                                    <input type="number" 
                                           class="form-control @error('order') is-invalid @enderror" 
                                           id="order" 
                                           name="order" 
                                           value="{{ old('order', isset($editMenu) ? $editMenu->order : 0) }}"
                                           min="0"
                                           placeholder="0"
                                           required>
                                    <small class="text-muted">Lower numbers appear first</small>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icon Class (Optional)</label>
                                    <input type="text" 
                                           class="form-control @error('icon') is-invalid @enderror" 
                                           id="icon" 
                                           name="icon" 
                                           value="{{ old('icon', isset($editMenu) ? $editMenu->icon : '') }}"
                                           placeholder="e.g., fa-home, bi-house">
                                    <small class="text-muted">Font Awesome or Bootstrap Icons class</small>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="target" class="form-label">Link Target</label>
                                    <select class="form-control @error('target') is-invalid @enderror" 
                                            id="target" 
                                            name="target">
                                        <option value="_self" {{ (old('target', isset($editMenu) ? $editMenu->target : '_self') == '_self') ? 'selected' : '' }}>
                                            Same Tab (_self)
                                        </option>
                                        <option value="_blank" {{ (old('target', isset($editMenu) ? $editMenu->target : '') == '_blank') ? 'selected' : '' }}>
                                            New Tab (_blank)
                                        </option>
                                    </select>
                                    @error('target')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
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
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if(isset($editMenu))
                                <a href="{{ route('backend.menu.index') }}" class="btn btn-secondary me-md-2">
                                    Cancel Edit
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Menu
                                </button>
                            @else
                                <button type="reset" class="btn btn-secondary me-md-2">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Menu
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Menu List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Menu Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Title</th>
                                    <th>URL</th>
                                    <th>Parent</th>
                                    <th style="width: 80px;">Order</th>
                                    <th>Icon</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 200px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($menus as $menu)
                                    {{-- Main Menu Row --}}
                                    <tr class="table-primary">
                                        <td><strong>{{ $menu->id }}</strong></td>
                                        <td><strong>{{ $menu->title }}</strong></td>
                                        <td>
                                            <code>{{ $menu->url ?: '#' }}</code>
                                        </td>
                                        <td><span class="badge bg-secondary">Main Menu</span></td>
                                        <td class="text-center">{{ $menu->order }}</td>
                                        <td>
                                            @if($menu->icon)
                                                <i class="{{ $menu->icon }}"></i> {{ $menu->icon }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('backend.menu.toggle', $menu->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $menu->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                    {{ $menu->is_active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <small>{{ $menu->created_at->format('d M Y') }}</small><br>
                                            <small class="text-muted">{{ $menu->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('backend.menu.edit', $menu->id) }}" 
                                               class="btn btn-sm btn-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('backend.menu.destroy', $menu->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this menu?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Children/Submenu Rows --}}
                                    @if($menu->children && $menu->children->count() > 0)
                                        @foreach($menu->children as $child)
                                            <tr>
                                                <td>{{ $child->id }}</td>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-level-up-alt fa-rotate-90"></i> {{ $child->title }}</td>
                                                <td>
                                                    <code>{{ $child->url ?: '#' }}</code>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $menu->title }}</span>
                                                </td>
                                                <td class="text-center">{{ $child->order }}</td>
                                                <td>
                                                    @if($child->icon)
                                                        <i class="{{ $child->icon }}"></i> {{ $child->icon }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('backend.menu.toggle', $child->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $child->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                            {{ $child->is_active ? 'Active' : 'Inactive' }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <small>{{ $child->created_at->format('d M Y') }}</small><br>
                                                    <small class="text-muted">{{ $child->created_at->format('h:i A') }}</small>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('backend.menu.edit', $child->id) }}" 
                                                       class="btn btn-sm btn-warning"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('backend.menu.destroy', $child->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this submenu?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger"
                                                                title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            {{-- Nested Children (3rd level) --}}
                                            @if($child->children && $child->children->count() > 0)
                                                @foreach($child->children as $subchild)
                                                    <tr>
                                                        <td>{{ $subchild->id }}</td>
                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-level-up-alt fa-rotate-90"></i> {{ $subchild->title }}</td>
                                                        <td>
                                                            <code>{{ $subchild->url ?: '#' }}</code>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-warning text-dark">{{ $child->title }}</span>
                                                        </td>
                                                        <td class="text-center">{{ $subchild->order }}</td>
                                                        <td>
                                                            @if($subchild->icon)
                                                                <i class="{{ $subchild->icon }}"></i> {{ $subchild->icon }}
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <form action="{{ route('backend.menu.toggle', $subchild->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm {{ $subchild->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                                    {{ $subchild->is_active ? 'Active' : 'Inactive' }}
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <small>{{ $subchild->created_at->format('d M Y') }}</small><br>
                                                            <small class="text-muted">{{ $subchild->created_at->format('h:i A') }}</small>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('backend.menu.edit', $subchild->id) }}" 
                                                               class="btn btn-sm btn-warning"
                                                               title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('backend.menu.destroy', $subchild->id) }}" 
                                                                  method="POST" 
                                                                  class="d-inline"
                                                                  onsubmit="return confirm('Are you sure you want to delete this submenu?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="btn btn-sm btn-danger"
                                                                        title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-bars fa-3x mb-3"></i>
                                            <p class="mb-0">No menus found. Add your first menu item above!</p>
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
    </div>
</div>

<style>
.table td {
    vertical-align: middle;
}
.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.table-primary {
    background-color: #cfe2ff !important;
}
</style>

@endsection
