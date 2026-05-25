@extends('backend.layouts.layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Home Contact Section</h2>
            
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
            <div class="card mb-4 {{ !$canAdd && !isset($editHomeContact) ? 'opacity-50' : '' }}">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        {{ isset($editHomeContact) ? 'Edit Home Contact' : 'Add Home Contact' }}
                        @if(!$canAdd && !isset($editHomeContact))
                            <span class="badge bg-warning text-dark ms-2">Limit Reached (Max 1 Item)</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editHomeContact) ? route('homecontact.update', $editHomeContact->id) : route('homecontact.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <fieldset {{ !$canAdd && !isset($editHomeContact) ? 'disabled' : '' }}>
                            <div class="row">
                                <!-- Heading -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="heading" class="form-label">Heading *</label>
                                        <input type="text" 
                                               class="form-control @error('heading') is-invalid @enderror" 
                                               id="heading" 
                                               name="heading" 
                                               value="{{ old('heading', isset($editHomeContact) ? $editHomeContact->heading : '') }}"
                                               placeholder="Enter heading"
                                               required>
                                        @error('heading')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Image -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">
                                            Image {{ !isset($editHomeContact) ? '*' : '' }}
                                        </label>
                                        <input type="file" 
                                               class="form-control @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*"
                                               {{ !isset($editHomeContact) ? 'required' : '' }}
                                               onchange="previewImage(event)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        
                                        @if(isset($editHomeContact) && $editHomeContact->image)
                                            <div class="mt-2" id="currentImage">
                                                <img src="{{ asset('uploads/homecontact/' . $editHomeContact->image) }}" 
                                                     alt="Current Image" 
                                                     style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                                                <p class="text-muted small mt-1">Current Image (Leave empty to keep this)</p>
                                            </div>
                                        @endif
                                        
                                        <div class="mt-2" id="imagePreview" style="display: none;">
                                            <img id="preview" src="" alt="Preview" 
                                                 style="max-width: 200px; max-height: 150px; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                                            <p class="text-muted small mt-1">New Image Preview</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Phone and Email Row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" 
                                               name="phone" 
                                               value="{{ old('phone', isset($editHomeContact) ? $editHomeContact->phone : '') }}"
                                               placeholder="e.g., +61-423 454 930">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', isset($editHomeContact) ? $editHomeContact->email : '') }}"
                                               placeholder="e.g., contact@example.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Description Textarea -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description *</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" 
                                                  name="description" 
                                                  rows="5" 
                                                  placeholder="Enter description"
                                                  required>{{ old('description', isset($editHomeContact) ? $editHomeContact->description : '') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                @if(isset($editHomeContact))
                                    <a href="{{ route('homecontact') }}" class="btn btn-secondary me-md-2">
                                        Cancel Edit
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                @else
                                    <button type="reset" class="btn btn-secondary me-md-2">
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary" {{ !$canAdd ? 'disabled' : '' }}>
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                @endif
                            </div>
                        </fieldset>
                        
                        @if(!$canAdd && !isset($editHomeContact))
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="fas fa-info-circle"></i> Only one item is allowed. Please delete the existing item to add a new one.
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Home Contact Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 150px;">Image</th>
                                    <th style="width: 200px;">Heading</th>
                                    <th>Description</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($homeContacts as $homeContact)
                                <tr>
                                    <td>{{ $homeContact->id }}</td>
                                    <td>
                                        @if($homeContact->image)
                                            <img src="{{ asset('uploads/homecontact/' . $homeContact->image) }}" 
                                                 alt="{{ $homeContact->heading }}" 
                                                 style="width: 120px; height: 80px; object-fit: cover; border-radius: 5px;"
                                                 class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $homeContact->heading ?: '-' }}</td>
                                    <td>
                                        <div style="max-height: 80px; overflow-y: auto;">
                                            {{ Str::limit($homeContact->description, 150) }}
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $homeContact->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $homeContact->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('homecontact.edit', $homeContact->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('homecontact.delete', $homeContact->id) }}" 
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
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p class="mb-0">No items found. Add your first item above!</p>
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
.opacity-50 {
    opacity: 0.6;
    pointer-events: none;
}
</style>

@endsection
