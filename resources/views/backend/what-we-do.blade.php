@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">What We Do</h2>
            
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
                        {{ isset($editWhatWeDo) ? 'Edit What We Do' : 'Add New What We Do' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editWhatWeDo) ? route('whatwedo.update', $editWhatWeDo->id) : route('whatwedo.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">
                                        Image {{ !isset($editWhatWeDo) ? '*' : '' }}
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*"
                                           {{ !isset($editWhatWeDo) ? 'required' : '' }}
                                           onchange="previewImage(event)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if(isset($editWhatWeDo) && $editWhatWeDo->image)
                                        <div class="mt-2" id="currentImage">
                                            <img src="{{ asset('uploads/whatwedo/' . $editWhatWeDo->image) }}" 
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
                                    <label for="alt_tag" class="form-label">Image Alt Tag</label>
                                    <input type="text" 
                                           class="form-control @error('alt_tag') is-invalid @enderror" 
                                           id="alt_tag" 
                                           name="alt_tag" 
                                           value="{{ old('alt_tag', isset($editWhatWeDo) ? $editWhatWeDo->alt_tag : '') }}"
                                           placeholder="Enter image alt tag">
                                    @error('alt_tag')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="heading" class="form-label">Heading</label>
                                    <input type="text" 
                                           class="form-control @error('heading') is-invalid @enderror" 
                                           id="heading" 
                                           name="heading" 
                                           value="{{ old('heading', isset($editWhatWeDo) ? $editWhatWeDo->heading : '') }}"
                                           placeholder="Enter heading">
                                    <small class="text-muted">Use <code>&lt;span class="text-red"&gt;Word&lt;/span&gt;</code> to make a word red.</small>
                                    @error('heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="description" class="form-label mb-0">Description</label>
                                        <button type="button" id="toggleEditorBtn" class="btn btn-sm btn-outline-info" onclick="toggleEditor()">Show HTML Source</button>
                                    </div>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="editor" 
                                              name="description" 
                                              rows="4"
                                              placeholder="Enter description">{{ old('description', isset($editWhatWeDo) ? $editWhatWeDo->description : '') }}</textarea>
                                    <small class="text-muted">Use <code>&lt;span class="text-red"&gt;Word&lt;/span&gt;</code> to make a word red.</small>
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
                                           value="{{ old('button_text', isset($editWhatWeDo) ? $editWhatWeDo->button_text : '') }}"
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
                                           value="{{ old('button_url', isset($editWhatWeDo) ? $editWhatWeDo->button_url : '') }}"
                                           placeholder="https://example.com or /contact">
                                    @error('button_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if(isset($editWhatWeDo))
                                <a href="{{ route('whatwedo') }}" class="btn btn-secondary me-md-2">
                                    Cancel Edit
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update What We Do
                                </button>
                            @else
                                <button type="reset" class="btn btn-secondary me-md-2">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add What We Do
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- What We Do List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All What We Do Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 120px;">Image</th>
                                    <th>Heading</th>
                                    <th>Description</th>
                                    <th>Button</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($whatWeDos as $whatWeDo)
                                <tr>
                                    <td>{{ $whatWeDo->id }}</td>
                                    <td>
                                        @if($whatWeDo->image)
                                            <img src="{{ asset('uploads/whatwedo/' . $whatWeDo->image) }}" 
                                                 alt="{{ $whatWeDo->alt_tag ?? 'What We Do' }}" 
                                                 style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px;"
                                                 class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($whatWeDo->heading, 30) ?: '-' }}</td>
                                    <td>{{ Str::limit(strip_tags($whatWeDo->description), 50) ?: '-' }}</td>
                                    <td>
                                        @if($whatWeDo->button_text && $whatWeDo->button_url)
                                            <a href="{{ $whatWeDo->button_url }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary">
                                                {{ $whatWeDo->button_text }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $whatWeDo->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $whatWeDo->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('whatwedo.edit', $whatWeDo->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('whatwedo.delete', $whatWeDo->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this item?');">
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
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-images fa-3x mb-3"></i>
                                            <p class="mb-0">No items found. Add your first What We Do item above!</p>
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
    let editorInstance;
    const editorElement = document.querySelector('#editor');
    const toggleBtn = document.getElementById('toggleEditorBtn');

    function initEditor() {
        ClassicEditor
            .create(editorElement)
            .then(editor => {
                editorInstance = editor;
                toggleBtn.innerText = 'Show HTML Source';
                toggleBtn.classList.replace('btn-outline-success', 'btn-outline-info');
            })
            .catch(error => {
                console.error(error);
            });
    }

    function toggleEditor() {
        if (editorInstance) {
            // Saving data back to textarea before destroying
            editorElement.value = editorInstance.getData();
            editorInstance.destroy()
                .then(() => {
                    editorInstance = null;
                    toggleBtn.innerText = 'Enable Rich Editor';
                    toggleBtn.classList.replace('btn-outline-info', 'btn-outline-success');
                });
        } else {
            initEditor();
        }
    }

    // Initialize on page load
    initEditor();
</script>

@endsection
