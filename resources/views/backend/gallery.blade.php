@extends('backend.layouts.layout')
@section('title', 'Gallery Management')
@section('content')

<div class="container-fluid">
<div class="row">
<div class="col-12">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">🖼️ Gallery Management</h2>
        <span class="badge bg-info">Total: {{ $galleries->count() }}</span>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            ❌ {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>❌ Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">

        {{-- ════ LEFT: CREATE / EDIT FORM ════ --}}
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header {{ isset($gallery) ? 'bg-warning' : 'bg-success' }} text-white">
                    <h5 class="mb-0">
                        {{ isset($gallery) ? '✏️ Edit Gallery' : '➕ Create New Gallery' }}
                    </h5>
                </div>
                <div class="card-body">

                    @if(isset($gallery))
                        <form action="{{ route('gallery.update', $gallery->id) }}" method="POST"
                              enctype="multipart/form-data" id="galleryForm">
                    @else
                        <form action="{{ route('gallery.store') }}" method="POST"
                              enctype="multipart/form-data" id="galleryForm">
                    @endif
                    @csrf

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gallery Title *</label>
                        <input type="text" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               required value="{{ old('title', $gallery->title ?? '') }}"
                               placeholder="e.g. Summer Collection 2025">
                        @error('title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    {{-- Slug --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slug (URL Friendly)</label>
                        <input type="text" name="slug"
                               class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $gallery->slug ?? '') }}"
                               placeholder="summer-collection-2025">
                        <small class="text-muted">Leave blank to auto-generate</small>
                        @error('slug')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="2"
                                  placeholder="Optional...">{{ old('description', $gallery->description ?? '') }}</textarea>
                    </div>

                    {{-- Active --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                               value="1" {{ old('is_active', $gallery->is_active ?? 1) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_active">✅ Active</label>
                    </div>

                    {{-- ════ MEDIA TYPE SELECTOR ════ --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">📁 Media Type</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="media_type"
                                       id="type_image" value="image" checked>
                                <label class="form-check-label" for="type_image">
                                    📸 Images
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="media_type"
                                       id="type_video" value="video">
                                <label class="form-check-label" for="type_video">
                                    🎬 Videos
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- ════ IMAGE UPLOAD SECTION ════ --}}
                    <div id="imageSection" class="mb-3">
                        <label class="form-label fw-bold">🖼️ Upload Images</label>
                        <input type="file" name="images[]" id="imageInput"
                               class="form-control" multiple accept="image/*">
                        <small class="text-muted">Multiple images allowed (JPG, PNG, GIF, WEBP — max 5MB each)</small>

                        {{-- Image Preview --}}
                        <div id="imagePreviewContainer" class="row mt-2 g-2"></div>

                        {{-- Dynamic alt/title fields --}}
                        <div id="imageMetaContainer"></div>
                    </div>

                    {{-- ════ VIDEO UPLOAD SECTION ════ --}}
                    <div id="videoSection" class="mb-3" style="display:none;">
                        <label class="form-label fw-bold">🎬 Upload Videos</label>
                        <input type="file" name="videos[]" id="videoInput"
                               class="form-control" multiple accept="video/mp4,video/webm,video/ogg,.mov,.avi">
                        <small class="text-muted">Multiple videos allowed (MP4, WebM — max 100MB each)</small>

                        {{-- Video Preview --}}
                        <div id="videoPreviewContainer" class="mt-2"></div>

                        {{-- Dynamic title fields --}}
                        <div id="videoMetaContainer"></div>

                        <div class="mt-2">
                            <label class="form-label fw-bold">🖼️ Video Thumbnails (Optional)</label>
                            <input type="file" name="video_thumbnails[]" id="videoThumbnailInput"
                                   class="form-control" multiple accept="image/*">
                            <small class="text-muted">One thumbnail per video (same order)</small>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2">
                        <button type="submit"
                                class="btn {{ isset($gallery) ? 'btn-warning' : 'btn-success' }} flex-grow-1">
                            {{ isset($gallery) ? '💾 Update Gallery' : '➕ Create Gallery' }}
                        </button>
                        @if(isset($gallery))
                            <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Cancel</a>
                        @endif
                    </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- ════ RIGHT: GALLERIES LIST ════ --}}
        <div class="col-lg-7">

            <div class="alert alert-info d-flex align-items-start gap-3 mb-4">
                <span style="font-size:22px;">💡</span>
                <div>
                    <strong>📝 Shortcode Usage:</strong><br>
                    <code style="background:#fff;padding:5px 10px;border-radius:6px;font-size:12px;display:inline-block;margin-top:5px;">
                        @{{ shortcode('gallery', ID) }}
                    </code>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">📂 All Galleries ({{ $galleries->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    @if($galleries->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Title</th>
                                        <th width="120">Media</th>
                                        <th width="100">Status</th>
                                        <th width="180">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($galleries as $gal)
                                    <tr>
                                        <td class="align-middle">
                                            <span class="badge bg-secondary">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="fw-bold">{{ $gal->title }}</div>
                                            @if($gal->description)
                                                <small class="text-muted">{{ Str::limit($gal->description, 50) }}</small>
                                            @endif
                                            <div class="mt-1">
                                                <code style="font-size:11px;background:#f0f4f8;padding:2px 7px;border-radius:4px;">
                                                    {{ '{' . '{' . 'shortcode(\'gallery\', ' . $gal->id . ')' . '}' . '}' }}
                                                </code>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge bg-info">🖼️ {{ $gal->images()->count() }}</span><br>
                                            <span class="badge bg-warning">🎬 {{ $gal->videos()->count() }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if($gal->is_active)
                                                <span class="badge bg-success">✅ Active</span>
                                            @else
                                                <span class="badge bg-secondary">❌ Inactive</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('gallery.edit', $gal->id) }}"
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('gallery.delete', $gal->id) }}" method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('⚠️ Delete gallery & all media?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-5 text-center text-muted">
                            <p class="fs-5 mb-3">📭 No galleries yet.</p>
                            <p>Create your first gallery using the form on the left!</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- ════ BOTTOM: EDIT MODE — EXISTING MEDIA ════ --}}
    @if(isset($gallery))
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">📁 Existing Media ({{ $gallery->media()->count() }})</h5>
                        <small>Drag to reorder</small>
                    </div>
                    <div class="card-body">

                        @if($gallery->media()->count() > 0)
                            <div id="mediaList" class="row">
                                @foreach($gallery->media()->orderBy('sort_order')->get() as $media)
                                    <div class="col-md-6 col-lg-4 mb-4"
                                         data-media-id="{{ $media->id }}"
                                         style="cursor:move;">
                                        <div class="card h-100 position-relative shadow-sm">

                                            {{-- Preview --}}
                                            <div class="position-relative overflow-hidden"
                                                 style="height:200px;background:#f0f0f0;">
                                                @if($media->isImage())
                                                    <img src="{{ $media->file_url }}"
                                                         alt="{{ $media->alt_tag }}"
                                                         class="w-100 h-100"
                                                         style="object-fit:cover;">
                                                    <span class="badge bg-primary position-absolute top-2 start-2">📸 Image</span>
                                                @else
                                                    <video class="w-100 h-100" style="object-fit:cover;">
                                                        <source src="{{ $media->file_url }}">
                                                    </video>
                                                    <span class="badge bg-success position-absolute top-2 start-2">🎬 Video</span>
                                                @endif
                                            </div>

                                            {{-- Info --}}
                                            <div class="card-body">
                                                <p class="mb-1">
                                                    <small class="text-muted">Title:</small><br>
                                                    <strong class="title-text">{{ $media->title }}</strong>
                                                </p>
                                                <p class="mb-2">
                                                    <small class="text-muted">Alt Tag:</small><br>
                                                    <strong class="alt-text">{{ $media->alt_tag }}</strong>
                                                </p>
                                                <p class="mb-3">
                                                    <small class="text-muted">📁 {{ Str::limit($media->file_name, 30) }}</small>
                                                </p>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-sm btn-warning edit-btn"
                                                            data-media-id="{{ $media->id }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                            data-media-id="{{ $media->id }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Sort badge --}}
                                            <div class="position-absolute top-2 end-2">
                                                <span class="badge bg-secondary">#{{ $loop->iteration }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                No media yet. Use the form on the left to add images or videos.
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
</div>
</div>

{{-- ════ EDIT MEDIA MODAL ════ --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">✏️ Edit Media Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" id="editTitle" class="form-control" placeholder="Media title...">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Alt Tag</label>
                    <input type="text" id="editAltTag" class="form-control" placeholder="Alt text...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveEditBtn">💾 Save</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ════════════════════════════════════════
    // MEDIA TYPE TOGGLE (Image / Video)
    // ════════════════════════════════════════
    const radios = document.querySelectorAll('input[name="media_type"]');
    const imageSection = document.getElementById('imageSection');
    const videoSection = document.getElementById('videoSection');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'image') {
                imageSection.style.display = 'block';
                videoSection.style.display = 'none';
                // Clear video input
                selectedVideoFiles = [];
                document.getElementById('videoInput').value = '';
                document.getElementById('videoPreviewContainer').innerHTML = '';
                document.getElementById('videoMetaContainer').innerHTML = '';
            } else {
                imageSection.style.display = 'none';
                videoSection.style.display = 'block';
                // Clear image input
                selectedImageFiles = [];
                document.getElementById('imageInput').value = '';
                document.getElementById('imagePreviewContainer').innerHTML = '';
                document.getElementById('imageMetaContainer').innerHTML = '';
            }
        });
    });

    // ════════════════════════════════════════
    // IMAGE PREVIEW + META FIELDS + REMOVE
    // ════════════════════════════════════════
    let selectedImageFiles = []; // Track selected files array

    document.getElementById('imageInput').addEventListener('change', function () {
        // Nayi files existing mein add karo
        Array.from(this.files).forEach(file => {
            // Duplicate check (same name + size)
            const exists = selectedImageFiles.some(f => f.name === file.name && f.size === file.size);
            if (!exists) selectedImageFiles.push(file);
        });
        renderImagePreviews();
    });

    function renderImagePreviews() {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const metaContainer   = document.getElementById('imageMetaContainer');
        previewContainer.innerHTML = '';
        metaContainer.innerHTML   = '';

        selectedImageFiles.forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Preview card with cross button
                const col = document.createElement('div');
                col.className = 'col-4';
                col.dataset.index = i;
                col.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-thumbnail w-100"
                             style="height:80px;object-fit:cover;">
                        <button type="button"
                                class="btn btn-danger btn-sm position-absolute remove-image-btn"
                                data-index="${i}"
                                style="top:2px;right:2px;padding:1px 6px;font-size:11px;line-height:1.4;">
                            ✕
                        </button>
                        <small class="d-block text-truncate text-muted" style="font-size:10px;">${file.name}</small>
                    </div>`;
                previewContainer.appendChild(col);

                // Meta fields
                const meta = document.createElement('div');
                meta.className = 'border rounded p-2 mb-2 mt-2';
                meta.dataset.index = i;
                meta.innerHTML = `
                    <small class="fw-bold text-muted">Image ${i + 1}: ${file.name}</small>
                    <input type="text" name="image_titles[]" class="form-control form-control-sm mt-1"
                           placeholder="Title (optional)">
                    <input type="text" name="image_alts[]" class="form-control form-control-sm mt-1"
                           placeholder="Alt tag (optional)">`;
                metaContainer.appendChild(meta);

                // Remove button click
                col.querySelector('.remove-image-btn').addEventListener('click', function () {
                    const idx = parseInt(this.dataset.index);
                    selectedImageFiles.splice(idx, 1);
                    rebuildImageInput();
                    renderImagePreviews();
                });
            };
            reader.readAsDataURL(file);
        });
    }

    function rebuildImageInput() {
        // Native file input ko DataTransfer se rebuild karo
        const dt = new DataTransfer();
        selectedImageFiles.forEach(f => dt.items.add(f));
        document.getElementById('imageInput').files = dt.files;
    }

    // ════════════════════════════════════════
    // VIDEO PREVIEW + META FIELDS + REMOVE
    // ════════════════════════════════════════
    let selectedVideoFiles = [];

    document.getElementById('videoInput').addEventListener('change', function () {
        Array.from(this.files).forEach(file => {
            const exists = selectedVideoFiles.some(f => f.name === file.name && f.size === file.size);
            if (!exists) selectedVideoFiles.push(file);
        });
        renderVideoPreviews();
    });

    function renderVideoPreviews() {
        const previewContainer = document.getElementById('videoPreviewContainer');
        const metaContainer   = document.getElementById('videoMetaContainer');
        previewContainer.innerHTML = '';
        metaContainer.innerHTML   = '';

        selectedVideoFiles.forEach((file, i) => {
            // Preview card with cross button
            const div = document.createElement('div');
            div.className = 'mb-2';
            div.dataset.index = i;
            div.innerHTML = `
                <div class="d-flex align-items-center justify-content-between gap-2 p-2 bg-light rounded position-relative">
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size:24px;">🎬</span>
                        <div>
                            <div class="fw-bold" style="font-size:13px;">${file.name}</div>
                            <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                        </div>
                    </div>
                    <button type="button"
                            class="btn btn-danger btn-sm remove-video-btn"
                            data-index="${i}"
                            style="padding:2px 8px;font-size:12px;line-height:1.4;flex-shrink:0;">
                        ✕
                    </button>
                </div>`;
            previewContainer.appendChild(div);

            // Meta fields
            const meta = document.createElement('div');
            meta.className = 'border rounded p-2 mb-2';
            meta.dataset.index = i;
            meta.innerHTML = `
                <small class="fw-bold text-muted">Video ${i + 1}: ${file.name}</small>
                <input type="text" name="video_titles[]" class="form-control form-control-sm mt-1"
                       placeholder="Video title (optional)">`;
            metaContainer.appendChild(meta);

            // Remove button click
            div.querySelector('.remove-video-btn').addEventListener('click', function () {
                const idx = parseInt(this.dataset.index);
                selectedVideoFiles.splice(idx, 1);
                rebuildVideoInput();
                renderVideoPreviews();
            });
        });
    }

    function rebuildVideoInput() {
        const dt = new DataTransfer();
        selectedVideoFiles.forEach(f => dt.items.add(f));
        document.getElementById('videoInput').files = dt.files;
    }

    // ════════════════════════════════════════
    // DRAG & DROP SORT (existing media)
    // ════════════════════════════════════════
    const mediaList = document.getElementById('mediaList');
    if (mediaList && mediaList.children.length > 0) {
        Sortable.create(mediaList, {
            animation: 150,
            ghostClass: 'opacity-50',
            onEnd: function () {
                const order = Array.from(mediaList.children).map(el => el.dataset.mediaId);
                fetch('{{ route("gallery.media.sort") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                }).then(() => {
                    Array.from(mediaList.children).forEach((el, idx) => {
                        el.querySelector('.bg-secondary').textContent = '#' + (idx + 1);
                    });
                });
            }
        });
    }

    // ════════════════════════════════════════
    // EDIT MEDIA (modal)
    // ════════════════════════════════════════
    let currentMediaId = null;

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            currentMediaId = this.dataset.mediaId;
            const card = this.closest('[data-media-id]');
            document.getElementById('editTitle').value  = card.querySelector('.title-text').textContent.trim();
            document.getElementById('editAltTag').value = card.querySelector('.alt-text').textContent.trim();
            new bootstrap.Modal(document.getElementById('editModal')).show();
        });
    });

    document.getElementById('saveEditBtn').addEventListener('click', function () {
        const title  = document.getElementById('editTitle').value;
        const altTag = document.getElementById('editAltTag').value;

        fetch(`/gallery/media/info/${currentMediaId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ title: title, alt_tag: altTag })
        }).then(res => res.json()).then(data => {
            if (data.success) {
                const card = document.querySelector(`[data-media-id="${currentMediaId}"]`);
                card.querySelector('.title-text').textContent = title;
                card.querySelector('.alt-text').textContent   = altTag;
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
            }
        });
    });

    // ════════════════════════════════════════
    // DELETE MEDIA
    // ════════════════════════════════════════
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            if (!confirm('⚠️ Delete this media? Cannot be undone.')) return;
            const mediaId = this.dataset.mediaId;

            fetch(`/gallery/media/delete/${mediaId}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    document.querySelector(`[data-media-id="${mediaId}"]`).remove();
                    location.reload();
                }
            });
        });
    });

});
</script>

<style>
.card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.15) !important; }
.opacity-50 { opacity: .5; }
</style>

@endsection
