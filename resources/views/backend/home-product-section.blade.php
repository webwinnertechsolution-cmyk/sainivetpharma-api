@extends('backend.layouts.layout')
@section('title', 'Home Product Sections')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">🛍️ Home Product Sections</h2>
            </div>

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

            {{-- Shortcode Info Box --}}
            <div class="alert alert-info d-flex align-items-start gap-3 mb-4">
                <span style="font-size:22px;">💡</span>
                <div>
                    <strong>Shortcode Usage:</strong> After creating the section, note its ID and paste it here in your home.blade.php:<br>
                    <code style="background:#fff;padding:3px 10px;border-radius:6px;font-size:13px;">
                        &#123;!! render_product_section(1) !!&#125;
                    </code>
                    &nbsp; or &nbsp;
                    <code style="background:#fff;padding:3px 10px;border-radius:6px;font-size:13px;">
                        @{{ shortcode('product_section', 1) }}
                    </code>
                </div>
            </div>

            <div class="row">

                {{-- ── FORM ── --}}
                <div class="col-lg-5 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                {{ isset($editSection) ? '✏️ Edit Section' : '➕ Add New Section' }}
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(isset($editSection))
                                <form action="{{ route('home.product.section.update', $editSection->id) }}" method="POST">
                            @else
                                <form action="{{ route('home.product.section.store') }}" method="POST">
                            @endif
                            @csrf

                            {{-- Heading --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Heading <span class="text-danger">*</span></label>
                                <input type="text" name="heading" class="form-control @error('heading') is-invalid @enderror"
                                    value="{{ old('heading', $editSection->heading ?? '') }}"
                                    placeholder="e.g. Today's Offer ⚡" required>
                                @error('heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Sub Heading --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sub Heading</label>
                                <input type="text" name="sub_heading" class="form-control"
                                    value="{{ old('sub_heading', $editSection->sub_heading ?? '') }}"
                                    placeholder="e.g. Best prices available today.">
                            </div>

                            {{-- View All Button Text --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">View All Button Text</label>
                                <input type="text" name="view_all_text" class="form-control"
                                    value="{{ old('view_all_text', $editSection->view_all_text ?? 'View All') }}"
                                    placeholder="View All">
                            </div>

                            {{-- View All URL --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">View All URL</label>
                                <input type="text" name="view_all_url" class="form-control"
                                    value="{{ old('view_all_url', $editSection->view_all_url ?? '') }}"
                                    placeholder="e.g. /collections or /collections/insecticides">
                            </div>

                            {{-- Category --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Category (Products Filter)</label>
                                <select name="category_id" class="form-select">
                                    <option value="">— All Products (No Filter) —</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id', $editSection->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Choose a category or leave it blank (all products will be shown).</small>
                            </div>

                            {{-- Product Limit --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">How Many Products to Show</label>
                                <select name="product_limit" class="form-select">
                                    @foreach([4,5,6,8,10,12] as $n)
                                        <option value="{{ $n }}"
                                            {{ old('product_limit', $editSection->product_limit ?? 5) == $n ? 'selected' : '' }}>
                                            {{ $n }} Products
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Sort Order --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" min="0"
                                    value="{{ old('sort_order', $editSection->sort_order ?? 0) }}">
                            </div>

                            {{-- Active --}}
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                    {{ old('is_active', $editSection->is_active ?? 1) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">Active (Show on frontend)</label>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($editSection) ? '💾 Update' : '➕ Add Section' }}
                                </button>
                                @if(isset($editSection))
                                    <a href="{{ route('home.product.section') }}" class="btn btn-secondary">Cancel</a>
                                @endif
                            </div>

                            </form>
                        </div>
                    </div>
                </div>

                {{-- ── LIST ── --}}
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">All Sections ({{ $sections->count() }})</h5>
                        </div>
                        <div class="card-body p-0">
                            @if($sections->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">ID</th>
                                            <th>Heading</th>
                                            <th>Category</th>
                                            <th width="80">Products</th>
                                            <th width="80">Status</th>
                                            <th width="130">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sections as $sec)
                                        <tr>
                                            <td class="align-middle text-center">
                                                <span class="badge bg-secondary fs-6">#{{ $sec->id }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="fw-semibold">{{ $sec->heading }}</div>
                                                @if($sec->sub_heading)
                                                    <small class="text-muted">{{ $sec->sub_heading }}</small>
                                                @endif
                                                <div class="mt-1">
    <code style="font-size:11px;background:#f0f4f8;padding:2px 7px;border-radius:4px;">
        @php echo htmlspecialchars('{!! render_product_section(' . $sec->id . ') !!}'); @endphp
    </code>
</div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge bg-light text-dark border">
                                                    {{ $sec->category->name ?? 'All Products' }}
                                                </span>
                                            </td> 
                                            <td class="align-middle text-center">{{ $sec->product_limit }}</td>
                                            <td class="align-middle text-center">
                                                @if($sec->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('home.product.section.edit', $sec->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('home.product.section.delete', $sec->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this section?')">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger">Del</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="p-4 text-center text-muted">No sections yet. Add your first one!</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection