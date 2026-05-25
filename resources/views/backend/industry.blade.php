@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Industries Management</h2>
            
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
                    <h5 class="mb-0">
                        {{ isset($editIndustry) ? 'Edit Industry' : 'Add New Industry' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editIndustry) ? route('industry.update', $editIndustry->id) : route('industry.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Background Image -->
                                <div class="mb-3">
                                    <label for="background_image" class="form-label">Background Image</label>
                                    <input type="file" 
                                           class="form-control @error('background_image') is-invalid @enderror" 
                                           id="background_image" 
                                           name="background_image" 
                                           accept="image/*"
                                           onchange="previewBgImage(event)">
                                    @error('background_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if(isset($editIndustry) && $editIndustry->background_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('uploads/industry/' . $editIndustry->background_image) }}" 
                                                 alt="Current BG" 
                                                 style="max-width: 200px; max-height: 100px; object-fit: cover; border: 1px solid #ddd; padding: 5px;">
                                            <p class="text-muted small mt-1">Current Background (Leave empty to keep)</p>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-2" id="bgImagePreview" style="display: none;">
                                        <img id="bgPreview" src="" alt="Preview" 
                                             style="max-width: 200px; max-height: 100px; object-fit: cover; border: 1px solid #ddd; padding: 5px;">
                                        <p class="text-muted small mt-1">New Background Preview</p>
                                    </div>
                                </div>

                                <!-- Main Image -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                        Main Image {{ !isset($editIndustry) ? '*' : '' }}
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
                                        <div class="mt-2">
                                            <img src="{{ asset('uploads/industry/' . $editIndustry->image) }}" 
                                                 alt="Current Image" 
                                                 style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                            <p class="text-muted small mt-1">Current Image (Leave empty to keep)</p>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-2" id="imagePreview" style="display: none;">
                                        <img id="preview" src="" alt="Preview" 
                                             style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                        <p class="text-muted small mt-1">New Image Preview</p>
                                    </div>
                                </div>

                                <!-- Alt Tag -->
                                <div class="mb-3">
                                    <label for="alt_tag" class="form-label">Image Alt Tag</label>
                                    <input type="text" 
                                           class="form-control @error('alt_tag') is-invalid @enderror" 
                                           id="alt_tag" 
                                           name="alt_tag" 
                                           value="{{ old('alt_tag', isset($editIndustry) ? $editIndustry->alt_tag : '') }}"
                                           placeholder="Enter image alt tag">
                                    @error('alt_tag')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Heading with CKEditor -->
                                <div class="mb-3">
                                    <label for="heading_editor" class="form-label">Heading</label>
                                    <textarea class="form-control @error('heading') is-invalid @enderror" 
                                              id="heading_editor" 
                                              name="heading" 
                                              rows="3"
                                              placeholder="Enter heading">{{ old('heading', isset($editIndustry) ? $editIndustry->heading : '') }}</textarea>
                                    @error('heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description with CKEditor -->
                                <div class="mb-3">
                                    <label for="description_editor" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description_editor" 
                                              name="description" 
                                              rows="5"
                                              placeholder="Enter description">{{ old('description', isset($editIndustry) ? $editIndustry->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Layout Selection -->
                                <div class="mb-3">
                                    <label class="form-label">Layout Position *</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input @error('layout') is-invalid @enderror" 
                                                   type="radio" 
                                                   name="layout" 
                                                   id="layoutLeft" 
                                                   value="left"
                                                   {{ old('layout', isset($editIndustry) ? $editIndustry->layout : 'left') == 'left' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="layoutLeft">
                                                <i class="fas fa-align-left"></i> Image Left - Text Right
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input @error('layout') is-invalid @enderror" 
                                                   type="radio" 
                                                   name="layout" 
                                                   id="layoutRight" 
                                                   value="right"
                                                   {{ old('layout', isset($editIndustry) ? $editIndustry->layout : '') == 'right' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="layoutRight">
                                                <i class="fas fa-align-right"></i> Text Left - Image Right
                                            </label>
                                        </div>
                                    </div>
                                    @error('layout')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Layout Preview -->
                                <div class="alert alert-info mt-3">
                                    <strong><i class="fas fa-info-circle"></i> Layout Preview:</strong>
                                    <div id="layoutPreview" class="mt-2 p-2 bg-white rounded">
                                        <div class="d-flex align-items-center" id="previewContent">
                                            <div class="bg-secondary text-white p-2 rounded me-2" style="width: 80px;">Image</div>
                                            <div class="bg-light p-2 rounded flex-grow-1">Text Content</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            @if(isset($editIndustry))
                                <a href="{{ route('industry') }}" class="btn btn-secondary me-md-2">
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
                                    <th style="width: 120px;">Images</th>
                                    <th>Heading</th>
                                    <th>Description</th>
                                    <th style="width: 100px;">Layout</th>
                                    <th style="width: 150px;">Created</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($industries as $industry)
                                <tr>
                                    <td>{{ $industry->id }}</td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            @if($industry->background_image)
                                                <img src="{{ asset('uploads/industry/' . $industry->background_image) }}" 
                                                     alt="BG" 
                                                     style="width: 100px; height: 40px; object-fit: cover;"
                                                     class="img-thumbnail"
                                                     title="Background Image">
                                            @endif
                                            @if($industry->image)
                                                <img src="{{ asset('uploads/industry/' . $industry->image) }}" 
                                                     alt="{{ $industry->alt_tag }}" 
                                                     style="width: 100px; height: 60px; object-fit: cover;"
                                                     class="img-thumbnail"
                                                     title="Main Image">
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ Str::limit(strip_tags($industry->heading), 30) ?: '-' }}</td>
                                    <td>{{ Str::limit(strip_tags($industry->description), 50) ?: '-' }}</td>
                                    <td>
                                        @if($industry->layout == 'left')
                                            <span class="badge bg-info">
                                                <i class="fas fa-align-left"></i> Left
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-align-right"></i> Right
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $industry->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $industry->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('industry.edit', $industry->id) }}" 
                                           class="btn btn-sm btn-warning mb-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('industry.delete', $industry->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this industry?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger mb-1">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
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

<style>
.table td {
    vertical-align: middle;
}
.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.ck-editor__editable {
    min-height: 150px;
}
</style>

<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

<script>
// Background Image Preview
function previewBgImage(event) {
    const preview = document.getElementById('bgPreview');
    const previewDiv = document.getElementById('bgImagePreview');
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

// Main Image Preview
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

// Layout Preview Update
document.addEventListener('DOMContentLoaded', function() {
    const layoutRadios = document.querySelectorAll('input[name="layout"]');
    const previewContent = document.getElementById('previewContent');
    
    function updateLayoutPreview() {
        const selectedLayout = document.querySelector('input[name="layout"]:checked').value;
        
        if (selectedLayout === 'left') {
            previewContent.innerHTML = `
                <div class="bg-secondary text-white p-2 rounded me-2" style="width: 80px;">Image</div>
                <div class="bg-light p-2 rounded flex-grow-1">Text Content</div>
            `;
        } else {
            previewContent.innerHTML = `
                <div class="bg-light p-2 rounded flex-grow-1 me-2">Text Content</div>
                <div class="bg-secondary text-white p-2 rounded" style="width: 80px;">Image</div>
            `;
        }
    }
    
    layoutRadios.forEach(radio => {
        radio.addEventListener('change', updateLayoutPreview);
    });
    
    // Initial preview
    updateLayoutPreview();
});

// Initialize CKEditor for Heading
let headingEditor;
ClassicEditor
    .create(document.querySelector('#heading_editor'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', '|',
                'link', '|',
                'undo', 'redo'
            ]
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
            ]
        }
    })
    .then(editor => {
        headingEditor = editor;
        console.log('Heading editor initialized successfully');
    })
    .catch(error => {
        console.error('Error initializing heading editor:', error);
    });

// Initialize CKEditor for Description
let descriptionEditor;
ClassicEditor
    .create(document.querySelector('#description_editor'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'link', 'bulletedList', 'numberedList', '|',
                'indent', 'outdent', '|',
                'blockQuote', 'insertTable', '|',
                'undo', 'redo'
            ]
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
            ]
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        }
    })
    .then(editor => {
        descriptionEditor = editor;
        console.log('Description editor initialized successfully');
    })
    .catch(error => {
        console.error('Error initializing description editor:', error);
    });

// Reset button handler for CKEditor
document.addEventListener('DOMContentLoaded', function() {
    const resetButton = document.querySelector('button[type="reset"]');
    if (resetButton) {
        resetButton.addEventListener('click', function() {
            setTimeout(() => {
                if (headingEditor) {
                    headingEditor.setData('');
                }
                if (descriptionEditor) {
                    descriptionEditor.setData('');
                }
            }, 100);
        });
    }
});
</script>

@endsection
