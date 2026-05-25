@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Privacy Policy Management</h2>
            
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
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Add/Edit Form -->
            @if($canAdd || isset($page))
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        {{ isset($page) ? 'Edit Privacy Policy' : 'Add Privacy Policy' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($page) ? route('privacy.policy.update', $page->id) : route('privacy.policy.store') }}" 
                          method="POST" 
                          id="privacyPolicyForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="heading" class="form-label">Heading <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('heading') is-invalid @enderror" 
                                           id="heading" 
                                           name="heading" 
                                           value="{{ old('heading', isset($page) ? $page->heading : '') }}"
                                           placeholder="Enter privacy policy heading"
                                           required>
                                    @error('heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="description" class="form-label mb-0">Description <span class="text-danger">*</span></label>
                                        <button type="button" id="toggleEditorBtn" class="btn btn-sm btn-outline-info" onclick="toggleEditor()">Show HTML Source</button>
                                    </div>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="editor" 
                                              name="description" 
                                              rows="15"
                                              placeholder="Enter privacy policy description"
                                              required>{{ old('description', isset($page) ? $page->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            @if(isset($page))
                                <a href="{{ route('privacy.policy') }}" class="btn btn-secondary me-md-2">
                                    Cancel Edit
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Privacy Policy
                                </button>
                            @else
                                <button type="reset" class="btn btn-secondary me-md-2">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Privacy Policy
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Privacy Policy Display -->
            @if($page)
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Current Privacy Policy</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Heading</th>
                                    <th>Description Preview</th>
                                    <th style="width: 150px;">Last Updated</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $page->id }}</td>
                                    <td>{{ $page->heading }}</td>
                                    <td>
                                        <div class="content-preview" style="max-height: 150px; overflow-y: auto;">
                                            {!! Str::limit(strip_tags($page->description), 200) !!}
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-info mt-2" data-bs-toggle="modal" data-bs-target="#previewModal">
                                            <i class="fas fa-eye"></i> View Full Content
                                        </button>
                                    </td>
                                    <td>
                                        <small>{{ $page->updated_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $page->updated_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('privacy.policy') }}" class="btn btn-sm btn-warning mb-1" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('privacy.policy.delete', $page->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this Privacy Policy?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger mb-1" title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Preview Modal -->
            <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="previewModalLabel">{{ $page->heading }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="content-preview" style="line-height: 1.8;">
                                {!! $page->description !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <small class="text-muted me-auto">Last updated: {{ $page->updated_at->format('M d, Y h:i A') }}</small>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">No Privacy Policy found. Add one using the form above!</p>
                </div>
            </div>
            @endif
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
.content-preview {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 4px;
    line-height: 1.6;
}
.content-preview h2 {
    font-size: 20px;
    font-weight: 600;
    margin-top: 20px;
    margin-bottom: 10px;
}
.content-preview h3 {
    font-size: 18px;
    font-weight: 600;
    margin-top: 15px;
    margin-bottom: 8px;
}
.content-preview p {
    margin-bottom: 10px;
}
.content-preview ul, 
.content-preview ol {
    margin-bottom: 10px;
    padding-left: 25px;
}
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    let editorInstance;
    const editorElement = document.querySelector('#editor');
    const toggleBtn = document.getElementById('toggleEditorBtn');
    const form = document.getElementById('privacyPolicyForm');

    function initEditor() {
        ClassicEditor
            .create(editorElement, {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'link', 'blockQuote', '|',
                        'undo', 'redo'
                    ]
                }
            })
            .then(editor => {
                editorInstance = editor;
                toggleBtn.innerText = 'Show HTML Source';
                toggleBtn.classList.remove('btn-outline-success');
                toggleBtn.classList.add('btn-outline-info');
                
                // ✅ CRITICAL: Sync data on every change
                editor.model.document.on('change:data', () => {
                    editorElement.value = editor.getData();
                });
                
                console.log('✅ CKEditor initialized successfully');
            })
            .catch(error => {
                console.error('❌ CKEditor initialization error:', error);
            });
    }

    function toggleEditor() {
        if (editorInstance) {
            editorElement.value = editorInstance.getData();
            
            editorInstance.destroy()
                .then(() => {
                    editorInstance = null;
                    toggleBtn.innerText = 'Enable Rich Editor';
                    toggleBtn.classList.remove('btn-outline-info');
                    toggleBtn.classList.add('btn-outline-success');
                    console.log('✅ Editor destroyed, plain textarea enabled');
                })
                .catch(error => {
                    console.error('❌ Editor destroy error:', error);
                });
        } else {
            initEditor();
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        initEditor();
    });

    // ✅ CRITICAL: Force sync before form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('📝 Form submitting...');
            
            if (editorInstance) {
                const editorData = editorInstance.getData();
                editorElement.value = editorData;
                
                console.log('📄 Editor content length:', editorData.length);
                console.log('📄 Textarea value length:', editorElement.value.length);
                
                // Validate description is not empty
                if (!editorData || editorData.trim() === '' || editorData === '<p>&nbsp;</p>') {
                    e.preventDefault();
                    alert('⚠️ Please enter Privacy Policy description!');
                    console.error('❌ Validation failed: Empty description');
                    return false;
                }
            } else {
                // If editor is destroyed, check textarea directly
                if (!editorElement.value || editorElement.value.trim() === '') {
                    e.preventDefault();
                    alert('⚠️ Please enter Privacy Policy description!');
                    console.error('❌ Validation failed: Empty textarea');
                    return false;
                }
            }
            
            console.log('✅ Form validation passed, submitting...');
            return true;
        });
    } else {
        console.error('❌ Form not found! Check form ID.');
    }
</script>

@endsection