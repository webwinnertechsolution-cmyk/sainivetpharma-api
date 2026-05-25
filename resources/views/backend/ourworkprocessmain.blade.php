@extends('backend.layouts.layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Our Work Process Main</h2>
            
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
            <div class="card mb-4 {{ !$canAdd && !isset($editProcess) ? 'opacity-50' : '' }}">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" id="formTitle">
                        {{ isset($editProcess) ? 'Edit Work Process' : 'Add New Work Process' }}
                        @if(!$canAdd && !isset($editProcess))
                            <span class="badge bg-warning text-dark ms-2">Limit Reached (Max 1 Item)</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editProcess) ? route('ourworkprocessmain.update', $editProcess->id) : route('ourworkprocessmain.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <fieldset {{ !$canAdd && !isset($editProcess) ? 'disabled' : '' }}>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="heading1" class="form-label">Heading *</label>
                                        <input type="text" 
                                               class="form-control @error('heading1') is-invalid @enderror" 
                                               id="heading1" 
                                               name="heading1" 
                                               value="{{ old('heading1', isset($editProcess) ? $editProcess->heading1 : '') }}"
                                               placeholder="Enter work process heading"
                                               required>
                                        @error('heading1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image1" class="form-label">
                                            Image {{ !isset($editProcess) ? '*' : '' }}
                                        </label>
                                        <input type="file" 
                                               class="form-control @error('image1') is-invalid @enderror" 
                                               id="image1" 
                                               name="image1" 
                                               accept="image/*"
                                               {{ !isset($editProcess) ? 'required' : '' }}
                                               onchange="previewImage(event)">
                                        @error('image1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        
                                        @if(isset($editProcess) && $editProcess->image1)
                                            <div class="mt-2" id="currentImage">
                                                <img src="{{ asset('uploads/workprocess/' . $editProcess->image1) }}" 
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
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="button_text" class="form-label">Button Text *</label>
                                        <input type="text" 
                                               class="form-control @error('button_text') is-invalid @enderror" 
                                               id="button_text" 
                                               name="button_text" 
                                               value="{{ old('button_text', isset($editProcess) ? $editProcess->button_text : '') }}"
                                               placeholder="e.g., Learn More, View Details, Get Started"
                                               maxlength="100"
                                               required>
                                        @error('button_text')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Max 100 characters</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="button_url" class="form-label">Button URL *</label>
                                        <input type="url" 
                                               class="form-control @error('button_url') is-invalid @enderror" 
                                               id="button_url" 
                                               name="button_url" 
                                               value="{{ old('button_url', isset($editProcess) ? $editProcess->button_url : '') }}"
                                               placeholder="https://example.com/page"
                                               maxlength="500"
                                               required>
                                        @error('button_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Must be a valid URL (e.g., https://example.com)</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Button Preview -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <strong><i class="fas fa-eye"></i> Button Preview:</strong>
                                        <div class="mt-2">
                                            <a href="#" 
                                               class="btn btn-primary" 
                                               id="buttonPreview"
                                               onclick="return false;">
                                                {{ old('button_text', isset($editProcess) ? $editProcess->button_text : 'Button Text') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                @if(isset($editProcess))
                                    <a href="{{ route('ourworkprocessmain') }}" class="btn btn-secondary me-md-2">
                                        Cancel Edit
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Work Process
                                    </button>
                                @else
                                    <button type="reset" class="btn btn-secondary me-md-2">
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary" {{ !$canAdd ? 'disabled' : '' }}>
                                        <i class="fas fa-plus"></i> Add Work Process
                                    </button>
                                @endif
                            </div>
                        </fieldset>
                        
                        @if(!$canAdd && !isset($editProcess))
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="fas fa-info-circle"></i> Only one work process item is allowed. Please delete the existing item to add a new one.
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Work Processes List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Work Processes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 150px;">Image</th>
                                    <th>Heading</th>
                                    <th style="width: 150px;">Button</th>
                                    <th style="width: 200px;">URL</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($processes as $process)
                                <tr>
                                    <td>{{ $process->id }}</td>
                                    <td>
                                        @if($process->image1)
                                            <img src="{{ asset('uploads/workprocess/' . $process->image1) }}" 
                                                 alt="{{ $process->heading1 }}" 
                                                 style="width: 120px; height: 80px; object-fit: cover; border-radius: 5px;"
                                                 class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $process->heading1 ?: '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $process->button_text ?: '-' }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ $process->button_url }}" 
                                           target="_blank" 
                                           class="text-truncate d-inline-block" 
                                           style="max-width: 180px;"
                                           title="{{ $process->button_url }}">
                                            {{ $process->button_url }}
                                        </a>
                                    </td>
                                    <td>
                                        <small>{{ $process->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $process->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('ourworkprocessmain.edit', $process->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('ourworkprocessmain.delete', $process->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this work process?');">
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
                                            <i class="fas fa-tasks fa-3x mb-3"></i>
                                            <p class="mb-0">No work processes found. Add your first work process above!</p>
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

// Live button preview
document.getElementById('button_text').addEventListener('input', function(e) {
    document.getElementById('buttonPreview').textContent = e.target.value || 'Button Text';
});
</script>

<style>
.table td {
    vertical-align: middle;
}
.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.opacity-50 {
    opacity: 0.6;
    pointer-events: none;
}
</style>

@endsection
