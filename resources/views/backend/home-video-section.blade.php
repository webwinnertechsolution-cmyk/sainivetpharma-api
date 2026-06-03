@extends('backend.layouts.layout')
@section('title', 'Home Video Sections')
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
    .alert-info-box {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border: 1px solid #93c5fd; color: #1e40af;
        padding: 10px 14px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: flex-start; gap: 10px;
        font-size: 12px; font-weight: 500;
    }
    .alert-info-box code {
        background: #fff; padding: 2px 8px; border-radius: 5px;
        font-size: 12px; color: #1e40af; border: 1px solid #bfdbfe;
        display: inline-block; margin-top: 4px;
    }

    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }

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
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 11px; background: rgba(255,255,255,0.2); color: #fff; padding: 3px 10px; border-radius: 20px; font-weight: 700; }

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
    .form-group { margin-bottom: 12px; }

    .form-check { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
    .form-check-input { width: 16px; height: 16px; margin: 0; cursor: pointer; accent-color: #1872B5; }
    .form-check-label { font-size: 12px; color: #0a214f; font-weight: 600; margin: 0; cursor: pointer; }
    .form-switch .form-check-input { width: 36px; height: 18px; }

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
    .btn-warning { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-danger { background: linear-gradient(135deg, #ef4444, #f87171); color: white; font-weight: 700; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-outline-add {
        background: #f0f9ff; color: #1872B5;
        border: 1.5px dashed #93c5fd; border-radius: 6px;
        padding: 5px 10px; font-size: 11px; font-family: 'Sora', sans-serif;
        font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;
        transition: all 0.2s;
    }
    .btn-outline-add:hover { background: #dbeafe; border-color: #1872B5; }
    .btn-remove {
        background: #fee2e2; color: #dc2626; border: none;
        border-radius: 5px; padding: 3px 8px; font-size: 11px;
        cursor: pointer; font-weight: 700; flex-shrink: 0;
        transition: background 0.2s;
    }
    .btn-remove:hover { background: #fca5a5; }
    .btn-sm { padding: 4px 9px; font-size: 10px; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    /* Two col layout */
    .two-col { display: grid; grid-template-columns: 440px 1fr; gap: 16px; align-items: start; }

    /* Existing video row */
    .vid-row {
        display: flex; align-items: center; gap: 8px;
        border: 1px solid #e5e7eb; border-radius: 8px;
        padding: 8px 10px; margin-bottom: 8px;
        background: #f9fafb;
    }
    .vid-row:hover { border-color: #1872B5; background: #f0f7ff; }
    .vid-thumb {
        width: 64px; height: 40px; object-fit: cover;
        border-radius: 5px; flex-shrink: 0;
    }
    .vid-thumb-placeholder {
        width: 64px; height: 40px; background: linear-gradient(135deg, #0a214f, #1872B5);
        border-radius: 5px; display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 16px; flex-shrink: 0;
    }
    .vid-keep-check { width: 16px; height: 16px; accent-color: #1872B5; cursor: pointer; flex-shrink: 0; }

    /* Upload section box */
    .upload-box {
        background: #f8faff; border: 1.5px dashed #c7d7f0;
        border-radius: 8px; padding: 12px 14px; margin-bottom: 12px;
    }
    .upload-box-title {
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
        color: #1872B5; margin-bottom: 6px; display: flex; align-items: center; gap: 5px;
    }

    /* Table */
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
    .badge-success  { background: #d1fae5; color: #065f46; }
    .badge-secondary{ background: #f3f4f6; color: #6b7280; }
    .badge-id       { background: #e0e7ff; color: #3730a3; font-size: 11px; padding: 4px 10px; }
    .badge-danger   { background: #fee2e2; color: #7f1d1d; }
    .badge-info     { background: #dbeafe; color: #1e40af; }

    .shortcode-box {
        background: #f0f4f8; padding: 2px 8px; border-radius: 4px;
        font-size: 10px; font-family: 'Courier New', monospace;
        color: #1e40af; display: inline-block; margin-top: 4px;
        border: 1px solid #e0e7ff;
    }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 36px; display: block; margin-bottom: 10px; opacity: 0.4; }
    .empty-state p { font-size: 12px; margin: 0; }

    /* Delete Modal */
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

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">🎬 Home Video Sections</h1>
        <p class="page-subtitle">Manage video sections displayed on the homepage</p>
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

    {{-- Info Box --}}
    <div class="alert-info-box">
        <span style="font-size:18px;flex-shrink:0;">💡</span>
        <div>
            <strong>Shortcode Usage:</strong> Section ID note karo aur Next.js page mein use karo:<br>
            <code>&lt;VideoSection sectionId={1} /&gt;</code>
        </div>
    </div>

    <div class="two-col">

        {{-- FORM CARD --}}
        <div class="page-card">
            <div class="{{ isset($editSection) ? 'card-header-warning' : 'card-header-gradient' }}">
                <h2 class="card-header-title">
                    @if(isset($editSection))
                        <i class="fas fa-pen"></i> Edit Section #{{ $editSection->id }}
                    @else
                        <i class="fas fa-plus-circle"></i> Add New Section
                    @endif
                </h2>
            </div>
            <div class="card-body">

                @if(isset($editSection))
                    <form action="{{ route('home.video.section.update', $editSection->id) }}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{ route('home.video.section.store') }}" method="POST" enctype="multipart/form-data">
                @endif
                @csrf

                {{-- Heading --}}
                <div class="form-group">
                    <label class="form-label">Heading <span class="text-danger">*</span></label>
                    <input type="text" name="heading" class="form-control"
                        value="{{ old('heading', $editSection->heading ?? '') }}"
                        placeholder="e.g. Our Latest Videos 🎥" required>
                </div>

                {{-- Sub Heading --}}
                <div class="form-group">
                    <label class="form-label">Sub Heading</label>
                    <input type="text" name="sub_heading" class="form-control"
                        value="{{ old('sub_heading', $editSection->sub_heading ?? '') }}"
                        placeholder="e.g. Watch our product demos">
                </div>

                {{-- View All Text --}}
                <div class="form-group">
                    <label class="form-label">View All Button Text</label>
                    <input type="text" name="view_all_text" class="form-control"
                        value="{{ old('view_all_text', $editSection->view_all_text ?? 'View All') }}">
                </div>

                {{-- View All URL --}}
                <div class="form-group">
                    <label class="form-label">View All URL</label>
                    <input type="text" name="view_all_url" class="form-control"
                        value="{{ old('view_all_url', $editSection->view_all_url ?? '') }}"
                        placeholder="e.g. /videos">
                </div>

                {{-- Sort Order --}}
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" min="0"
                        value="{{ old('sort_order', $editSection->sort_order ?? 0) }}">
                </div>

                <hr>

                {{-- Active Toggle --}}
                <div class="form-check form-switch" style="margin-bottom:12px;">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                        {{ old('is_active', $editSection->is_active ?? 1) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active (Show on frontend)</label>
                </div>

                <hr>

                {{-- Existing Videos (Edit Mode) --}}
                @if(isset($editSection) && !empty($editSection->videos))
                    <div class="form-group">
                        <label class="form-label">
                            Existing Videos
                            <small>Uncheck karo to delete karne ke liye</small>
                        </label>
                        @foreach($editSection->videos as $i => $vid)
                        <div class="vid-row">
                            <input type="checkbox" name="keep_videos[]" value="{{ $i }}"
                                checked class="vid-keep-check">
                            @if(!empty($vid['thumbnail']))
                                <img src="{{ asset('uploads/video-sections/thumbnails/' . $vid['thumbnail']) }}"
                                    class="vid-thumb" alt="thumb">
                            @else
                                <div class="vid-thumb-placeholder">🎬</div>
                            @endif
                            <input type="text" name="existing_titles[{{ $i }}]"
                                class="form-control"
                                value="{{ $vid['title'] ?? '' }}"
                                placeholder="Video title"
                                style="font-size:11px;">
                        </div>
                        @endforeach
                    </div>
                    <hr>
                @endif

                {{-- Upload New Videos --}}
                <div class="form-group">
                    <label class="form-label">
                        {{ isset($editSection) ? 'Add More Videos' : 'Upload Videos' }}
                        <small>Ek saath multiple files select kar sakte ho</small>
                    </label>

                    <div class="upload-box">
                        <div class="upload-box-title"><i class="fas fa-film"></i> Video Files</div>
                        <input type="file" name="videos[]" class="form-control"
                            accept="video/*" multiple
                            style="font-size:11px;">
                        <div style="font-size:10px;color:#6b7280;margin-top:4px;">mp4, webm, mov — Ctrl/Cmd + Click se multiple select karo</div>
                    </div>

                    <div class="upload-box">
                        <div class="upload-box-title"><i class="fas fa-image"></i> Thumbnails (optional)</div>
                        <input type="file" name="thumbnails[]" class="form-control"
                            accept="image/*" multiple
                            style="font-size:11px;">
                        <div style="font-size:10px;color:#6b7280;margin-top:4px;">Videos ke order mein thumbnails upload karo</div>
                    </div>

                    {{-- Dynamic Title Fields --}}
                    <div class="upload-box">
                        <div class="upload-box-title"><i class="fas fa-heading"></i> Video Titles (optional)</div>
                        <div id="title-list">
                            <input type="text" name="video_titles[]"
                                class="form-control" style="font-size:11px;margin-bottom:6px;"
                                placeholder="Video 1 title">
                        </div>
                        <button type="button" class="btn-outline-add" onclick="addTitleField()">
                            <i class="fas fa-plus"></i> Add Title Field
                        </button>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="btn-group-custom">
                    @if(isset($editSection))
                        <a href="{{ route('home.video.section') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Section
                        </button>
                    @else
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Section
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
                    <h2 class="card-header-title"><i class="fas fa-list"></i> All Video Sections</h2>
                    <span class="table-count">Total: {{ $sections->count() }}</span>
                </div>
            </div>
            <div class="card-body" style="padding:0;">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:55px">ID</th>
                                <th>Heading</th>
                                <th style="width:80px;text-align:center;">Videos</th>
                                <th style="width:75px;text-align:center;">Status</th>
                                <th style="width:120px;text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sections as $sec)
                            <tr>
                                <td style="text-align:center;">
                                    <span class="badge badge-id">#{{ $sec->id }}</span>
                                </td>
                                <td>
                                    <div style="font-weight:700;color:#0a214f;font-size:12px;">{{ $sec->heading }}</div>
                                    @if($sec->sub_heading)
                                        <div style="font-size:10px;color:#6b7280;margin-top:1px;">{{ $sec->sub_heading }}</div>
                                    @endif
                                    <div class="shortcode-box">
                                        @php echo htmlspecialchars('<VideoSection sectionId={' . $sec->id . '} />'); @endphp
                                    </div>
                                </td>
                                <td style="text-align:center;">
                                    <span class="badge badge-info">
                                        <i class="fas fa-film" style="font-size:9px;"></i>
                                        {{ count($sec->videos ?? []) }}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    @if($sec->is_active)
                                        <span class="badge badge-success">✅ Active</span>
                                    @else
                                        <span class="badge badge-danger">❌ Off</span>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    <div style="display:flex;gap:5px;align-items:center;justify-content:center;">
                                        <a href="{{ route('home.video.section.edit', $sec->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('home.video.section.delete', $sec->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirmDelete(event, '{{ addslashes($sec->heading) }}')">
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
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-film"></i>
                                        <p>No video sections yet. Add your first one!</p>
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

<script>
    function addTitleField() {
        const list  = document.getElementById('title-list');
        const count = list.querySelectorAll('input[type="text"]').length + 1;
        const div   = document.createElement('div');
        div.style.cssText = 'display:flex;gap:6px;margin-bottom:6px;';
        div.innerHTML = `
            <input type="text" name="video_titles[]"
                class="form-control" style="font-size:11px;"
                placeholder="Video ${count} title">
            <button type="button" class="btn-remove" onclick="this.parentElement.remove()">✕</button>
        `;
        list.appendChild(div);
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
