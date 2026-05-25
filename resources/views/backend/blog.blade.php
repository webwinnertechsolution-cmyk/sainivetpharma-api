@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Blog Management</h2>
            
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

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Validation Errors:</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Add/Edit Form -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        {{ isset($editBlog) ? 'Edit Blog Post' : 'Add New Blog Post' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form id="blogForm" action="{{ isset($editBlog) ? route('blog.update', $editBlog->id) : route('blog.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Basic Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong>Basic Information</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Title Field -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title *</label>
                                            <input type="text" 
                                                   class="form-control @error('title') is-invalid @enderror" 
                                                   id="title" 
                                                   name="title" 
                                                   value="{{ old('title', isset($editBlog) ? $editBlog->title : '') }}"
                                                   placeholder="Enter blog title"
                                                   required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Slug Field -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug" class="form-label">URL Slug *</label>
                                            <input type="text" 
                                                   class="form-control @error('slug') is-invalid @enderror" 
                                                   id="slug" 
                                                   name="slug" 
                                                   value="{{ old('slug', isset($editBlog) ? $editBlog->slug : '') }}"
                                                   placeholder="url-friendly-slug"
                                                   required>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div id="slug-preview" class="mt-2" style="background: #e9ecef; padding: 10px; border-radius: 5px; font-family: monospace;">
                                                Preview URL: <span id="slug-text">{{ isset($editBlog) && $editBlog->slug ? url($editBlog->slug) : 'Will generate from title' }}</span>
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> You can manually edit this or it will auto-generate from the title
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Excerpt Field -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="excerpt" class="form-label">Excerpt</label>
                                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                                      id="excerpt" 
                                                      name="excerpt" 
                                                      rows="2"
                                                      placeholder="Short summary of the blog post">{{ old('excerpt', isset($editBlog) ? $editBlog->excerpt : '') }}</textarea>
                                            @error('excerpt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Brief description for preview</small>
                                        </div>
                                    </div>

                                    <!-- Content Field -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Content *</label>
                                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                                      id="editor" 
                                                      name="content" 
                                                      rows="6">{{ old('content', isset($editBlog) ? $editBlog->content : '') }}</textarea>
                                            @error('content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Featured Image -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="featured_image" class="form-label">Featured Image</label>
                                            <input type="file" 
                                                   class="form-control @error('featured_image') is-invalid @enderror" 
                                                   id="featured_image" 
                                                   name="featured_image" 
                                                   accept="image/*"
                                                   onchange="previewImage(event, 'featured')">
                                            @error('featured_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                            @if(isset($editBlog) && $editBlog->featured_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('uploads/blogs/' . $editBlog->featured_image) }}" 
                                                         alt="Current Image" 
                                                         style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                                    <p class="text-muted small mt-1">Current Featured Image</p>
                                                </div>
                                            @endif
                                            
                                            <div class="mt-2" id="featured-preview" style="display: none;">
                                                <img id="featured-img" src="" alt="Preview" 
                                                     style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                                <p class="text-muted small mt-1">New Image Preview</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Image Alt Tag & Status -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image_alt_tag" class="form-label">Featured Image Alt Tag</label>
                                            <input type="text" 
                                                   class="form-control @error('image_alt_tag') is-invalid @enderror" 
                                                   id="image_alt_tag" 
                                                   name="image_alt_tag" 
                                                   value="{{ old('image_alt_tag', isset($editBlog) ? $editBlog->image_alt_tag : '') }}"
                                                   placeholder="Image description for SEO">
                                            @error('image_alt_tag')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status *</label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" 
                                                    name="status" 
                                                    required>
                                                <option value="draft" {{ old('status', isset($editBlog) ? $editBlog->status : '') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', isset($editBlog) ? $editBlog->status : '') == 'published' ? 'selected' : '' }}>Published</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Categories & Tags Selection -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="categories" class="form-label">Categories</label>
                                            <select class="form-select @error('categories') is-invalid @enderror" 
                                                    id="categories" 
                                                    name="categories[]" 
                                                    multiple
                                                    style="height: 120px;">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ isset($editBlog) && $editBlog->categories->contains($category->id) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> Hold <strong>Ctrl</strong> (Windows) or <strong>Cmd</strong> (Mac) to select multiple
                                            </small>
                                            @error('categories')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tags" class="form-label">Tags</label>
                                            <select class="form-select @error('tags') is-invalid @enderror" 
                                                    id="tags" 
                                                    name="tags[]" 
                                                    multiple
                                                    style="height: 120px;">
                                                @foreach($tags as $tag)
                                                    <option value="{{ $tag->id }}"
                                                        {{ isset($editBlog) && $editBlog->tags->contains($tag->id) ? 'selected' : '' }}>
                                                        {{ $tag->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> Hold <strong>Ctrl</strong> (Windows) or <strong>Cmd</strong> (Mac) to select multiple
                                            </small>
                                            @error('tags')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong>SEO Settings</strong>
                            </div>
                            <div class="card-body" style="background: #f8f9fa;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" 
                                                   class="form-control @error('meta_title') is-invalid @enderror" 
                                                   id="meta_title" 
                                                   name="meta_title" 
                                                   value="{{ old('meta_title', isset($editBlog) ? $editBlog->meta_title : '') }}"
                                                   placeholder="Leave empty to use post title"
                                                   maxlength="255">
                                            <small class="text-muted">Max 60 characters recommended</small>
                                            @error('meta_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                            <input type="text" 
                                                   class="form-control @error('meta_keywords') is-invalid @enderror" 
                                                   id="meta_keywords" 
                                                   name="meta_keywords" 
                                                   value="{{ old('meta_keywords', isset($editBlog) ? $editBlog->meta_keywords : '') }}"
                                                   placeholder="keyword1, keyword2, keyword3">
                                            <small class="text-muted">Comma-separated keywords</small>
                                            @error('meta_keywords')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                                      id="meta_description" 
                                                      name="meta_description" 
                                                      rows="2"
                                                      maxlength="500">{{ old('meta_description', isset($editBlog) ? $editBlog->meta_description : '') }}</textarea>
                                            <small class="text-muted">Max 160 characters recommended for search results</small>
                                            @error('meta_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media (Open Graph) -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong>Social Media Settings (Open Graph)</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="og_title" class="form-label">OG Title</label>
                                            <input type="text" 
                                                   class="form-control @error('og_title') is-invalid @enderror" 
                                                   id="og_title" 
                                                   name="og_title" 
                                                   value="{{ old('og_title', isset($editBlog) ? $editBlog->og_title : '') }}"
                                                   placeholder="Title for social media sharing">
                                            <small class="text-muted">Leave empty to use post title</small>
                                            @error('og_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="og_image" class="form-label">OG Image</label>
                                            <input type="file" 
                                                   class="form-control @error('og_image') is-invalid @enderror" 
                                                   id="og_image" 
                                                   name="og_image" 
                                                   accept="image/*"
                                                   onchange="previewImage(event, 'og')">
                                            <small class="text-muted">1200x630px recommended</small>
                                            @error('og_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                            @if(isset($editBlog) && $editBlog->og_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('uploads/blogs/og/' . $editBlog->og_image) }}" 
                                                         alt="Current OG Image" 
                                                         style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                                    <p class="text-muted small mt-1">Current OG Image</p>
                                                </div>
                                            @endif
                                            
                                            <div class="mt-2" id="og-preview" style="display: none;">
                                                <img id="og-img" src="" alt="Preview" 
                                                     style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                                <p class="text-muted small mt-1">New OG Image Preview</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="og_description" class="form-label">OG Description</label>
                                            <textarea class="form-control @error('og_description') is-invalid @enderror" 
                                                      id="og_description" 
                                                      name="og_description" 
                                                      rows="2">{{ old('og_description', isset($editBlog) ? $editBlog->og_description : '') }}</textarea>
                                            <small class="text-muted">Description when shared on social media</small>
                                            @error('og_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="og_image_alt_tag" class="form-label">OG Image Alt Tag</label>
                                            <input type="text" 
                                                   class="form-control @error('og_image_alt_tag') is-invalid @enderror" 
                                                   id="og_image_alt_tag" 
                                                   name="og_image_alt_tag" 
                                                   value="{{ old('og_image_alt_tag', isset($editBlog) ? $editBlog->og_image_alt_tag : '') }}"
                                                   placeholder="OG image description">
                                            @error('og_image_alt_tag')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if(isset($editBlog))
                                <a href="{{ route('blog') }}" class="btn btn-secondary me-md-2">
                                    Cancel Edit
                                </a>
                                <button type="submit" id="submitBtn" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Blog Post
                                </button>
                            @else
                                <button type="reset" class="btn btn-secondary me-md-2">
                                    Reset
                                </button>
                                <button type="submit" id="submitBtn" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Blog Post
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Blog List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Blog Posts</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 120px;">Image</th>
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>Categories</th>
                                    <th>Tags</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 130px;">Published</th>
                                    <th style="width: 200px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogs as $blog)
                                <tr>
                                    <td>{{ $blog->id }}</td>
                                    <td>
                                        @if($blog->featured_image)
                                            <img src="{{ asset('uploads/blogs/' . $blog->featured_image) }}" 
                                                 alt="{{ $blog->image_alt_tag ?? 'Blog Image' }}" 
                                                 style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px;"
                                                 class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($blog->title, 40) }}</td>
                                    <td>
                                        <code style="font-size: 11px;">{{ Str::limit($blog->slug, 30) }}</code>
                                    </td>
                                    <td>
                                        @if($blog->categories->count() > 0)
                                            @foreach($blog->categories as $category)
                                                <span class="badge bg-primary mb-1">{{ $category->name }}</span><br>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->tags->count() > 0)
                                            @foreach($blog->tags as $tag)
                                                <span class="badge bg-info mb-1">{{ $tag->name }}</span><br>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->published_at)
                                            <small>{{ $blog->published_at->format('d M Y') }}</small><br>
                                            <small class="text-muted">{{ $blog->published_at->format('h:i A') }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('blog.edit', $blog->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('blog.delete', $blog->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this blog post?');">
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
                                            <i class="fas fa-blog fa-3x mb-3"></i>
                                            <p class="mb-0">No blog posts found. Create your first blog post above!</p>
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
#slug-preview {
    transition: all 0.3s ease;
}
</style>

<!-- CKEditor for rich text -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
let editorInstance;

// Initialize CKEditor
ClassicEditor
    .create(document.querySelector('#editor'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
    })
    .then(editor => {
        editorInstance = editor;
        console.log('CKEditor initialized successfully');
    })
    .catch(error => {
        console.error('CKEditor initialization error:', error);
    });

// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function(e) {
    const title = e.target.value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    
    const slugInput = document.getElementById('slug');
    // Only auto-fill if empty or was previously auto-generated
    if (!slugInput.value || slugInput.dataset.wasAuto === 'true') {
        slugInput.value = slug;
        slugInput.dataset.wasAuto = 'true';
    }
    
    updateSlugPreview();

    // Auto-fill SEO fields if empty
    if (!document.getElementById('meta_title').value) {
        document.getElementById('meta_title').value = title.substring(0, 60);
    }
    if (!document.getElementById('og_title').value) {
        document.getElementById('og_title').value = title;
    }
});

// Manual slug editing
document.getElementById('slug').addEventListener('input', function(e) {
    this.dataset.wasAuto = 'false'; // Mark as manually edited
    updateSlugPreview();
});

// Update slug preview
function updateSlugPreview() {
    const slug = document.getElementById('slug').value;
    const slugText = document.getElementById('slug-text');
    
    if (slug) {
        slugText.textContent = window.location.origin + '/' + slug;
    } else {
        slugText.textContent = 'Will generate from title';
    }
}

// Initialize on page load
window.addEventListener('DOMContentLoaded', function() {
    updateSlugPreview();
});

// Preview images
function previewImage(event, type) {
    const file = event.target.files[0];
    const previewDiv = document.getElementById(type + '-preview');
    const previewImg = document.getElementById(type + '-img');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        previewDiv.style.display = 'none';
    }
}

// Form submit handler
document.getElementById('blogForm').addEventListener('submit', function(e) {
    console.log('Form submit triggered');
    
    // Get CKEditor content
    if (editorInstance) {
        const editorData = editorInstance.getData();
        document.querySelector('#editor').value = editorData;
        console.log('CKEditor content:', editorData.substring(0, 50) + '...');
    }
    
    // Validate required fields
    const title = document.querySelector('#title').value.trim();
    const slug = document.querySelector('#slug').value.trim();
    const content = document.querySelector('#editor').value.trim();
    const status = document.querySelector('#status').value;
    
    console.log('Title:', title);
    console.log('Slug:', slug);
    console.log('Content length:', content.length);
    console.log('Status:', status);
    
    if (!title) {
        e.preventDefault();
        alert('Please enter a title');
        return false;
    }
    
    if (!slug) {
        e.preventDefault();
        alert('Please enter a slug');
        return false;
    }
    
    if (!content || content === '<p>&nbsp;</p>' || content === '') {
        e.preventDefault();
        alert('Please enter content');
        return false;
    }
    
    if (!status) {
        e.preventDefault();
        alert('Please select status');
        return false;
    }
    
    // Show loading state
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    
    console.log('Form validation passed, submitting...');
    return true;
});
</script>

@endsection