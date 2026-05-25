@extends('backend.layouts.layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Reverse Engineering Content</h2>
            
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
            <div class="card mb-4 {{ !$canAdd && !isset($editEngineering) ? 'opacity-50' : '' }}">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        {{ isset($editEngineering) ? 'Edit Reverse Engineering Content' : 'Add Reverse Engineering Content' }}
                        @if(!$canAdd && !isset($editEngineering))
                            <span class="badge bg-warning text-dark ms-2">Limit Reached (Max 1 Item)</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editEngineering) ? route('reverseengineering.update', $editEngineering->id) : route('reverseengineering.store') }}" 
                          method="POST">
                        @csrf
                        
                        <fieldset {{ !$canAdd && !isset($editEngineering) ? 'disabled' : '' }}>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="content" class="form-label">
                                            HTML Content *
                                            <small class="text-muted">(You can add unlimited HTML content here)</small>
                                        </label>
                                        <textarea 
                                            class="form-control @error('content') is-invalid @enderror" 
                                            id="content" 
                                            name="content" 
                                            rows="20"
                                            placeholder="Enter your HTML content here... You can include any HTML tags like <div>, <p>, <img>, <h1>, etc."
                                            required>{{ old('content', isset($editEngineering) ? $editEngineering->content : '') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-info-circle"></i> 
                                            You can paste complete HTML code including divs, images, headings, paragraphs, etc.
                                        </small>
                                    </div>
                                </div>

                                <!-- Preview Section -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-eye"></i> Live Preview
                                            <small class="text-muted">(How your content will look)</small>
                                        </label>
                                        <div class="preview-container" id="contentPreview">
                                            @if(isset($editEngineering) && $editEngineering->content)
                                                {!! $editEngineering->content !!}
                                            @else
                                                <p class="text-muted text-center py-5">
                                                    <i class="fas fa-code fa-3x mb-3"></i><br>
                                                    Your HTML content preview will appear here...
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                @if(isset($editEngineering))
                                    <a href="{{ route('reverseengineering') }}" class="btn btn-secondary me-md-2">
                                        <i class="fas fa-times"></i> Cancel Edit
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Content
                                    </button>
                                @else
                                    <button type="reset" class="btn btn-secondary me-md-2" onclick="resetPreview()">
                                        <i class="fas fa-redo"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary" {{ !$canAdd ? 'disabled' : '' }}>
                                        <i class="fas fa-plus"></i> Add Content
                                    </button>
                                @endif
                            </div>
                        </fieldset>
                        
                        @if(!$canAdd && !isset($editEngineering))
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="fas fa-info-circle"></i> Only one reverse engineering content is allowed. Please delete the existing content to add new one.
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Content List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Reverse Engineering Contents</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 40%;">Content Preview</th>
                                    <th style="width: 15%;">Created At</th>
                                    <th style="width: 15%;">Updated At</th>
                                    <th style="width: 180px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($engineerings as $engineering)
                                <tr>
                                    <td class="align-middle text-center">{{ $engineering->id }}</td>
                                    <td class="align-middle">
                                        <div class="code-preview">
                                            <pre>{{ \Illuminate\Support\Str::limit($engineering->content, 200, '...') }}</pre>
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-code"></i> {{ strlen($engineering->content) }} characters
                                        </small>
                                    </td>
                                    <td class="align-middle">
                                        <small>{{ $engineering->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $engineering->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="align-middle">
                                        <small>{{ $engineering->updated_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $engineering->updated_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('reverseengineering.edit', $engineering->id) }}" 
                                           class="btn btn-secondary btn-sm me-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('reverseengineering.delete', $engineering->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this content?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-cogs fa-3x mb-3 d-block"></i>
                                            <p class="mb-0">No reverse engineering content found. Add your first content above!</p>
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
// Live preview of HTML content
document.getElementById('content').addEventListener('input', function(e) {
    updatePreview(e.target.value);
});

function updatePreview(content) {
    const previewDiv = document.getElementById('contentPreview');
    
    if (content.trim() === '') {
        previewDiv.innerHTML = `
            <p class="text-muted text-center py-5">
                <i class="fas fa-code fa-3x mb-3"></i><br>
                Your HTML content preview will appear here...
            </p>
        `;
    } else {
        previewDiv.innerHTML = content;
    }
}

function resetPreview() {
    setTimeout(function() {
        updatePreview('');
    }, 10);
}

// Initialize preview on page load if editing
document.addEventListener('DOMContentLoaded', function() {
    const contentTextarea = document.getElementById('content');
    if (contentTextarea && contentTextarea.value.trim() !== '') {
        updatePreview(contentTextarea.value);
    }
});
</script>

<style>
.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.opacity-50 {
    opacity: 0.6;
    pointer-events: none;
}

#content {
    font-family: 'Courier New', monospace;
    font-size: 13px;
    line-height: 1.5;
}

.preview-container {
    min-height: 400px;
    max-height: 550px;
    overflow-y: auto;
    border: 2px solid #dee2e6;
    border-radius: 4px;
    padding: 15px;
    background: white;
}

.code-preview {
    max-height: 120px;
    overflow-y: auto;
    overflow-x: auto;
    border: 1px solid #ddd;
    padding: 8px;
    border-radius: 4px;
    background: #282c34;
    color: #61dafb;
    font-family: 'Courier New', monospace;
    font-size: 11px;
    line-height: 1.4;
}

.code-preview pre {
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.table td {
    vertical-align: middle;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

form {
    margin: 0;
}

.btn-sm {
    font-size: 11px;
    padding: 4px 8px;
}
.align-middle.text-center .btn {
    width: 82px;
}
</style>

@endsection
