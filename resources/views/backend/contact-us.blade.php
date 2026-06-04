
@extends('backend.layouts.layout')
@section('title', 'Contact Us')
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
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 10px; background: rgba(255,255,255,0.2); color: #fff; padding: 2px 10px; border-radius: 20px; font-weight: 700; }

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
    .btn-sm { padding: 4px 8px; font-size: 10px; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; justify-content: flex-end; }

    /* Two-col layout — form narrower, info wider */
    .two-col { display: grid; grid-template-columns: 500px 1fr; gap: 16px; align-items: start; }

    /* Info table */
    .info-table { width: 100%; border-collapse: collapse; font-size: 11px; }
    .info-table th {
        padding: 9px 12px; font-family: 'Sora', sans-serif; font-weight: 700;
        color: #0a214f; font-size: 10px; background: #f9fafb;
        border-bottom: 1px solid #e5e7eb; white-space: nowrap; width: 130px;
    }
    .info-table td { padding: 9px 12px; color: #374151; border-bottom: 1px solid #f3f4f6; font-size: 11px; }
    .info-table tr:last-child th,
    .info-table tr:last-child td { border-bottom: none; }

    .badge-set    { background: #d1fae5; color: #065f46; font-size: 10px; padding: 2px 8px; border-radius: 20px; font-family: 'Sora', sans-serif; font-weight: 700; display: inline-block; }
    .badge-notset { background: #fee2e2; color: #7f1d1d; font-size: 10px; padding: 2px 8px; border-radius: 20px; font-family: 'Sora', sans-serif; font-weight: 700; display: inline-block; }

    .api-code { font-size: 12px; background: #f0f4f8; padding: 8px 12px; border-radius: 6px; display: block; font-family: monospace; color: #1872B5; }

    .map-preview-label { font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700; color: #0a214f; margin-bottom: 6px; display: block; }

    .current-img { height: 90px; border-radius: 6px; border: 1px solid #e5e7eb; display: block; margin-bottom: 4px; }

    .section-divider {
        font-family: 'Sora', sans-serif; font-size: 9px; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.08em; color: #9ca3af;
        margin: 14px 0 10px; display: flex; align-items: center; gap: 8px;
    }
    .section-divider::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }

    .empty-state { text-align: center; padding: 30px 20px; color: #6b7280; }
    .empty-state i { font-size: 28px; display: block; margin-bottom: 8px; opacity: 0.35; }
    .empty-state p { font-size: 11px; margin: 0; }

    @media (max-width: 1024px) { .two-col { grid-template-columns: 1fr; } }
    @media (max-width: 768px) {
        .btn-group-custom { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
    }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">📞 Contact Us Management</h1>
        <p class="page-subtitle">Website ke contact page ki details manage karein</p>
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

    <div class="two-col">

        {{-- FORM CARD --}}
        <div class="page-card">
            <div class="{{ $contactUs ? 'card-header-warning' : 'card-header-gradient' }}">
                <h2 class="card-header-title">
                    @if($contactUs)
                        <i class="fas fa-pen"></i> Edit Contact Us
                    @else
                        <i class="fas fa-plus-circle"></i> Add Contact Us
                    @endif
                </h2>
            </div>
            <div class="card-body">

                @if($contactUs)
                    <form action="{{ route('contact.us.update', $contactUs->id) }}" method="POST" enctype="multipart/form-data">
                @else
                    <form action="{{ route('contact.us.store') }}" method="POST" enctype="multipart/form-data">
                @endif
                @csrf

                {{-- Headings --}}
                <div class="section-divider">Headings</div>

                <div class="form-group">
                    <label class="form-label">Page Heading</label>
                    <input type="text" name="page_heading"
                        class="form-control @error('page_heading') is-invalid @enderror"
                        value="{{ old('page_heading', $contactUs->page_heading ?? '') }}"
                        placeholder="e.g. Contact Us">
                    @error('page_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Pre Heading <span style="color:#9ca3af;font-weight:500;">(Contact Details)</span></label>
                    <input type="text" name="pre_heading"
                        class="form-control @error('pre_heading') is-invalid @enderror"
                        value="{{ old('pre_heading', $contactUs->pre_heading ?? '') }}"
                        placeholder="e.g. Contact Details">
                    @error('pre_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="sub_heading" rows="2"
                        class="form-control @error('sub_heading') is-invalid @enderror"
                        placeholder="e.g. Have a question or need assistance?">{{ old('sub_heading', $contactUs->sub_heading ?? '') }}</textarea>
                    @error('sub_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Contact Info --}}
                <div class="section-divider">Contact Info</div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $contactUs->phone ?? '') }}"
                            placeholder="e.g. +91 98765 43210">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Email</label>
                        <input type="text" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $contactUs->email ?? '') }}"
                            placeholder="e.g. info@example.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label class="form-label">Address</label>
                    <textarea name="address" rows="2"
                        class="form-control @error('address') is-invalid @enderror"
                        placeholder="e.g. 57, Block B, South Ex. Part II, New Delhi">{{ old('address', $contactUs->address ?? '') }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Image --}}
                <div class="section-divider">Image</div>

                <div class="form-group">
                    <label class="form-label">Contact Page Image</label>
                    @if($contactUs && $contactUs->image)
                        <img src="{{ asset('uploads/contact-us/' . $contactUs->image) }}"
                            class="current-img" alt="Current Image">
                        <small style="color:#9ca3af; font-size:10px; display:block; margin-bottom:6px;">Current image</small>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Image Alt Tag</label>
                    <input type="text" name="image_alt"
                        class="form-control @error('image_alt') is-invalid @enderror"
                        value="{{ old('image_alt', $contactUs->image_alt ?? '') }}"
                        placeholder="Image description for SEO">
                    @error('image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Map --}}
                <div class="section-divider">Google Map</div>

                <div class="form-group">
                    <label class="form-label">Google Map Embed URL</label>
                    <small style="color:#9ca3af; font-size:10px; display:block; margin-bottom:5px;">
                        Google Maps → Share → Embed a map → sirf <code>src="..."</code> ki value paste karo
                    </small>
                    <textarea name="map_embed" rows="3"
                        class="form-control @error('map_embed') is-invalid @enderror"
                        placeholder="https://www.google.com/maps/embed?pb=...">{{ old('map_embed', $contactUs->map_embed ?? '') }}</textarea>
                    @error('map_embed')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if($contactUs && $contactUs->map_embed)
                    <div class="form-group">
                        <span class="map-preview-label">Map Preview</span>
                        <iframe src="{{ $contactUs->map_embed }}"
                            width="100%" height="200"
                            style="border:0; border-radius:8px; display:block;"
                            allowfullscreen loading="lazy">
                        </iframe>
                    </div>
                @endif

                {{-- Actions --}}
                <div class="btn-group-custom">
                    @if($contactUs)
                        <a href="{{ route('contact.us.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <form action="{{ route('contact.us.delete', $contactUs->id) }}" method="POST"
                            class="d-inline"
                            onsubmit="return confirmDelete(event, 'Contact Us')">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update
                        </button>
                    @else
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Save
                        </button>
                    @endif
                </div>

                </form>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div>

            {{-- Current Data Card --}}
            <div class="page-card">
                <div class="card-header-dark">
                    <div class="card-header-row">
                        <h2 class="card-header-title"><i class="fas fa-clipboard-list"></i> Current Data</h2>
                        @if($contactUs)
                            <span class="table-count">ID: #{{ $contactUs->id }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body" style="padding:0;">
                    @if($contactUs)
                        <table class="info-table">
                            <tr>
                                <th>Page Heading</th>
                                <td>{{ $contactUs->page_heading ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Pre Heading</th>
                                <td>{{ $contactUs->pre_heading ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td style="color:#6b7280;">{{ Str::limit($contactUs->sub_heading, 80) ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $contactUs->phone ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $contactUs->email ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td style="color:#6b7280;">{{ Str::limit($contactUs->address, 60) ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td>
                                    @if($contactUs->image)
                                        <span class="badge-set">✅ Set</span>
                                    @else
                                        <span class="badge-notset">❌ Not Set</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Map Embed</th>
                                <td>
                                    @if($contactUs->map_embed)
                                        <span class="badge-set">✅ Set</span>
                                    @else
                                        <span class="badge-notset">❌ Not Set</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>
                                    <div style="font-size:10px; color:#374151;">{{ $contactUs->updated_at->format('d M Y') }}</div>
                                    <div style="font-size:10px; color:#9ca3af;">{{ $contactUs->updated_at->format('h:i A') }}</div>
                                </td>
                            </tr>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-phone-slash"></i>
                            <p>Abhi koi data nahi hai.</p>
                            <p style="margin-top:4px; color:#9ca3af;">Form fill karke save karo.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- API Endpoint Card --}}
            <div class="page-card">
                <div style="padding: 12px 20px; border-bottom: 1px solid #e5e7eb;">
                    <h6 class="card-header-title" style="font-family:'Sora',sans-serif; font-size:12px; font-weight:700; color:#0a214f; margin:0;">
                        <i class="fas fa-code" style="color:#1872B5;"></i> API Endpoint
                    </h6>
                </div>
                <div class="card-body">
                    <code class="api-code">/api/contact-us</code>
                    <p style="font-size:10px; color:#9ca3af; margin-top:8px; margin-bottom:0;">
                        GET request — frontend yahan se data fetch karega
                    </p>
                </div>
            </div>

            {{-- Image Preview Card (only if image exists) --}}
            @if($contactUs && $contactUs->image)
            <div class="page-card">
                <div style="padding: 12px 20px; border-bottom: 1px solid #e5e7eb;">
                    <h6 class="card-header-title" style="font-family:'Sora',sans-serif; font-size:12px; font-weight:700; color:#0a214f; margin:0;">
                        <i class="fas fa-image" style="color:#1872B5;"></i> Image Preview
                    </h6>
                </div>
                <div class="card-body" style="text-align:center;">
                    <img src="{{ asset('uploads/contact-us/' . $contactUs->image) }}"
                        style="max-width:100%; border-radius:8px; border:1px solid #e5e7eb;"
                        alt="{{ $contactUs->image_alt ?? 'Contact Us Image' }}">
                    @if($contactUs->image_alt)
                        <p style="font-size:10px; color:#9ca3af; margin-top:6px; margin-bottom:0;">
                            Alt: {{ $contactUs->image_alt }}
                        </p>
                    @endif
                </div>
            </div>
            @endif

        </div>

    </div>
</div>

{{-- Delete Confirm Modal --}}
<div class="del-modal-overlay" id="deleteModal">
    <div style="background:#fff; border-radius:12px; width:310px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="background:linear-gradient(135deg,#ef4444,#f87171); padding:12px 16px; color:white; display:flex; align-items:center; justify-content:space-between;">
            <h6 style="font-family:'Sora',sans-serif; font-size:12px; font-weight:700; margin:0;">
                <i class="fas fa-exclamation-triangle"></i> Confirm Delete
            </h6>
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

<style>
    .del-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .del-modal-overlay.show { display: flex; }
</style>

<script>
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
