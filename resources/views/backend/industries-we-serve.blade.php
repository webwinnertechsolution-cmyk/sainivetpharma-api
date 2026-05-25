@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Industries We Serve</h2>
            
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
                        {{ isset($editIndustry) ? 'Edit Industry' : 'Add New Industry' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editIndustry) ? route('industries-we-serve.update', $editIndustry->id) : route('industries-we-serve.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                        Industry Image {{ !isset($editIndustry) ? '*' : '' }}
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*"
                                           {{ !isset($editIndustry) ? 'required' : '' }}
                                           onchange="previewImage(event)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if(isset($editIndustry) && $editIndustry->image)
                                        <div class="mt-2" id="currentImage">
                                            <img src="{{ asset('uploads/industries/' . $editIndustry->image) }}" 
                                                 alt="Current Image" 
                                                 style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                            <p class="text-muted small mt-1">Current Image (Leave empty to keep this)</p>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-2" id="imagePreview" style="display: none;">
                                        <img id="preview" src="" alt="Preview" 
                                             style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                        <p class="text-muted small mt-1">New Image Preview</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icon Image</label>
                                    <input type="file" 
                                           class="form-control @error('icon') is-invalid @enderror" 
                                           id="icon" 
                                           name="icon" 
                                           accept="image/*"
                                           onchange="previewIcon(event)">
                                    <small class="text-muted">Upload icon image (PNG, SVG recommended)</small>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if(isset($editIndustry) && $editIndustry->icon)
                                        <div class="mt-2" id="currentIcon">
                                            <img src="{{ asset('uploads/industries/icons/' . $editIndustry->icon) }}" 
                                                 alt="Current Icon" 
                                                 style="max-width: 80px; max-height: 80px; border: 1px solid #ddd; padding: 5px;">
                                            <p class="text-muted small mt-1">Current Icon (Leave empty to keep this)</p>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-2" id="iconPreview" style="display: none;">
                                        <img id="iconPreviewImg" src="" alt="Icon Preview" 
                                             style="max-width: 80px; max-height: 80px; border: 1px solid #ddd; padding: 5px;">
                                        <p class="text-muted small mt-1">New Icon Preview</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="icon_class" class="form-label">Font Icon Class</label>
                                    <input type="text" 
                                           class="form-control @error('icon_class') is-invalid @enderror" 
                                           id="icon_class" 
                                           name="icon_class" 
                                           value="{{ old('icon_class', isset($editIndustry) ? $editIndustry->icon_class : '') }}"
                                           placeholder="e.g., byr-saw-5, byr-gear-1, byr-robot-arm">
                                    <small class="text-muted">Enter font icon class name (used instead of icon image)</small>
                                    @error('icon_class')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="heading" class="form-label">Industry Name *</label>
                                    <input type="text" 
                                           class="form-control @error('heading') is-invalid @enderror" 
                                           id="heading" 
                                           name="heading" 
                                           value="{{ old('heading', isset($editIndustry) ? $editIndustry->heading : '') }}"
                                           placeholder="e.g., Automotive, Mining, Electronics"
                                           required>
                                    @error('heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="editor" 
                                              name="description" 
                                              rows="8"
                                              placeholder="Enter industry description">{{ old('description', isset($editIndustry) ? $editIndustry->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="link_url" class="form-label">Link URL</label>
                                    <input type="text" 
                                           class="form-control @error('link_url') is-invalid @enderror" 
                                           id="link_url" 
                                           name="link_url" 
                                           value="{{ old('link_url', isset($editIndustry) ? $editIndustry->link_url : '') }}"
                                           placeholder="e.g., /industries/mining or https://example.com">
                                    @error('link_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Optional: Enter a URL or relative path for this industry</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if(isset($editIndustry))
                                <a href="{{ route('industries-we-serve') }}" class="btn btn-secondary me-md-2">
                                    Cancel Edit
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Industry
                                </button>
                            @else
                                <button type="reset" class="btn btn-secondary me-md-2">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Industry
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Industries List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Industries</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 120px;">Image</th>
                                    <th>Industry Name</th>
                                    <th>Description</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($industries as $industry)
                                <tr>
                                    <td>{{ $industry->id }}</td>
                                    <td>
                                        @if($industry->image)
                                            <img src="{{ asset('uploads/industries/' . $industry->image) }}" 
                                                 alt="{{ $industry->heading ?? 'Industry' }}" 
                                                 style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px;"
                                                 class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $industry->heading }}</strong></td>
                                    <td>{{ Str::limit(strip_tags($industry->description), 80) ?: '-' }}</td>
                                    <td>
                                        <small>{{ $industry->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $industry->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('industries-we-serve.edit', $industry->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('industries-we-serve.delete', $industry->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this industry?');">
                                            @csrf
                                            @method('DELETE')
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
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-industry fa-3x mb-3"></i>
                                            <p class="mb-0">No industries found. Add your first industry above!</p>
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

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection
