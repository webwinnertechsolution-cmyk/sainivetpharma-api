@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Core Values</h2>
            
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
                        {{ isset($editCoreValue) ? 'Edit Core Value' : 'Add New Core Value' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editCoreValue) ? route('corevalues.update', $editCoreValue->id) : route('corevalues.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                        Image {{ !isset($editCoreValue) ? '*' : '' }}
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*"
                                           {{ !isset($editCoreValue) ? 'required' : '' }}
                                           onchange="previewImage(event)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if(isset($editCoreValue) && $editCoreValue->image)
                                        <div class="mt-2" id="currentImage">
                                            @if(Str::contains($editCoreValue->image, ['.png', '.jpg', '.jpeg', '.webp', '.gif', '.svg']))
                                                <img src="{{ asset('uploads/corevalues/' . $editCoreValue->image) }}" 
                                                     alt="Current Image" 
                                                     style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                            @else
                                                <div style="width: 100px; height: 100px; background: #f8f9fa; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; font-size: 40px; color: #DA200B;">
                                                    <i class="{{ $editCoreValue->image }}"></i>
                                                </div>
                                            @endif
                                            <p class="text-muted small mt-1">Current Item: {{ $editCoreValue->image }}</p>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-2" id="imagePreview" style="display: none;">
                                        <img id="preview" src="" alt="Preview" 
                                             style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                        <p class="text-muted small mt-1">New Image Preview</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="heading" class="form-label">Heading *</label>
                                    <input type="text" 
                                           class="form-control @error('heading') is-invalid @enderror" 
                                           id="heading" 
                                           name="heading" 
                                           value="{{ old('heading', isset($editCoreValue) ? $editCoreValue->heading : '') }}"
                                           placeholder="Enter heading"
                                           required>
                                    @error('heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if(isset($editCoreValue))
                                <a href="{{ route('corevalues') }}" class="btn btn-secondary me-md-2">
                                    Cancel Edit
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Core Value
                                </button>
                            @else
                                <button type="reset" class="btn btn-secondary me-md-2">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Core Value
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Core Values List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Core Values Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 150px;">Image</th>
                                    <th>Heading</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coreValues as $coreValue)
                                <tr>
                                    <td>{{ $coreValue->id }}</td>
                                    <td>
                                        @if($coreValue->image)
                                            @if(Str::contains($coreValue->image, ['.png', '.jpg', '.jpeg', '.webp', '.gif', '.svg']))
                                                <img src="{{ asset('uploads/corevalues/' . $coreValue->image) }}" 
                                                     alt="{{ $coreValue->heading ?? 'Core Value' }}" 
                                                     style="width: 120px; height: 80px; object-fit: cover; border-radius: 5px;"
                                                     class="img-thumbnail">
                                            @else
                                                <div style="width: 120px; height: 80px; background: #f8f9fa; border: 1px solid #dee2e6; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #DA200B; border-radius: 5px;">
                                                    <i class="{{ $coreValue->image }}"></i>
                                                </div>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">No Icon/Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $coreValue->heading ?: '-' }}</td>
                                    <td>
                                        <small>{{ $coreValue->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $coreValue->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('corevalues.edit', $coreValue->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('corevalues.delete', $coreValue->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this core value?');">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger mb-1"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-heart fa-3x mb-3"></i>
                                            <p class="mb-0">No core values found. Add your first Core Value item above!</p>
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

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewDiv.style.display = 'none';
    }
}
</script>

<style>
.table td {
    vertical-align: middle;
}
.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
</style>

@endsection
