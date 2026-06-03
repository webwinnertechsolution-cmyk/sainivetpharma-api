@extends('backend.layouts.layout')
@section('title', 'Offering an Innovative')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 12px; color: #6b7280; font-weight: 500; }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7; color: #065f46;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px;
    }
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px;
    }
    .alert-warning-box {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border: 1px solid #fcd34d; color: #92400e;
        padding: 9px 12px; border-radius: 7px; margin-top: 10px;
        font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 7px;
    }

    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }
    .page-card.disabled-card { opacity: 0.55; pointer-events: none; }

    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-warning {
        background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    }
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 11px; background: rgba(255,255,255,0.2); color: #fff; padding: 3px 10px; border-radius: 20px; font-weight: 700; }
    .limit-badge {
        font-size: 10px; background: #fef3c7; color: #92400e;
        padding: 2px 8px; border-radius: 12px; font-weight: 700;
    }

    .card-body { padding: 16px; }

    .form-label {
        font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700;
        color: #0a214f; margin-bottom: 6px; display: block;
    }
    .form-label small { display: block; font-size: 10px; font-weight: 500; color: #6b7280; margin-top: 2px; }

    .form-control, .form-select {
        border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 7px 10px; font-size: 12px; font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease; width: 100%;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1872B5; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); outline: none;
    }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 11px; margin-top: 4px; display: block; }
    .form-group { margin-bottom: 12px; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }
    .text-danger { color: #ef4444; }

    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
    .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
    .btn-warning { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-danger { background: linear-gradient(135deg, #ef4444, #f87171); color: white; font-weight: 700; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-sm { padding: 4px 9px; font-size: 10px; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    .two-col { display: grid; grid-template-columns: 440px 1fr; gap: 16px; align-items: start; }

    .img-preview-box {
        margin-top: 8px; padding: 6px 8px; background: #f0f4f8;
        border-radius: 6px; display: inline-block;
    }
    .img-preview-box img { max-width: 100px; max-height: 65px; object-fit: contain; }
    .img-preview-box p { font-size: 10px; color: #6b7280; margin: 4px 0 0; }

    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    thead tr { background: #f9fafb; }
    thead th {
        padding: 10px 12px; font-family: 'Sora', sans-serif; font-weight: 700;
        color: #0a214f; font-size: 11px; border-bottom: 2px solid #e5e7eb; white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody td { padding: 8px 12px; color: #374151; vertical-align: middle; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 8px; border-radius: 20px; font-size: 10px;
        font-family: 'Sora', sans-serif; font-weight: 700;
    }
    .badge-secondary { background: #f3f4f6; color: #6b7280; }
    .badge-id { background: #e0e7ff; color: #3730a3; font-size: 11px; padding: 4px 10px; }

    .thumb {
        width: 80px; height: 50px; object-fit: cover;
        border-radius: 6px; border: 1px solid #e5e7eb; background: #f9fafb;
    }
    .desc-text { font-size: 11px; color: #6b7280; max-width: 220px; }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.4; }
    .empty-state p { font-size: 12px; margin: 0; }

    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.5); z-index: 9999;
        align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box { background: #fff; border-radius: 12px; width: 320px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
    .modal-box-header { background: linear-gradient(135deg, #ef4444, #f87171); padding: 12px 16px; color: white; display: flex; align-items: center; justify-content: space-between; }
    .modal-box-header h6 { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; margin: 0; }
    .modal-close { background: none; border: none; color: white; font-size: 16px; cursor: pointer; }
    .modal-box-body { padding: 20px 16px; text-align: center; }
    .modal-box-body p { font-size: 12px; color: #374151; margin: 0 0 6px; }
    .modal-box-body strong { color: #ef4444; font-size: 13px; }
    .modal-box-body .note { font-size: 10px; color: #9ca3af; margin-top: 6px; }
    .modal-box-footer { padding: 10px 16px; display: flex; gap: 8px; justify-content: center; border-top: 1px solid #f3f4f6; }

    .ck-editor__editable { min-height: 150px !important; font-size: 12px !important; }


        .form-check.form-switch {
    width: 61%;
    margin-left: 42px!important;
}
    .form-check .form-check-label {
    display: block;
    margin-left: 0;
    font-size: 0.875rem;
    line-height: 1.5;
}
    .btn.btn-sm, .ajax-upload-dragdrop .btn-sm.ajax-file-upload, .btn-group-sm > .btn, .ajax-upload-dragdrop .btn-group-sm > .ajax-file-upload {
    font-size: 9px!important;
}

    
    @media (max-width: 1024px) { .two-col { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .btn-group-custom { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">

    <div class="page-header">
        <h1 class="page-title">💡 About</h1>
    </div>

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

    <div class="two-col">

        {{-- FORM CARD --}}
        <div class="page-card {{ $offeringCount >= 1 && !isset($editOffering) ? 'disabled-card' : '' }}">
            <div class="{{ isset($editOffering) ? 'card-header-warning' : 'card-header-gradient' }}">
                <h2 class="card-header-title">
                    @if(isset($editOffering))
                        <i class="fas fa-pen"></i> Edit Offering #{{ $editOffering->id }}
                    @else
                        <i class="fas fa-lightbulb"></i> Add New Offering
                    @endif
                    @if($offeringCount >= 1 && !isset($editOffering))
                        <span class="limit-badge">⚠️ Max 1 Item</span>
                    @endif
                </h2>
            </div>
            <div class="card-body">
                <form action="{{ isset($editOffering) ? route('offering.update', $editOffering->id) : route('offering.store') }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    <fieldset {{ $offeringCount >= 1 && !isset($editOffering) ? 'disabled' : '' }}
                              style="border:none;padding:0;margin:0;">

                        {{-- Image --}}
                        <div class="form-group">
                            <label class="form-label">
                                Image
                                @if(!isset($editOffering)) <span class="text-danger">*</span>
                                @else <small>Leave blank to keep existing</small>
                                @endif
                            </label>
                            <input type="file"
                                   class="form-control @error('image') is-invalid @enderror"
                                   name="image" accept="image/*"
                                   {{ !isset($editOffering) ? 'required' : '' }}
                                   onchange="previewImage(event)">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                            @if(isset($editOffering) && $editOffering->image)
                                <div class="img-preview-box">
                                    <img src="{{ asset('uploads/offering/' . $editOffering->image) }}" alt="Current">
                                    <p>Current image</p>
                                </div>
                            @endif
                            <div class="img-preview-box" id="imagePreview" style="display:none;">
                                <img id="preview" src="" alt="Preview">
                                <p>New preview</p>
                            </div>
                        </div>

                        {{-- Alt Tag --}}
                        <div class="form-group">
                            <label class="form-label">Image Alt Tag</label>
                            <input type="text"
                                   class="form-control @error('alt_tag') is-invalid @enderror"
                                   name="alt_tag"
                                   value="{{ old('alt_tag', $editOffering->alt_tag ?? '') }}"
                                   placeholder="Enter image alt tag">
                            @error('alt_tag')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Heading --}}
                        <div class="form-group">
                            <label class="form-label">Heading</label>
                            <input type="text"
                                   class="form-control @error('heading') is-invalid @enderror"
                                   name="heading"
                                   value="{{ old('heading', $editOffering->heading ?? '') }}"
                                   placeholder="Enter heading">
                            @error('heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="editor" name="description" rows="6"
                                      placeholder="Enter description">{{ old('description', $editOffering->description ?? '') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                    </fieldset>

                    @if($offeringCount >= 1 && !isset($editOffering))
                        <div class="alert-warning-box">
                            <i class="fas fa-info-circle"></i>
                            Only 1 offering allowed. Delete existing item to add new.
                        </div>
                    @endif

                    <div class="btn-group-custom">
                        @if(isset($editOffering))
                            <a href="{{ route('offering') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update Offering
                            </button>
                        @else
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary"
                                    {{ $offeringCount >= 1 ? 'disabled' : '' }}>
                                <i class="fas fa-plus"></i> Add 
                            </button>
                        @endif
                    </div>

                </form>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="page-card">
            <div class="card-header-gradient">
                <div class="card-header-row">
                    <h2 class="card-header-title"><i class="fas fa-list"></i> All </h2>
                    <span class="table-count">Total: {{ $offerings->count() }}</span>
                </div>
            </div>
            <div class="card-body" style="padding:0;">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:55px">ID</th>
                                <th style="width:90px">Image</th>
                                <th>Heading</th>
                                <th>Description</th>
                                <th style="width:90px;text-align:center;">Added</th>
                                <th style="width:120px;text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offerings as $offering)
                            <tr>
                                <td style="text-align:center;">
                                    <span class="badge badge-id">#{{ $offering->id }}</span>
                                </td>
                                <td>
                                    @if($offering->image)
                                        <img src="{{ asset('uploads/offering/' . $offering->image) }}"
                                             alt="{{ $offering->alt_tag ?? 'Offering' }}" class="thumb">
                                    @else
                                        <span class="badge badge-secondary">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight:700;color:#0a214f;font-size:12px;">
                                        {{ Str::limit($offering->heading, 35) ?: '—' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="desc-text">
                                        {{ Str::limit(strip_tags($offering->description), 70) ?: '—' }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <div style="font-size:11px;color:#0a214f;font-weight:600;">{{ $offering->created_at->format('d M Y') }}</div>
                                    <div style="font-size:10px;color:#6b7280;">{{ $offering->created_at->format('h:i A') }}</div>
                                </td>
                                <td style="text-align:center;">
                                    <div style="display:flex;gap:5px;align-items:center;justify-content:center;">
                                        <a href="{{ route('offering.edit', $offering->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('offering.delete', $offering->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirmDelete(event, '{{ addslashes($offering->heading ?? 'Offering #' . $offering->id) }}')">
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
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-lightbulb"></i>
                                        <p>No offerings yet. Add your first one!</p>
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

{{-- Delete Confirm Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-box-header">
            <h6><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h6>
            <button class="modal-close" onclick="closeDeleteModal()">✕</button>
        </div>
        <div class="modal-box-body">
            <p>Are you sure you want to delete</p>
            <strong id="deleteItemName"></strong>
            <p class="note">This action cannot be undone.</p>
        </div>
        <div class="modal-box-footer">
            <button class="btn btn-secondary btn-sm" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#editor')).catch(e => console.error(e));

    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'inline-block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imagePreview').style.display = 'none';
        }
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

@endsection
