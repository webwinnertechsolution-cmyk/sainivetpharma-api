@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Experience The Power</h2>
            
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
            <div class="card mb-4 {{ !$experienceCount < 1 && !isset($editExperience) ? 'opacity-50' : '' }}">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" id="formTitle">
                        {{ isset($editExperience) ? 'Edit Experience The Power' : 'Add New Experience The Power' }}
                        @if($experienceCount >= 1 && !isset($editExperience))
                            <span class="badge bg-warning text-dark ms-2">Limit Reached (Max 1 Item)</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editExperience) ? route('experience.the.power.update', $editExperience->id) : route('experience.the.power.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        
                        <fieldset {{ $experienceCount >= 1 && !isset($editExperience) ? 'disabled' : '' }}>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">
                                            Image {{ !isset($editExperience) ? '*' : '' }}
                                        </label>
                                        <input type="file" 
                                               class="form-control @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*"
                                               {{ !isset($editExperience) ? 'required' : '' }}
                                               onchange="previewImage(event)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        
                                        @if(isset($editExperience) && $editExperience->image)
                                            <div class="mt-2" id="currentImage">
                                                <img src="{{ asset('uploads/experience-the-power/' . $editExperience->image) }}" 
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
                                               value="{{ old('alt_tag', isset($editExperience) ? $editExperience->alt_tag : '') }}"
                                               placeholder="Enter image alt tag">
                                        @error('alt_tag')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="sub_heading" class="form-label">Sub Heading</label>
                                        <input type="text" 
                                               class="form-control @error('sub_heading') is-invalid @enderror" 
                                               id="sub_heading" 
                                               name="sub_heading" 
                                               value="{{ old('sub_heading', isset($editExperience) ? $editExperience->sub_heading : '') }}"
                                               placeholder="Enter sub heading">
                                        @error('sub_heading')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="heading" class="form-label">Heading</label>
                                        <input type="text" 
                                               class="form-control @error('heading') is-invalid @enderror" 
                                               id="heading" 
                                               name="heading" 
                                               value="{{ old('heading', isset($editExperience) ? $editExperience->heading : '') }}"
                                               placeholder="Enter heading">
                                        @error('heading')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="tab" class="form-label">Tab</label>
                                        <input type="text" 
                                               class="form-control @error('tab') is-invalid @enderror" 
                                               id="tab" 
                                               name="tab" 
                                               value="{{ old('tab', isset($editExperience) ? $editExperience->tab : '') }}"
                                               placeholder="Enter tab name">
                                        @error('tab')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="editor" 
                                                  name="description" 
                                                  rows="6"
                                                  placeholder="Enter description">{{ old('description', isset($editExperience) ? $editExperience->description : '') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                @if(isset($editExperience))
                                    <a href="{{ route('experience.the.power') }}" class="btn btn-secondary me-md-2">
                                        Cancel Edit
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Experience
                                    </button>
                                @else
                                    <button type="reset" class="btn btn-secondary me-md-2">
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary" {{ $experienceCount >= 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-plus"></i> Add Experience
                                    </button>
                                @endif
                            </div>
                        </fieldset>
                        
                        @if($experienceCount >= 1 && !isset($editExperience))
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="fas fa-info-circle"></i> Only one experience item is allowed. Please delete the existing item to add a new one.
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Experiences List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Experience The Power</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 120px;">Image</th>
                                    <th>Sub Heading</th>
                                    <th>Heading</th>
                                    <th>Tab</th>
                                    <th>Description</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($experiences as $experience)
                                <tr>
                                    <td>{{ $experience->id }}</td>
                                    <td>
                                        @if($experience->image)
                                            <img src="{{ asset('uploads/experience-the-power/' . $experience->image) }}" 
                                                 alt="{{ $experience->alt_tag ?? 'Experience' }}" 
                                                 style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px;"
                                                 class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($experience->sub_heading, 30) ?: '-' }}</td>
                                    <td>{{ Str::limit($experience->heading, 30) ?: '-' }}</td>
                                    <td>{{ Str::limit($experience->tab, 20) ?: '-' }}</td>
                                    <td>{{ Str::limit(strip_tags($experience->description), 50) ?: '-' }}</td>
                                    <td>
                                        <small>{{ $experience->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $experience->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('experience.the.power.edit', $experience->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('experience.the.power.delete', $experience->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this experience?');">
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
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-images fa-3x mb-3"></i>
                                            <p class="mb-0">No experience found. Add your first experience above!</p>
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

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection
