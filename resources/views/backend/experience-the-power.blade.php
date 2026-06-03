@extends('backend.layouts.layout')
@section('title', 'Experience The Power')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; padding: 0; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 10px; color: #6b7280; font-weight: 500; }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7; color: #065f46;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 11px;
    }
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 11px;
    }
    .alert-warning-custom {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 1px solid #fbbf24; color: #78350f;
        padding: 8px 12px; border-radius: 6px; margin-top: 10px;
        font-size: 11px; font-weight: 500;
    }

    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }
    .page-card.disabled-card { opacity: 0.6; pointer-events: none; }

    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-warning {
        background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-dark {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    }
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 10px; background: rgba(255,255,255,0.2); color: #fff; padding: 2px 10px; border-radius: 20px; font-weight: 700; }

    .badge-limit { background: rgba(251,191,36,0.25); color: #fbbf24; font-size: 10px; padding: 2px 8px; border-radius: 20px; font-weight: 700; border: 1px solid rgba(251,191,36,0.4); }

    .card-body { padding: 16px; }

    .sub-card { border: 1.5px solid #e5e7eb; border-radius: 8px; margin-bottom: 12px; overflow: hidden; }
    .sub-card.image-s  { border-left: 4px solid #1872B5; }
    .sub-card.content-s { border-left: 4px solid #8b5cf6; }

    .sub-card-header {
        background: #f9fafb; padding: 8px 12px;
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
        color: #0a214f; display: flex; align-items: center; gap: 6px;
        border-bottom: 1px solid #e5e7eb;
    }
    .sub-card-body { padding: 12px; }

    .form-label {
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
        color: #0a214f; margin-bottom: 5px; display: block;
    }
    .form-control, .form-select {
        border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 6px 10px; font-size: 11px; font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease; width: 100%;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1872B5; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); outline: none;
    }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 10px; margin-top: 3px; display: block; }
    .form-group { margin-bottom: 10px; }
    .form-text { font-size: 10px; color: #6b7280; margin-top: 3px; display: block; }

    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }
    .text-danger { color: #ef4444; }

    .btn {
        padding: 6px 13px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 10px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
    .btn-success { background: linear-gradient(135deg, #059669, #34d399); color: white; box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
    .btn-success:hover { transform: translateY(-1px); color: white; }
    .btn-warning { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-danger { background: linear-gradient(135deg, #ef4444, #f87171); color: white; font-weight: 700; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-sm { padding: 4px 8px; font-size: 10px; }
    .btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none !important; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    /* Image Preview */
    .img-preview-box {
        margin-top: 8px; padding: 6px; border: 1.5px dashed #d1d5db;
        border-radius: 6px; background: #f9fafb; display: none;
    }
    .img-preview-box img { max-width: 100%; max-height: 120px; border-radius: 4px; display: block; }
    .img-preview-box p { font-size: 10px; color: #6b7280; margin: 4px 0 0; }
    .img-current-box {
        margin-top: 8px; padding: 6px; border: 1.5px solid #e5e7eb;
        border-radius: 6px; background: #f0f4f8;
    }
    .img-current-box img { max-width: 100%; max-height: 120px; border-radius: 4px; display: block; }
    .img-current-box p { font-size: 10px; color: #6b7280; margin: 4px 0 0; }

    /* Table */
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 11px; }
    thead tr { background: #f9fafb; }
    thead th {
        padding: 9px 12px; font-family: 'Sora', sans-serif; font-weight: 700;
        color: #0a214f; font-size: 10px; border-bottom: 2px solid #e5e7eb; white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody td { padding: 9px 12px; color: #374151; vertical-align: middle; font-size: 11px; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 7px; border-radius: 20px; font-size: 10px;
        font-family: 'Sora', sans-serif; font-weight: 700;
    }
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-secondary { background: #f3f4f6; color: #6b7280; }
    .badge-id { background: #e0e7ff; color: #3730a3; font-size: 10px; padding: 3px 8px; }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 32px; display: block; margin-bottom: 10px; opacity: 0.35; }
    .empty-state p { font-size: 11px; margin: 0; }

    .thumb { width: 80px; height: 50px; object-fit: cover; border-radius: 5px; border: 1px solid #e5e7eb; }

    /* Delete Modal */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .modal-overlay.show { display: flex; }

    @media (max-width: 768px) {
        .two-col { grid-template-columns: 1fr; }
        .btn-group-custom { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">⚡ Experience The Power</h1>
        <p class="page-subtitle">Homepage par Experience section manage karein (Max: 1 item)</p>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert-success">
            <span>✅ {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-danger">
            <span>⚠️ {{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- FORM CARD --}}
    <div class="page-card {{ $experienceCount >= 1 && !isset($editExperience) ? 'disabled-card' : '' }}">
        <div class="{{ isset($editExperience) ? 'card-header-warning' : 'card-header-gradient' }}">
            <h2 class="card-header-title">
                @if(isset($editExperience))
                    <i class="fas fa-pen"></i> Edit Experience The Power
                @else
                    <i class="fas fa-plus-circle"></i> Add Experience The Power
                @endif
                @if($experienceCount >= 1 && !isset($editExperience))
                    <span class="badge-limit">⚠ Limit Reached (Max 1)</span>
                @endif
            </h2>
        </div>
        <div class="card-body">
            <form action="{{ isset($editExperience) ? route('experience.the.power.update', $editExperience->id) : route('experience.the.power.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                <fieldset {{ $experienceCount >= 1 && !isset($editExperience) ? 'disabled' : '' }}>

                    {{-- Image Section --}}
                    <div class="sub-card image-s">
                        <div class="sub-card-header">
                            <i class="fas fa-image"></i> Image
                        </div>
                        <div class="sub-card-body">
                            <div class="two-col">
                                <div class="form-group">
                                    <label class="form-label">
                                        Image {{ !isset($editExperience) ? '<span class="text-danger">*</span>' : '' }}
                                    </label>
                                    <input type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           id="image" name="image" accept="image/*"
                                           {{ !isset($editExperience) ? 'required' : '' }}
                                           onchange="previewImage(event)">
                                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                                    @if(isset($editExperience) && $editExperience->image)
                                        <div class="img-current-box">
                                            <img src="{{ asset('uploads/experience-the-power/' . $editExperience->image) }}" alt="Current">
                                            <p>Current Image (khali chhodo rakhe ke liye)</p>
                                        </div>
                                    @endif
                                    <div class="img-preview-box" id="imagePreview">
                                        <img id="preview" src="" alt="Preview">
                                        <p>New Image Preview</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Image Alt Tag</label>
                                    <input type="text"
                                           class="form-control @error('alt_tag') is-invalid @enderror"
                                           id="alt_tag" name="alt_tag"
                                           value="{{ old('alt_tag', isset($editExperience) ? $editExperience->alt_tag : '') }}"
                                           placeholder="e.g., Experience the power banner">
                                    @error('alt_tag')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Content Section --}}
                    <div class="sub-card content-s">
                        <div class="sub-card-header">
                            <i class="fas fa-heading"></i> Content
                        </div>
                        <div class="sub-card-body">
                            <div class="two-col">
                                <div>
                                    <div class="form-group">
                                        <label class="form-label">Sub Heading</label>
                                        <input type="text"
                                               class="form-control @error('sub_heading') is-invalid @enderror"
                                               id="sub_heading" name="sub_heading"
                                               value="{{ old('sub_heading', isset($editExperience) ? $editExperience->sub_heading : '') }}"
                                               placeholder="e.g., Why Choose Us">
                                        @error('sub_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Heading</label>
                                        <input type="text"
                                               class="form-control @error('heading') is-invalid @enderror"
                                               id="heading" name="heading"
                                               value="{{ old('heading', isset($editExperience) ? $editExperience->heading : '') }}"
                                               placeholder="e.g., Experience The Power">
                                        @error('heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Tab</label>
                                        <input type="text"
                                               class="form-control @error('tab') is-invalid @enderror"
                                               id="tab" name="tab"
                                               value="{{ old('tab', isset($editExperience) ? $editExperience->tab : '') }}"
                                               placeholder="e.g., Overview">
                                        @error('tab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="editor" name="description" rows="7"
                                              placeholder="Enter description...">{{ old('description', isset($editExperience) ? $editExperience->description : '') }}</textarea>
                                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Buttons --}}
                    <div class="btn-group-custom">
                        @if(isset($editExperience))
                            <a href="{{ route('experience.the.power') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Experience
                            </button>
                        @else
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary" {{ $experienceCount >= 1 ? 'disabled' : '' }}>
                                <i class="fas fa-plus"></i> Add Experience
                            </button>
                        @endif
                    </div>

                </fieldset>

                @if($experienceCount >= 1 && !isset($editExperience))
                    <div class="alert-warning-custom">
                        <i class="fas fa-info-circle"></i> Sirf ek experience item allowed hai. Naya add karne ke liye pehle existing delete karein.
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="page-card">
        <div class="card-header-dark">
            <div class="card-header-row">
                <h2 class="card-header-title"><i class="fas fa-list"></i> All Experience The Power</h2>
                <span class="table-count">Total: {{ $experiences->count() }}</span>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:50px;">ID</th>
                            <th style="width:100px;">Image</th>
                            <th>Sub Heading</th>
                            <th>Heading</th>
                            <th>Tab</th>
                            <th>Description</th>
                            <th style="width:100px;">Created</th>
                            <th style="width:110px; text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($experiences as $experience)
                        <tr>
                            <td style="text-align:center;">
                                <span class="badge badge-id">#{{ $experience->id }}</span>
                            </td>
                            <td>
                                @if($experience->image)
                                    <img src="{{ asset('uploads/experience-the-power/' . $experience->image) }}"
                                         alt="{{ $experience->alt_tag ?? 'Experience' }}"
                                         class="thumb">
                                @else
                                    <span class="badge badge-secondary">No Image</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($experience->sub_heading, 25) ?: '—' }}</td>
                            <td style="font-weight:700; color:#0a214f;">{{ Str::limit($experience->heading, 25) ?: '—' }}</td>
                            <td>{{ Str::limit($experience->tab, 15) ?: '—' }}</td>
                            <td style="color:#6b7280;">{{ Str::limit(strip_tags($experience->description), 45) ?: '—' }}</td>
                            <td>
                                <div style="font-size:10px; color:#374151;">{{ $experience->created_at->format('d M Y') }}</div>
                                <div style="font-size:10px; color:#9ca3af;">{{ $experience->created_at->format('h:i A') }}</div>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:5px; align-items:center; justify-content:center;">
                                    <a href="{{ route('experience.the.power.edit', $experience->id) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('experience.the.power.delete', $experience->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirmDelete(event, '{{ addslashes($experience->heading ?? 'this item') }}')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Del
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-bolt"></i>
                                    <p>No experience found. Upar se add karein!</p>
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

{{-- Delete Confirm Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div style="background:#fff; border-radius:12px; width:310px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="background:linear-gradient(135deg,#ef4444,#f87171); padding:12px 16px; color:white; display:flex; align-items:center; justify-content:space-between;">
            <h6 style="font-family:'Sora',sans-serif; font-size:12px; font-weight:700; margin:0;"><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h6>
            <button style="background:none; border:none; color:white; font-size:15px; cursor:pointer;" onclick="closeDeleteModal()">✕</button>
        </div>
        <div style="padding:18px 16px; text-align:center;">
            <p style="font-size:11px; color:#374151; margin:0 0 6px;">Delete karna chahte hain?</p>
            <strong id="deleteItemName" style="color:#ef4444; font-size:12px;"></strong>
            <p style="font-size:10px; color:#9ca3af; margin-top:6px;">Yeh action undo nahi hoga.</p>
        </div>
        <div style="padding:10px 16px; display:flex; gap:8px; justify-content:center; border-top:1px solid #f3f4f6;">
            <button class="btn btn-secondary btn-sm" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Haan, Delete
            </button>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const box = document.getElementById('imagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; box.style.display = 'block'; };
            reader.readAsDataURL(file);
        } else { box.style.display = 'none'; }
    }

    let pendingDeleteForm = null;

    function confirmDelete(e, name) {
        e.preventDefault();
        pendingDeleteForm = e.target;
        document.getElementById('deleteItemName').textContent = '"' + name + '"';
        document.getElementById('deleteModal').classList.add('show');
        return false;
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
        pendingDeleteForm = null;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (pendingDeleteForm) pendingDeleteForm.submit();
    });

    setTimeout(() => {
        document.querySelectorAll('.alert-success, .alert-danger').forEach(el => el.remove());
    }, 5000);
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => { console.error(error); });
</script>

@endsection
