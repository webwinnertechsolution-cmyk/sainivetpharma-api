@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Our Service</h2>
            
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
                        {{ isset($editOurService) ? 'Edit Our Service' : 'Add New Our Service' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editOurService) ? route('ourservice.update', $editOurService->id) : route('ourservice.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="main_heading" class="form-label">Main Heading</label>
                                    <input type="text" 
                                           class="form-control @error('main_heading') is-invalid @enderror" 
                                           id="main_heading" 
                                           name="main_heading" 
                                           value="{{ old('main_heading', isset($editOurService) ? $editOurService->main_heading : '') }}"
                                           placeholder="Enter main heading">
                                    @error('main_heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                        Image {{ !isset($editOurService) ? '*' : '' }}
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*"
                                           {{ !isset($editOurService) ? 'required' : '' }}
                                           onchange="previewImage(event)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if(isset($editOurService) && $editOurService->image)
                                        <div class="mt-2" id="currentImage">
                                            <img src="{{ asset('uploads/ourservice/' . $editOurService->image) }}" 
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
                                    
                                    @if(isset($editOurService) && $editOurService->icon)
                                        <div class="mt-2" id="currentIcon">
                                            <img src="{{ asset('uploads/ourservice/icons/' . $editOurService->icon) }}" 
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
                                           value="{{ old('icon_class', isset($editOurService) ? $editOurService->icon_class : '') }}"
                                           placeholder="e.g., byr-saw-5, byr-gear-1, byr-robot-arm">
                                    <small class="text-muted">Enter font icon class name (used instead of icon image)</small>
                                    @error('icon_class')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="heading" class="form-label">Heading</label>
                                    <input type="text" 
                                           class="form-control @error('heading') is-invalid @enderror" 
                                           id="heading" 
                                           name="heading" 
                                           value="{{ old('heading', isset($editOurService) ? $editOurService->heading : '') }}"
                                           placeholder="Enter heading">
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
                                              rows="4"
                                              placeholder="Enter description">{{ old('description', isset($editOurService) ? $editOurService->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="button_text" class="form-label">Button Text</label>
                                    <input type="text" 
                                           class="form-control @error('button_text') is-invalid @enderror" 
                                           id="button_text" 
                                           name="button_text" 
                                           value="{{ old('button_text', isset($editOurService) ? $editOurService->button_text : '') }}"
                                           placeholder="e.g., Learn More">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="button_url" class="form-label">Button URL</label>
                                    <input type="text" 
                                           class="form-control @error('button_url') is-invalid @enderror" 
                                           id="button_url" 
                                           name="button_url" 
                                           value="{{ old('button_url', isset($editOurService) ? $editOurService->button_url : '') }}"
                                           placeholder="https://example.com or /contact">
                                    @error('button_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- SEO Fields Extension -->
                            <div class="col-md-12 mt-4">
                                <h5 class="mb-3">SEO Settings</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', isset($editOurService) ? $editOurService->meta_title : '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" name="meta_keywords" value="{{ old('meta_keywords', isset($editOurService) ? $editOurService->meta_keywords : '') }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description', isset($editOurService) ? $editOurService->meta_description : '') }}</textarea>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="og_title" class="form-label">OG Title</label>
                                        <input type="text" class="form-control" name="og_title" value="{{ old('og_title', isset($editOurService) ? $editOurService->og_title : '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="og_image" class="form-label">OG Image</label>
                                        <input type="file" class="form-control" name="og_image" accept="image/*">
                                        @if(isset($editOurService) && $editOurService->og_image)
                                            <div class="mt-2">
                                                <img src="{{ asset('uploads/ourservice/og/' . $editOurService->og_image) }}" alt="OG Image" style="height: 50px;">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="og_description" class="form-label">OG Description</label>
                                        <textarea class="form-control" name="og_description" rows="3">{{ old('og_description', isset($editOurService) ? $editOurService->og_description : '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if(isset($editOurService))
                                <a href="{{ route('ourservice') }}" class="btn btn-secondary me-md-2">
                                    Cancel Edit
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Our Service
                                </button>
                            @else
                                <button type="reset" class="btn btn-secondary me-md-2">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Our Service
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Our Service List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Our Service Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 120px;">Image</th>
                                    <th>Icon</th>
                                    <th>Main Heading</th>
                                    <th>Heading</th>
                                    <th>Description</th>
                                    <th>Button</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ourServices as $ourService)
                                <tr>
                                    <td>{{ $ourService->id }}</td>
                                    <td>
                                        @if($ourService->image)
                                            <img src="{{ asset('uploads/ourservice/' . $ourService->image) }}" 
                                                 alt="{{ $ourService->heading ?? 'Our Service' }}" 
                                                 style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px;"
                                                 class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ourService->icon)
                                            <img src="{{ asset('uploads/ourservice/icons/' . $ourService->icon) }}" 
                                                 alt="Icon" 
                                                 style="width: 40px; height: 40px; object-fit: contain;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($ourService->main_heading, 30) ?: '-' }}</td>
                                    <td>{{ Str::limit($ourService->heading, 30) ?: '-' }}</td>
                                    <td>{{ Str::limit(strip_tags($ourService->description), 50) ?: '-' }}</td>
                                    <td>
                                        @if($ourService->button_text && $ourService->button_url)
                                            <a href="{{ $ourService->button_url }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary">
                                                {{ $ourService->button_text }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $ourService->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $ourService->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('ourservice.edit', $ourService->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('ourservice.delete', $ourService->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this service?');">
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
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-cogs fa-3x mb-3"></i>
                                            <p class="mb-0">No services found. Add your first Our Service item above!</p>
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

function previewIcon(event) {
    const preview = document.getElementById('iconPreviewImg');
    const previewDiv = document.getElementById('iconPreview');
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
