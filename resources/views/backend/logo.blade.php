@extends('backend.layouts.layout')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background: #f5f7fa;
    }

    .logo-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0;
}

    .logo-header {
        margin-bottom: 20px;
    }

    .logo-title {
        font-family: 'Sora', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: #0a214f;
        margin-bottom: 6px;
        letter-spacing: -0.02em;
    }

    .logo-subtitle {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Alert Styles */
    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7;
        color: #065f46;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 500;
        font-size: 12px;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5;
        color: #7f1d1d;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 500;
        font-size: 12px;
    }

    .alert .btn-close {
        opacity: 1;
        filter: invert(0);
    }

    /* Card Styles */
    .logo-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10, 33, 79, 0.08);
        overflow: hidden;
        margin-bottom: 16px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .logo-card:hover {
        box-shadow: 0 12px 32px rgba(10, 33, 79, 0.12);
    }

    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 16px 20px;
        color: #ffffff;
    }

    .card-header-title {
        font-family: 'Sora', sans-serif;
        font-size: 15px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .badge-limit {
        background: rgba(255, 255, 255, 0.25);
        color: #fbbf24;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .card-body {
        padding: 20px;
    }

    /* Form Styles */
    .form-label {
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #0a214f;
        margin-bottom: 8px;
        display: block;
    }

    .form-label small {
        display: block;
        font-size: 11px;
        font-weight: 500;
        color: #6b7280;
        margin-top: 3px;
    }

    .form-control {
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 13px;
        font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #1872B5;
        box-shadow: 0 0 0 3px rgba(24, 114, 181, 0.1);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        display: block;
    }

    /* Image Preview */
    .image-preview-box {
        margin-top: 14px;
        padding: 14px;
        background: #f9fafb;
        border: 2px dashed #e5e7eb;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .image-preview-box.active {
        background: #eff6ff;
        border-color: #1872B5;
    }

    .preview-label {
        font-family: 'Sora', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #0a214f;
        margin-bottom: 10px;
        display: block;
    }

    .preview-img {
        max-width: 200px;
        max-height: 120px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 6px;
        background: white;
        object-fit: contain;
    }

    .preview-hint {
        font-size: 11px;
        color: #6b7280;
        margin-top: 6px;
        font-weight: 500;
    }

    /* Buttons */
    .btn-group-custom {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1872B5, #2596e1);
        color: white;
        box-shadow: 0 4px 12px rgba(24, 114, 181, 0.3);
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(24, 114, 181, 0.4);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #1f2937;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .btn-secondary:hover {
        background: #d1d5db;
        transform: translateY(-2px);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: #78350f;
        font-weight: 700;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #f87171);
        color: white;
        font-weight: 700;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 11px;
    }

    /* Disabled State */
    fieldset:disabled {
        opacity: 0.6;
        pointer-events: none;
    }

    .disabled-alert {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 1px solid #fcd34d;
        color: #78350f;
        padding: 10px 12px;
        border-radius: 8px;
        margin-top: 14px;
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Table Styles */
    .table-wrapper {
        overflow-x: auto;
        border-radius: 12px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .table thead {
        background: linear-gradient(135deg, #f0f4f8, #e8f0f8);
    }

    .table th {
        padding: 11px 14px;
        text-align: left;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 11px;
        color: #0a214f;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        border-bottom: 2px solid #1872B5;
    }

    .table td {
        padding: 13px 14px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
        font-size: 13px;
        color: #374151;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background: #f9fafb;
    }

    .logo-preview-wrapper {
        display: inline-block;
        padding: 8px;
        background: #f9fafb;
        border-radius: 6px;
    }

    .logo-img-table {
        max-width: 120px;
        max-height: 70px;
        object-fit: contain;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        padding: 4px;
        background: white;
    }

    .empty-state {
        text-align: center;
        padding: 30px 20px;
    }

    .empty-icon {
        font-size: 40px;
        margin-bottom: 12px;
        opacity: 0.6;
    }

    .empty-text {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-buttons form {
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .logo-container {
            padding: 24px 16px;
        }

        .logo-title {
            font-size: 24px;
        }

        .card-body {
            padding: 20px;
        }

        .btn-group-custom {
            flex-direction: column-reverse;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .table {
            font-size: 12px;
        }

        .table th,
        .table td {
            padding: 12px 8px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
        }
    }
</style>

<div class="logo-container">
    <!-- Header -->
    <div class="logo-header">
        <h1 class="logo-title">🎨 Logo Management</h1>
        <p class="logo-subtitle">Upload and manage your organization logo</p>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert-success">
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Alert -->
    @if(session('error'))
        <div class="alert-danger">
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Upload/Edit Form Card -->
    <div class="logo-card {{ !$canAdd && !isset($editLogo) ? 'opacity-50' : '' }}">
        <div class="card-header-gradient">
            <h2 class="card-header-title">
                @if(isset($editLogo))
                    <i class="fas fa-pen"></i> Edit Logo
                @else
                    <i class="fas fa-cloud-upload-alt"></i> Upload New Logo
                @endif
                @if(!$canAdd && !isset($editLogo))
                    <span class="badge-limit">Limit Reached</span>
                @endif
            </h2>
        </div>

        <div class="card-body">
            <form action="{{ isset($editLogo) ? route('logo.update', $editLogo->id) : route('logo.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                
                <fieldset {{ !$canAdd && !isset($editLogo) ? 'disabled' : '' }}>
                    <div style="margin-bottom: 24px;">
                        <label for="image" class="form-label">
                            <i class="fas fa-image" style="margin-right: 6px;"></i>Logo Image
                            @if(!isset($editLogo))
                                <span style="color: #ef4444;">*</span>
                            @endif
                            <small>(PNG/SVG recommended - Transparent background)</small>
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
                        
                        <!-- Current Logo Display -->
                        @if(isset($editLogo) && $editLogo->image)
                            <div class="image-preview-box">
                                <span class="preview-label">📌 Current Logo</span>
                                <img src="{{ asset('uploads/logo/' . $editLogo->image) }}" 
                                     alt="Current Logo" 
                                     class="preview-img">
                                <p class="preview-hint">Leave empty to keep current logo</p>
                            </div>
                        @endif
                        
                        <!-- New Logo Preview -->
                        <div class="image-preview-box" id="imagePreview" style="display: none;">
                            <span class="preview-label">✨ Preview</span>
                            <img id="preview" src="" alt="Preview" class="preview-img">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="btn-group-custom">
                        @if(isset($editLogo))
                            <a href="{{ route('logo') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Logo
                            </button>
                        @else
                            <button type="reset" class="btn btn-secondary" onclick="resetPreview()">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary" {{ !$canAdd ? 'disabled' : '' }}>
                                <i class="fas fa-plus"></i> Upload Logo
                            </button>
                        @endif
                    </div>

                    @if(!$canAdd && !isset($editLogo))
                        <div class="disabled-alert">
                            <i class="fas fa-info-circle"></i>
                            <span>Only one logo is allowed. Delete the existing logo to upload a new one.</span>
                        </div>
                    @endif
                </fieldset>
            </form>
        </div>
    </div>

    <!-- Logo List Card -->
    <div class="logo-card">
        <div class="card-header-gradient">
            <h2 class="card-header-title">
                <i class="fas fa-list"></i> Current Logo
            </h2>
        </div>

        <div class="card-body">
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Logo</th>
                            <th style="width: 140px;">Created</th>
                            <th style="width: 160px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logos as $logo)
                        <tr>
                            <td><strong>#{{ $logo->id }}</strong></td>
                            <td>
                                @if($logo->image)
                                    <div class="logo-preview-wrapper">
                                        <img src="{{ asset('uploads/logo/' . $logo->image) }}" 
                                             alt="Logo" 
                                             class="logo-img-table">
                                    </div>
                                @else
                                    <span style="display: inline-block; background: #f3f4f6; padding: 3px 8px; border-radius: 4px; font-size: 11px; color: #6b7280; font-weight: 600;">No Image</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #0a214f; font-size: 12px;">{{ $logo->created_at->format('d M Y') }}</div>
                                <div style="font-size: 11px; color: #6b7280; margin-top: 2px;">{{ $logo->created_at->format('h:i A') }}</div>
                            </td>
                            <td style="text-align: center;">
                                <div class="action-buttons">
                                    <a href="{{ route('logo.edit', $logo->id) }}" 
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('logo.delete', $logo->id) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <p class="empty-text">No logo uploaded yet. Upload one above to get started!</p>
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
            previewDiv.classList.add('active');
        }
        reader.readAsDataURL(file);
    } else {
        previewDiv.style.display = 'none';
        previewDiv.classList.remove('active');
    }
}

function resetPreview() {
    const previewDiv = document.getElementById('imagePreview');
    previewDiv.style.display = 'none';
    previewDiv.classList.remove('active');
    document.getElementById('image').value = '';
}
</script>

@endsection
