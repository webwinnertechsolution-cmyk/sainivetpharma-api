@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Blog Categories</h2>
            
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

            <!-- Add Category Form -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Add New Category</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('blog.category.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name *</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           placeholder="Enter category name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100 mb-3">
                                    <i class="fas fa-plus"></i> Add Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Categories</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th style="width: 100px;">Posts Count</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 100px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td><code>{{ $category->slug }}</code></td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $category->blogs_count }} posts</span>
                                    </td>
                                    <td>
                                        <small>{{ $category->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('blog.category.delete', $category->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure? This will remove category from all posts.');">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                                            <p class="mb-0">No categories found. Add your first category above!</p>
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
</style>
@endsection
