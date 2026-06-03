@extends('backend.layouts.layout')
@section('title', 'Terms of Service Management')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; }
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
    .alert-danger ul { margin: 0; padding-left: 16px; }
    .alert-danger ul li { font-size: 11px; }

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
    .card-header-dark {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }

    .card-body { padding: 16px; }

    .form-label {
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
        color: #0a214f; margin-bottom: 5px; display: block;
    }
    .form-control {
        border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 6px 10px; font-size: 11px; font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease; width: 100%;
    }
    .form-control:focus {
        border-color: #1872B5; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); outline: none;
    }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 10px; margin-top: 3px; display: block; }
    .form-group { margin-bottom: 12px; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 12px 0; }
    .text-danger { color: #ef4444; }

    .btn {
        padding: 6px 13px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 10px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary   { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); color: white; }
    .btn-success   { background: linear-gradient(135deg, #059669, #34d399); color: white; box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
    .btn-success:hover { transform: translateY(-1px); color: white; }
    .btn-warning   { background: linear-gradient(135deg, #b45309, #f59e0b); color: white; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
    .btn-warning:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-danger    { background: linear-gradient(135deg, #ef4444, #f87171); color: white; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-info-outline {
        background: transparent; border: 1.5px solid #0ea5e9; color: #0ea5e9;
        padding: 4px 10px; font-size: 10px; border-radius: 6px;
        font-family: 'Sora', sans-serif; font-weight: 700; cursor: pointer;
        transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px;
    }
    .btn-info-outline:hover { background: #0ea5e9; color: white; }
    .btn-info-outline.active { background: #10b981; border-color: #10b981; color: white; }
    .btn-sm { padding: 4px 8px; font-size: 10px; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }
    .desc-label-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }

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

    .badge-id { background: #e0e7ff; color: #3730a3; font-size: 10px; padding: 3px 8px; border-radius: 20px; font-family: 'Sora', sans-serif; font-weight: 700; display: inline-block; }

    .content-preview-box {
        background: #f9fafb; padding: 10px 12px; border-radius: 6px;
        border: 1px solid #e5e7eb; font-size: 10px; color: #374151;
        max-height: 80px; overflow-y: auto; line-height: 1.6;
    }
    .view-full-btn {
        margin-top: 6px; font-size: 10px; background: transparent;
        border: 1px solid #0ea5e9; color: #0ea5e9; padding: 3px 8px;
        border-radius: 5px; cursor: pointer; font-family: 'Sora', sans-serif;
        font-weight: 700; display: inline-flex; align-items: center; gap: 4px;
        transition: all 0.2s;
    }
    .view-full-btn:hover { background: #0ea5e9; color: white; }

    .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-state i { font-size: 32px; display: block; margin-bottom: 10px; opacity: 0.35; }
    .empty-state p { font-size: 11px; margin: 0; }

    /* Preview Modal */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 9999; align-items: center; justify-content: center; }
    .modal-overlay.show { display: flex; }
    .modal-box-lg {
        background: #fff; border-radius: 12px; width: 680px; max-width: 95vw;
        max-height: 85vh; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        display: flex; flex-direction: column;
    }
    .modal-hdr {
        background: linear-gradient(135deg, #0a214f, #1872B5); padding: 12px 16px;
        color: white; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;
    }
    .modal-hdr h6 { font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700; margin: 0; }
    .modal-close-btn { background: none; border: none; color: white; font-size: 16px; cursor: pointer; }
    .modal-body-scroll { padding: 16px; overflow-y: auto; flex: 1; }
    .modal-ftr { padding: 10px 16px; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
    .modal-ftr small { font-size: 10px; color: #9ca3af; }

    .rich-content { line-height: 1.8; font-size: 12px; color: #374151; }
    .rich-content h2 { font-size: 15px; font-weight: 700; margin: 14px 0 6px; color: #0a214f; }
    .rich-content h3 { font-size: 13px; font-weight: 700; margin: 12px 0 5px; color: #0a214f; }
    .rich-content p { margin-bottom: 8px; }
    .rich-content ul, .rich-content ol { margin-bottom: 8px; padding-left: 20px; }

    /* Delete Modal */
    .del-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center; }
    .del-modal-overlay.show { display: flex; }

    @media (max-width: 768px) {
        .btn-group-custom { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">📋 Terms of Service Management</h1>
        <p class="page-subtitle">Website ke terms of service manage karein</p>
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
    @if($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM CARD --}}
    @if($canAdd || isset($page))
    <div class="page-card">
        <div class="{{ isset($page) ? 'card-header-warning' : 'card-header-gradient' }}">
            <h2 class="card-header-title">
                @if(isset($page))
                    <i class="fas fa-pen"></i> Edit Terms of Service
                @else
                    <i class="fas fa-plus-circle"></i> Add Terms of Service
                @endif
            </h2>
        </div>
        <div class="card-body">
            <form action="{{ isset($page) ? route('terms.of.service.update', $page->id) : route('terms.of.service.store') }}"
                  method="POST"
                  id="termsForm">
                @csrf

                <div class="form-group">
                    <label class="form-label">Heading <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control @error('heading') is-invalid @enderror"
                           id="heading" name="heading"
                           value="{{ old('heading', isset($page) ? $page->heading : '') }}"
                           placeholder="Enter terms of service heading"
                           required>
                    @error('heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <div class="desc-label-row">
                        <label class="form-label" style="margin:0;">Description <span class="text-danger">*</span></label>
                        <button type="button" id="toggleEditorBtn" class="btn-info-outline" onclick="toggleEditor()">
                            <i class="fas fa-code"></i> Show HTML Source
                        </button>
                    </div>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="editor" name="description" rows="14"
                              placeholder="Enter terms of service description"
                              required>{{ old('description', isset($page) ? $page->description : '') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <hr>

                <div class="btn-group-custom">
                    @if(isset($page))
                        <a href="{{ route('terms.of.service') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Terms of Service
                        </button>
                    @else
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Terms of Service
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- TABLE CARD --}}
    @if($page)
    <div class="page-card">
        <div class="card-header-dark">
            <h2 class="card-header-title"><i class="fas fa-file-contract"></i> Current Terms of Service</h2>
        </div>
        <div class="card-body" style="padding:0;">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:50px;">ID</th>
                            <th style="width:200px;">Heading</th>
                            <th>Description Preview</th>
                            <th style="width:110px;">Last Updated</th>
                            <th style="width:110px; text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align:center;">
                                <span class="badge-id">#{{ $page->id }}</span>
                            </td>
                            <td style="font-weight:700; color:#0a214f;">{{ $page->heading }}</td>
                            <td>
                                <div class="content-preview-box">
                                    {{ Str::limit(strip_tags($page->description), 180) }}
                                </div>
                                <button class="view-full-btn" onclick="openPreviewModal()">
                                    <i class="fas fa-eye"></i> View Full
                                </button>
                            </td>
                            <td>
                                <div style="font-size:10px; color:#374151;">{{ $page->updated_at->format('d M Y') }}</div>
                                <div style="font-size:10px; color:#9ca3af;">{{ $page->updated_at->format('h:i A') }}</div>
                            </td>
                            <td style="text-align:center;">
                                <div style="display:flex; gap:5px; align-items:center; justify-content:center;">
                                    <a href="{{ route('terms.of.service') }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('terms.of.service.delete', $page->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirmDelete(event, 'Terms of Service')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Del
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Full Preview Modal --}}
    <div class="modal-overlay" id="previewModal">
        <div class="modal-box-lg">
            <div class="modal-hdr">
                <h6><i class="fas fa-file-contract"></i> {{ $page->heading }}</h6>
                <button class="modal-close-btn" onclick="closePreviewModal()">✕</button>
            </div>
            <div class="modal-body-scroll">
                <div class="rich-content">
                    {!! $page->description !!}
                </div>
            </div>
            <div class="modal-ftr">
                <small>Last updated: {{ $page->updated_at->format('d M Y, h:i A') }}</small>
                <button class="btn btn-secondary btn-sm" onclick="closePreviewModal()">Close</button>
            </div>
        </div>
    </div>

    @else
    <div class="page-card">
        <div class="card-body">
            <div class="empty-state">
                <i class="fas fa-file-contract"></i>
                <p>Koi Terms of Service nahi mili. Upar form se add karein!</p>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- Delete Confirm Modal --}}
<div class="del-modal-overlay" id="deleteModal">
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

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    let editorInstance;
    const editorElement = document.querySelector('#editor');
    const toggleBtn = document.getElementById('toggleEditorBtn');
    const form = document.getElementById('termsForm');

    function initEditor() {
        ClassicEditor
            .create(editorElement, {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'link', 'blockQuote', '|',
                        'undo', 'redo'
                    ]
                }
            })
            .then(editor => {
                editorInstance = editor;
                if (toggleBtn) {
                    toggleBtn.innerHTML = '<i class="fas fa-code"></i> Show HTML Source';
                    toggleBtn.classList.remove('active');
                }
                editor.model.document.on('change:data', () => {
                    editorElement.value = editor.getData();
                });
            })
            .catch(error => console.error(error));
    }

    function toggleEditor() {
        if (editorInstance) {
            editorElement.value = editorInstance.getData();
            editorInstance.destroy().then(() => {
                editorInstance = null;
                if (toggleBtn) {
                    toggleBtn.innerHTML = '<i class="fas fa-magic"></i> Enable Rich Editor';
                    toggleBtn.classList.add('active');
                }
            });
        } else {
            initEditor();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (editorElement) initEditor();
    });

    if (form) {
        form.addEventListener('submit', function (e) {
            if (editorInstance) {
                const data = editorInstance.getData();
                editorElement.value = data;
                if (!data || data.trim() === '' || data === '<p>&nbsp;</p>') {
                    e.preventDefault();
                    alert('⚠️ Please enter Terms of Service description!');
                    return false;
                }
            } else {
                if (!editorElement.value || editorElement.value.trim() === '') {
                    e.preventDefault();
                    alert('⚠️ Please enter Terms of Service description!');
                    return false;
                }
            }
        });
    }

    // Preview Modal
    function openPreviewModal() {
        document.getElementById('previewModal').classList.add('show');
    }
    function closePreviewModal() {
        document.getElementById('previewModal').classList.remove('show');
    }

    // Delete Modal
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
