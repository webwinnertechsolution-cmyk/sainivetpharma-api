@extends('backend.layouts.layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Logo Management</h2>
            
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
            <div class="card mb-4 {{ !$canAdd && !isset($editLogo) ? 'opacity-50' : '' }}">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" id="formTitle">
                        {{ isset($editLogo) ? 'Edit Logo' : 'Add New Logo' }}
                        @if(!$canAdd && !isset($editLogo))
                            <span class="badge bg-warning text-dark ms-2">Limit Reached (Max 1 Logo)</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editLogo) ? route('logo.update', $editLogo->id) : route('logo.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <fieldset {{ !$canAdd && !isset($editLogo) ? 'disabled' : '' }}>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">
                                            Logo Image {{ !isset($editLogo) ? '*' : '' }}
                                            <small class="text-muted">(Recommended: PNG/SVG with transparent background)</small>
                                        </label>
                                        <input type="file" 
                                               class="form-control @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*"
                                               {{ !isset($editLogo) ? 'required' : '' }}
                                               onchange="previewImage(event)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        
                                        @if(isset($editLogo) && $editLogo->image)
                                            <div class="mt-3 p-3 border rounded" id="currentImage" style="background-color: #f8f9fa;">
                                                <p class="mb-2 fw-bold">Current Logo:</p>
                                                <img src="{{ asset('uploads/logo/' . $editLogo->image) }}" 
                                                     alt="Current Logo" 
                                                     style="max-width: 300px; max-height: 200px; border: 1px solid #ddd; padding: 10px; background: white;">
                                                <p class="text-muted small mt-2 mb-0">Leave empty to keep current logo</p>
                                            </div>
                                        @endif
                                        
                                        <div class="mt-3 p-3 border rounded" id="imagePreview" style="display: none; background-color: #f8f9fa;">
                                            <p class="mb-2 fw-bold">New Logo Preview:</p>
                                            <img id="preview" src="" alt="Preview" 
                                                 style="max-width: 300px; max-height: 200px; border: 1px solid #ddd; padding: 10px; background: white;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                @if(isset($editLogo))
                                    <a href="{{ route('logo') }}" class="btn btn-secondary me-md-2">
                                        Cancel Edit
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Logo
                                    </button>
                                @else
                                    <button type="reset" class="btn btn-secondary me-md-2" onclick="resetPreview()">
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary" {{ !$canAdd ? 'disabled' : '' }}>
                                        <i class="fas fa-plus"></i> Add Logo
                                    </button>
                                @endif
                            </div>
                        </fieldset>
                        
                        @if(!$canAdd && !isset($editLogo))
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="fas fa-info-circle"></i> Only one logo is allowed. Please delete the existing logo to add a new one.
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Logo List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Current Logo</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Logo Preview</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logos as $logo)
                                <tr>
                                    <td>{{ $logo->id }}</td>
                                    <td>
                                        @if($logo->image)
                                            <div class="p-3" style="background-color: #f8f9fa; display: inline-block;">
                                                <img src="{{ asset('uploads/logo/' . $logo->image) }}" 
                                                     alt="Logo" 
                                                     style="max-width: 200px; max-height: 100px; object-fit: contain;"
                                                     class="img-thumbnail">
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $logo->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $logo->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('logo.edit', $logo->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('logo.delete', $logo->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this logo?');">
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
                                    <td colspan="4" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p class="mb-0">No logo found. Upload your logo above!</p>
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

function resetPreview() {
    const previewDiv = document.getElementById('imagePreview');
    previewDiv.style.display = 'none';
}
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
