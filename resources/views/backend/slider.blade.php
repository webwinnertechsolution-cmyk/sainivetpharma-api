@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">
                <i class="fas fa-images me-2"></i> Slider Management
            </h2>

            {{-- ===== SUCCESS / ERROR ALERTS ===== --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ===== ADD / EDIT FORM ===== --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header {{ isset($editSlider) ? 'bg-warning text-dark' : 'bg-primary text-white' }}">
                    <h5 class="mb-0">
                        <i class="fas {{ isset($editSlider) ? 'fa-edit' : 'fa-plus-circle' }} me-2"></i>
                        {{ isset($editSlider) ? 'Edit Slider #' . $editSlider->id : 'Add New Slider' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editSlider) ? route('slider.update', $editSlider->id) : route('slider.store') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        {{-- ===== SLIDE TYPE TOGGLE ===== --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Slide Type <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="slide_type" id="type_image" value="image"
                                            {{ old('slide_type', isset($editSlider) ? $editSlider->slide_type : 'image') === 'image' ? 'checked' : '' }}
                                            onchange="toggleSlideType('image')">
                                        <label class="form-check-label" for="type_image">
                                            <i class="fas fa-image me-1 text-primary"></i> Image
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="slide_type" id="type_video" value="video"
                                            {{ old('slide_type', isset($editSlider) ? $editSlider->slide_type : 'image') === 'video' ? 'checked' : '' }}
                                            onchange="toggleSlideType('video')">
                                        <label class="form-check-label" for="type_video">
                                            <i class="fas fa-video me-1 text-danger"></i> Video
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- ===== LEFT COLUMN ===== --}}
                            <div class="col-md-6">

                                {{-- IMAGE SECTION --}}
                                <div id="image_section" style="{{ old('slide_type', isset($editSlider) ? $editSlider->slide_type : 'image') === 'video' ? 'display:none' : '' }}">
                                    <div class="mb-3">
                                        <label for="image" class="form-label fw-bold">
                                            Image {{ !isset($editSlider) ? '<span class="text-danger">*</span>' : '' }}
                                        </label>
                                        <input type="file"
                                               class="form-control @error('image') is-invalid @enderror"
                                               id="image"
                                               name="image"
                                               accept="image/*"
                                               onchange="previewMedia(event, 'image')">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        {{-- Current image (edit mode) --}}
                                        @if(isset($editSlider) && $editSlider->image && $editSlider->slide_type === 'image')
                                            <div class="mt-2" id="currentImageBox">
                                                <img src="{{ asset('uploads/slider/' . $editSlider->image) }}"
                                                     alt="Current Image"
                                                     style="max-width:200px;max-height:130px;border:2px solid #ddd;border-radius:6px;padding:4px;">
                                                <p class="text-muted small mt-1"><i class="fas fa-info-circle"></i> Current image — leave blank to keep it</p>
                                            </div>
                                        @endif

                                        {{-- New image preview --}}
                                        <div class="mt-2" id="imagePreview" style="display:none;">
                                            <img id="previewImg" src="" alt="Preview"
                                                 style="max-width:200px;max-height:130px;border:2px solid #0d6efd;border-radius:6px;padding:4px;">
                                            <p class="text-muted small mt-1"><i class="fas fa-eye"></i> New image preview</p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alt_tag" class="form-label fw-bold">Image Alt Tag</label>
                                        <input type="text"
                                               class="form-control @error('alt_tag') is-invalid @enderror"
                                               id="alt_tag" name="alt_tag"
                                               value="{{ old('alt_tag', isset($editSlider) ? $editSlider->alt_tag : '') }}"
                                               placeholder="Describe the image for SEO">
                                        @error('alt_tag')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- VIDEO SECTION --}}
                                <div id="video_section" style="{{ old('slide_type', isset($editSlider) ? $editSlider->slide_type : 'image') === 'image' ? 'display:none' : '' }}">
                                    <div class="mb-3">
                                        <label for="video" class="form-label fw-bold">
                                            Video (MP4 / WebM — max 50MB)
                                            @if(!isset($editSlider)) <span class="text-danger">*</span> @endif
                                        </label>
                                        <input type="file"
                                               class="form-control @error('video') is-invalid @enderror"
                                               id="video"
                                               name="video"
                                               accept="video/mp4,video/webm,video/ogg"
                                               onchange="previewMedia(event, 'video')">
                                        @error('video')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        {{-- Current video (edit mode) --}}
                                        @if(isset($editSlider) && $editSlider->video && $editSlider->slide_type === 'video')
                                            <div class="mt-2" id="currentVideoBox">
                                                <video controls style="max-width:280px;border:2px solid #ddd;border-radius:6px;">
                                                    <source src="{{ asset('uploads/slider/videos/' . $editSlider->video) }}" type="video/mp4">
                                                </video>
                                                <p class="text-muted small mt-1"><i class="fas fa-info-circle"></i> Current video — leave blank to keep it</p>
                                            </div>
                                        @endif

                                        {{-- New video preview --}}
                                        <div class="mt-2" id="videoPreview" style="display:none;">
                                            <video id="previewVid" controls style="max-width:280px;border:2px solid #dc3545;border-radius:6px;"></video>
                                            <p class="text-muted small mt-1"><i class="fas fa-eye"></i> New video preview</p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="video_alt_tag" class="form-label fw-bold">Video Alt Tag</label>
                                        <input type="text"
                                               class="form-control @error('video_alt_tag') is-invalid @enderror"
                                               id="video_alt_tag" name="video_alt_tag"
                                               value="{{ old('video_alt_tag', isset($editSlider) ? $editSlider->video_alt_tag : '') }}"
                                               placeholder="Describe the video for accessibility">
                                        @error('video_alt_tag')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- SUB HEADING --}}
                                <div class="mb-3">
                                    <label for="sub_heading" class="form-label fw-bold">Sub Heading</label>
                                    <input type="text"
                                           class="form-control @error('sub_heading') is-invalid @enderror"
                                           id="sub_heading" name="sub_heading"
                                           value="{{ old('sub_heading', isset($editSlider) ? $editSlider->sub_heading : '') }}"
                                           placeholder="e.g. Welcome to our site">
                                    @error('sub_heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- HEADING --}}
                                <div class="mb-3">
                                    <label for="heading" class="form-label fw-bold">Heading</label>
                                    <input type="text"
                                           class="form-control @error('heading') is-invalid @enderror"
                                           id="heading" name="heading"
                                           value="{{ old('heading', isset($editSlider) ? $editSlider->heading : '') }}"
                                           placeholder="Main heading text">
                                    <small class="text-muted">
                                        Use <code>&lt;span style="color:#DA200B"&gt;Word&lt;/span&gt;</code> to colour a word.
                                    </small>
                                    @error('heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            {{-- ===== RIGHT COLUMN ===== --}}
                            <div class="col-md-6">

                                {{-- DESCRIPTION --}}
                                <div class="mb-3">
                                    <label for="editor" class="form-label fw-bold">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="editor" name="description"
                                              rows="5"
                                              placeholder="Enter slide description">{{ old('description', isset($editSlider) ? $editSlider->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- BUTTON TEXT --}}
                                <div class="mb-3">
                                    <label for="button_text" class="form-label fw-bold">Button Text</label>
                                    <input type="text"
                                           class="form-control @error('button_text') is-invalid @enderror"
                                           id="button_text" name="button_text"
                                           value="{{ old('button_text', isset($editSlider) ? $editSlider->button_text : '') }}"
                                           placeholder="e.g. GET A QUOTE">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- BUTTON URL --}}
                                <div class="mb-3">
                                    <label for="button_url" class="form-label fw-bold">Button URL</label>
                                    <input type="text"
                                           class="form-control @error('button_url') is-invalid @enderror"
                                           id="button_url" name="button_url"
                                           value="{{ old('button_url', isset($editSlider) ? $editSlider->button_url : '') }}"
                                           placeholder="https://example.com or /page-name">
                                    @error('button_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        {{-- ===== FORM BUTTONS ===== --}}
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            @if(isset($editSlider))
                                <a href="{{ route('slider') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-warning text-dark fw-bold">
                                    <i class="fas fa-save me-1"></i> Update Slider
                                </button>
                            @else
                                <button type="reset" class="btn btn-secondary" onclick="resetPreviews()">
                                    <i class="fas fa-redo me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary fw-bold">
                                    <i class="fas fa-plus me-1"></i> Add Slider
                                </button>
                            @endif
                        </div>

                    </form>
                </div>
            </div>

            {{-- ===== SLIDER LIST TABLE ===== --}}
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Sliders</h5>
                    <span class="badge bg-secondary">Total: {{ $sliders->count() }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:50px">#</th>
                                    <th style="width:130px">Media</th>
                                    <th style="width:80px">Type</th>
                                    <th>Sub Heading</th>
                                    <th>Heading</th>
                                    <th>Description</th>
                                    <th>Button</th>
                                    <th style="width:120px">Created</th>
                                    <th style="width:140px" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sliders as $slider)
                                <tr>
                                    <td class="fw-bold text-muted">{{ $slider->id }}</td>

                                    {{-- MEDIA PREVIEW --}}
                                    <td>
                                        @if(($slider->slide_type ?? 'image') === 'video' && $slider->video)
                                            <div class="position-relative" style="width:100px;height:60px;background:#000;border-radius:5px;overflow:hidden;">
                                                <video style="width:100%;height:100%;object-fit:cover;" muted preload="metadata">
                                                    <source src="{{ asset('uploads/slider/videos/' . $slider->video) }}" type="video/mp4">
                                                </video>
                                                <span class="position-absolute top-50 start-50 translate-middle"
                                                      style="color:#fff;font-size:18px;pointer-events:none;">
                                                    <i class="fas fa-play-circle"></i>
                                                </span>
                                            </div>
                                        @elseif($slider->image)
                                            <img src="{{ asset('uploads/slider/' . $slider->image) }}"
                                                 alt="{{ $slider->alt_tag ?? 'Slider' }}"
                                                 style="width:100px;height:60px;object-fit:cover;border-radius:5px;"
                                                 class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">No Media</span>
                                        @endif
                                    </td>

                                    {{-- TYPE BADGE --}}
                                    <td>
                                        @if(($slider->slide_type ?? 'image') === 'video')
                                            <span class="badge bg-danger"><i class="fas fa-video me-1"></i>Video</span>
                                        @else
                                            <span class="badge bg-primary"><i class="fas fa-image me-1"></i>Image</span>
                                        @endif
                                    </td>

                                    <td>{{ Str::limit($slider->sub_heading, 25) ?: '<span class="text-muted">—</span>' }}</td>
                                    <td>{!! Str::limit(strip_tags($slider->heading), 30) ?: '<span class="text-muted">—</span>' !!}</td>
                                    <td>{{ Str::limit(strip_tags($slider->description), 45) ?: '—' }}</td>

                                    {{-- BUTTON --}}
                                    <td>
                                        @if($slider->button_text && $slider->button_url)
                                            <a href="{{ $slider->button_url }}" target="_blank"
                                               class="btn btn-sm btn-outline-primary">
                                                {{ Str::limit($slider->button_text, 15) }}
                                                <i class="fas fa-external-link-alt ms-1"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        <small class="d-block">{{ $slider->created_at->format('d M Y') }}</small>
                                        <small class="text-muted">{{ $slider->created_at->format('h:i A') }}</small>
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="text-center">
                                        <a href="{{ route('slider.edit', $slider->id) }}"
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('slider.delete', $slider->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirmDelete(event, '{{ addslashes($slider->heading ?: 'this slider') }}')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger mb-1" title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="fas fa-images fa-3x text-muted mb-3 d-block"></i>
                                        <p class="mb-0 text-muted">No sliders found. Add your first slider above!</p>
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

{{-- ===== DELETE CONFIRM MODAL ===== --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h6 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-1">Are you sure you want to delete</p>
                <strong id="deleteItemName" class="text-danger"></strong>
                <p class="mt-2 text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-1"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ===== SCRIPTS ===== --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    // CKEditor init
    ClassicEditor.create(document.querySelector('#editor')).catch(error => console.error(error));

    // ─── Slide Type Toggle ───────────────────────────────────────────────────
    function toggleSlideType(type) {
        const imgSec = document.getElementById('image_section');
        const vidSec = document.getElementById('video_section');
        if (type === 'image') {
            imgSec.style.display = 'block';
            vidSec.style.display = 'none';
            // clear video input
            document.getElementById('video').value = '';
            document.getElementById('videoPreview').style.display = 'none';
        } else {
            imgSec.style.display = 'none';
            vidSec.style.display = 'block';
            // clear image input
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').style.display = 'none';
        }
    }

    // ─── Media Preview ───────────────────────────────────────────────────────
    function previewMedia(event, type) {
        const file = event.target.files[0];
        if (!file) return;

        if (type === 'image') {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            const url = URL.createObjectURL(file);
            const vid  = document.getElementById('previewVid');
            vid.src = url;
            document.getElementById('videoPreview').style.display = 'block';
        }
    }

    // ─── Reset Previews (on form reset button) ───────────────────────────────
    function resetPreviews() {
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('videoPreview').style.display = 'none';
        // Reset to image type
        document.getElementById('type_image').checked = true;
        toggleSlideType('image');
    }

    // ─── Delete Confirm Modal ────────────────────────────────────────────────
    let pendingDeleteForm = null;

    function confirmDelete(e, name) {
        e.preventDefault();
        pendingDeleteForm = e.target;
        document.getElementById('deleteItemName').textContent = '"' + name + '"';
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
        return false;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (pendingDeleteForm) pendingDeleteForm.submit();
    });

    // ─── Auto-hide alerts after 5s ───────────────────────────────────────────
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            bsAlert.close();
        });
    }, 5000);
</script>

<style>
.table td { vertical-align: middle; }
.card { box-shadow: 0 2px 12px rgba(0,0,0,.08); }
.form-check-input:checked { background-color: #0d6efd; border-color: #0d6efd; }
#image_section, #video_section { 
    background: #f8f9fa; 
    border-radius: 8px; 
    padding: 12px; 
    margin-bottom: 12px;
    border: 1px solid #e9ecef;
}
</style>

@endsection