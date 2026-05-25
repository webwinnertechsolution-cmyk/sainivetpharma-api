@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Promotional Banner Management</h2>
            
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

            @if($canAdd || isset($editBanner))
            <!-- Add/Edit Form -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        {{ isset($editBanner) ? 'Edit Promotional Banner' : 'Add Promotional Banner' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editBanner) ? route('promotional.banner.update', $editBanner->id) : route('promotional.banner.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Desktop Image Section -->
                        <div class="card mb-3 border-primary">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-desktop"></i> Desktop Image</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="background_image" class="form-label">
                                                Background Image {{ !isset($editBanner) ? '*' : '' }}
                                            </label>
                                            <input type="file" 
                                                   class="form-control @error('background_image') is-invalid @enderror" 
                                                   id="background_image" 
                                                   name="background_image" 
                                                   accept="image/*"
                                                   {{ !isset($editBanner) ? 'required' : '' }}
                                                   onchange="previewDesktopImage(event)">
                                            @error('background_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Recommended: 1920x400px</small>
                                            
                                            @if(isset($editBanner) && $editBanner->background_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('uploads/promotional-banners/' . $editBanner->background_image) }}" 
                                                         alt="Current Banner" 
                                                         style="max-width: 100%; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                                    <p class="text-muted small mt-1">Current Desktop Image</p>
                                                </div>
                                            @endif
                                            
                                            <div class="mt-2" id="desktopImagePreview" style="display: none;">
                                                <img id="desktopPreview" src="" alt="Preview" 
                                                     style="max-width: 100%; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                                <p class="text-muted small mt-1">New Desktop Image Preview</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="background_image_alt" class="form-label">Desktop Image Alt Tag</label>
                                            <input type="text" 
                                                   class="form-control @error('background_image_alt') is-invalid @enderror" 
                                                   id="background_image_alt" 
                                                   name="background_image_alt" 
                                                   value="{{ old('background_image_alt', isset($editBanner) ? $editBanner->background_image_alt : '') }}"
                                                   placeholder="e.g., Pet food banner sale desktop">
                                            @error('background_image_alt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Image Section -->
                        <div class="card mb-3 border-info">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-mobile-alt"></i> Mobile Image</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="background_image_mobile" class="form-label">
                                                Mobile Background Image {{ !isset($editBanner) ? '*' : '' }}
                                            </label>
                                            <input type="file" 
                                                   class="form-control @error('background_image_mobile') is-invalid @enderror" 
                                                   id="background_image_mobile" 
                                                   name="background_image_mobile" 
                                                   accept="image/*"
                                                   {{ !isset($editBanner) ? 'required' : '' }}
                                                   onchange="previewMobileImage(event)">
                                            @error('background_image_mobile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Recommended: 540x700px (Portrait)</small>
                                            
                                            @if(isset($editBanner) && $editBanner->background_image_mobile)
                                                <div class="mt-2">
                                                    <img src="{{ asset('uploads/promotional-banners/' . $editBanner->background_image_mobile) }}" 
                                                         alt="Current Mobile Banner" 
                                                         style="max-width: 100%; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                    <p class="text-muted small mt-1">Current Mobile Image</p>
                                                </div>
                                            @endif
                                            
                                            <div class="mt-2" id="mobileImagePreview" style="display: none;">
                                                <img id="mobilePreview" src="" alt="Preview" 
                                                     style="max-width: 100%; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                <p class="text-muted small mt-1">New Mobile Image Preview</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="background_image_mobile_alt" class="form-label">Mobile Image Alt Tag</label>
                                            <input type="text" 
                                                   class="form-control @error('background_image_mobile_alt') is-invalid @enderror" 
                                                   id="background_image_mobile_alt" 
                                                   name="background_image_mobile_alt" 
                                                   value="{{ old('background_image_mobile_alt', isset($editBanner) ? $editBanner->background_image_mobile_alt : '') }}"
                                                   placeholder="e.g., Pet food banner sale mobile">
                                            @error('background_image_mobile_alt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Text Content Section -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-heading"></i> Text Content</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sub_heading" class="form-label">Sub Heading</label>
                                            <input type="text" 
                                                   class="form-control @error('sub_heading') is-invalid @enderror" 
                                                   id="sub_heading" 
                                                   name="sub_heading" 
                                                   value="{{ old('sub_heading', isset($editBanner) ? $editBanner->sub_heading : '') }}"
                                                   placeholder="e.g., Up to 50% OFF!">
                                            @error('sub_heading')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="heading" class="form-label">Heading *</label>
                                            <input type="text" 
                                                   class="form-control @error('heading') is-invalid @enderror" 
                                                   id="heading" 
                                                   name="heading" 
                                                   value="{{ old('heading', isset($editBanner) ? $editBanner->heading : '') }}"
                                                   placeholder="e.g., All your Pet's Favourite Brands!"
                                                   required>
                                            @error('heading')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sale_heading" class="form-label">Sale Heading</label>
                                            <input type="text" 
                                                   class="form-control @error('sale_heading') is-invalid @enderror" 
                                                   id="sale_heading" 
                                                   name="sale_heading" 
                                                   value="{{ old('sale_heading', isset($editBanner) ? $editBanner->sale_heading : '') }}"
                                                   placeholder="e.g., Sale end in:">
                                            @error('sale_heading')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="sale_end_date" class="form-label">Sale End Date *</label>
                                            <input type="datetime-local" 
                                                   class="form-control @error('sale_end_date') is-invalid @enderror" 
                                                   id="sale_end_date" 
                                                   name="sale_end_date" 
                                                   value="{{ old('sale_end_date', isset($editBanner) && $editBanner->sale_end_date ? $editBanner->sale_end_date->format('Y-m-d\TH:i') : '') }}"
                                                   required>
                                            @error('sale_end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button Section -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-link"></i> Button</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="button_text" class="form-label">Button Text *</label>
                                            <input type="text" 
                                                   class="form-control @error('button_text') is-invalid @enderror" 
                                                   id="button_text" 
                                                   name="button_text" 
                                                   value="{{ old('button_text', isset($editBanner) ? $editBanner->button_text : 'Shop Now') }}"
                                                   placeholder="e.g., Shop Now"
                                                   required>
                                            @error('button_text')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="button_url" class="form-label">Button URL *</label>
                                            <input type="url" 
                                                   class="form-control @error('button_url') is-invalid @enderror" 
                                                   id="button_url" 
                                                   name="button_url" 
                                                   value="{{ old('button_url', isset($editBanner) ? $editBanner->button_url : '') }}"
                                                   placeholder="https://example.com/shop"
                                                   required>
                                            @error('button_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Status -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', isset($editBanner) ? $editBanner->is_active : true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <strong>Make Banner Active</strong> (Visible on homepage)
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            @if(isset($editBanner))
                                <a href="{{ route('promotional.banner') }}" class="btn btn-secondary me-md-2">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Banner
                                </button>
                            @else
                                <button type="reset" class="btn btn-secondary me-md-2">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create Banner
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Current Banner Preview -->
            @if($banner)
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Current Banner Preview</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Desktop Preview -->
                        <div class="col-md-6">
                            <h6 class="mb-2"><i class="fas fa-desktop"></i> Desktop Preview</h6>
                            @if($banner->background_image)
                                <img src="{{ asset('uploads/promotional-banners/' . $banner->background_image) }}" 
                                     alt="{{ $banner->background_image_alt }}" 
                                     style="width: 100%; max-height: 250px; object-fit: cover; border-radius: 8px; border: 2px solid #ddd;">
                            @else
                                <div style="width: 100%; height: 250px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <p class="text-muted">No desktop image uploaded</p>
                                </div>
                            @endif
                        </div>

                        <!-- Mobile Preview -->
                        <div class="col-md-6">
                            <h6 class="mb-2"><i class="fas fa-mobile-alt"></i> Mobile Preview</h6>
                            <div style="max-width: 280px; margin: 0 auto;">
                                @if($banner->background_image_mobile)
                                    <img src="{{ asset('uploads/promotional-banners/' . $banner->background_image_mobile) }}" 
                                         alt="{{ $banner->background_image_mobile_alt }}" 
                                         style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 8px; border: 2px solid #ddd;">
                                @else
                                    <div style="width: 100%; height: 300px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <p class="text-muted">No mobile image uploaded</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Banner Details -->
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="p-3">
                                <small class="text-muted">SUB HEADING</small>
                                <p class="h6">{{ $banner->sub_heading ?? '-' }}</p>
                                
                                <h4 class="mt-3">{{ $banner->heading ?? '-' }}</h4>
                                
                                <small class="text-muted">{{ $banner->sale_heading ?? 'Sale end in:' }}</small>
                                <p class="small">{{ $banner->sale_end_date ? $banner->sale_end_date->format('d M Y H:i') : '-' }}</p>
                                
                                <a href="{{ $banner->button_url ?? '#' }}" class="btn btn-primary btn-sm mt-3">
                                    {{ $banner->button_text ?? 'Shop Now' }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3">
                                <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }} mb-3">
                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                </span>

                                <div class="mt-3">
                                    <a href="{{ route('promotional.banner.edit', $banner->id) }}" class="btn btn-warning btn-sm me-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('promotional.banner.delete', $banner->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this banner?');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.border-primary {
    border-left: 4px solid #0d6efd !important;
}
.border-info {
    border-left: 4px solid #0dcaf0 !important;
}
</style>

<script>
function previewDesktopImage(event) {
    const preview = document.getElementById('desktopPreview');
    const previewDiv = document.getElementById('desktopImagePreview');
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

function previewMobileImage(event) {
    const preview = document.getElementById('mobilePreview');
    const previewDiv = document.getElementById('mobileImagePreview');
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

@endsection