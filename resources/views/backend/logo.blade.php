@extends('backend.layouts.layout')
@section('content')

<div class="container-fluid logo-management-container">
    <div class="row">
        <div class="col-md-12">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="header-content">
                    <h2 class="page-title">
                        <i class="fas fa-image"></i> Logo Management
                    </h2>
                    <p class="page-subtitle">Upload and manage your website logo</p>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                    <div class="alert-content">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                    <div class="alert-content">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Add/Edit Form -->
            <div class="card form-card {{ !$canAdd && !isset($editLogo) ? 'card-disabled' : '' }}">
                <div class="card-header form-header">
                    <div class="header-flex">
                        <h5 class="card-title">
                            <i class="fas {{ isset($editLogo) ? 'fa-edit' : 'fa-plus-circle' }}"></i>
                            {{ isset($editLogo) ? 'Edit Logo' : 'Upload New Logo' }}
                        </h5>
                        @if(!$canAdd && !isset($editLogo))
                            <span class="badge badge-limit">
                                <i class="fas fa-lock"></i> Max Limit Reached
                            </span>
                        @endif
                    </div>
                </div>

                <div class="card-body form-body">
                    <form action="{{ isset($editLogo) ? route('logo.update', $editLogo->id) : route('logo.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          class="logo-form">
                        @csrf
                        
                        <fieldset {{ !$canAdd && !isset($editLogo) ? 'disabled' : '' }}>
                            <div class="form-section">
                                <div class="form-group">
                                    <label for="image" class="form-label">
                                        <span class="label-text">Logo Image</span>
                                        @if(!isset($editLogo))
                                            <span class="required">*</span>
                                        @endif
                                        <small class="label-hint">(PNG, SVG, JPG recommended with transparent background)</small>
                                    </label>

                                    <!-- File Input Area -->
                                    <div class="file-input-wrapper">
                                        <input type="file" 
                                               class="file-input @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*"
                                               {{ !isset($editLogo) ? 'required' : '' }}
                                               onchange="previewImage(event)">
                                        
                                        <label for="image" class="file-input-label">
                                            <div class="upload-icon">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <div class="upload-text">
                                                <p class="upload-main">Drag & drop your logo here</p>
                                                <p class="upload-sub">or click to browse files</p>
                                            </div>
                                        </label>

                                        @error('image')
                                            <div class="error-feedback">
                                                <i class="fas fa-times-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Current Logo Preview -->
                                    @if(isset($editLogo) && $editLogo->image)
                                        <div class="preview-container current-preview">
                                            <div class="preview-header">
                                                <h6 class="preview-title">
                                                    <i class="fas fa-image"></i> Current Logo
                                                </h6>
                                            </div>
                                            <div class="preview-image">
                                                <img src="{{ asset('uploads/logo/' . $editLogo->image) }}" 
                                                     alt="Current Logo">
                                            </div>
                                            <p class="preview-note">Leave file empty to keep current logo</p>
                                        </div>
                                    @endif

                                    <!-- New Logo Preview -->
                                    <div class="preview-container new-preview" id="imagePreview" style="display: none;">
                                        <div class="preview-header">
                                            <h6 class="preview-title">
                                                <i class="fas fa-eye"></i> New Logo Preview
                                            </h6>
                                        </div>
                                        <div class="preview-image">
                                            <img id="preview" src="" alt="Preview">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="form-actions">
                                @if(isset($editLogo))
                                    <a href="{{ route('logo') }}" class="btn btn-secondary btn-cancel">
                                        <i class="fas fa-arrow-left"></i> Back to List
                                    </a>
                                    <button type="submit" class="btn btn-success btn-submit">
                                        <i class="fas fa-save"></i> Update Logo
                                    </button>
                                @else
                                    <button type="reset" class="btn btn-secondary btn-reset" onclick="resetPreview()">
                                        <i class="fas fa-redo"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-submit" {{ !$canAdd ? 'disabled' : '' }}>
                                        <i class="fas fa-upload"></i> Upload Logo
                                    </button>
                                @endif
                            </div>

                            @if(!$canAdd && !isset($editLogo))
                                <div class="alert-info-custom">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Only one logo is allowed. Delete the existing logo to upload a new one.</span>
                                </div>
                            @endif
                        </fieldset>
                    </form>
                </div>
            </div>

            <!-- Logo List -->
            <div class="card list-card mt-4">
                <div class="card-header list-header">
                    <h5 class="card-title">
                        <i class="fas fa-list"></i> Current Logo
                    </h5>
                    <span class="logo-count">{{ $logos->count() }} Logo</span>
                </div>

                <div class="card-body list-body">
                    @if($logos->count() > 0)
                        <div class="table-responsive">
                            <table class="table logo-table">
                                <thead>
                                    <tr>
                                        <th class="col-id">ID</th>
                                        <th class="col-preview">Logo Preview</th>
                                        <th class="col-date">Created At</th>
                                        <th class="col-actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logos as $logo)
                                    <tr>
                                        <td class="col-id">
                                            <span class="logo-id">#{{ $logo->id }}</span>
                                        </td>
                                        <td class="col-preview">
                                            @if($logo->image)
                                                <div class="logo-preview-box">
                                                    <img src="{{ asset('uploads/logo/' . $logo->image) }}" 
                                                         alt="Logo" 
                                                         class="logo-thumbnail">
                                                </div>
                                            @else
                                                <span class="badge-no-image">No Image</span>
                                            @endif
                                        </td>
                                        <td class="col-date">
                                            <div class="date-info">
                                                <span class="date-text">{{ $logo->created_at->format('d M Y') }}</span>
                                                <span class="time-text">{{ $logo->created_at->format('h:i A') }}</span>
                                            </div>
                                        </td>
                                        <td class="col-actions">
                                            <div class="action-buttons">
                                                <a href="{{ route('logo.edit', $logo->id) }}" 
                                                   class="btn btn-sm btn-edit"
                                                   title="Edit Logo">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('logo.delete', $logo->id) }}" 
                                                      method="POST" 
                                                      class="delete-form"
                                                      onsubmit="return confirm('Are you sure you want to delete this logo? This action cannot be undone.');">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-delete"
                                                            title="Delete Logo">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center empty-state">
                                            <div class="empty-state-content">
                                                <div class="empty-icon">
                                                    <i class="fas fa-images"></i>
                                                </div>
                                                <p class="empty-text">No logo found yet</p>
                                                <p class="empty-subtext">Upload your logo above to get started</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state-placeholder">
                            <div class="empty-state-content">
                                <div class="empty-icon">
                                    <i class="fas fa-images"></i>
                                </div>
                                <p class="empty-text">No logo uploaded yet</p>
                                <p class="empty-subtext">Use the form above to upload your first logo</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
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
            // Scroll to preview
            previewDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
        reader.readAsDataURL(file);
    } else {
        previewDiv.style.display = 'none';
    }
}

function resetPreview() {
    const previewDiv = document.getElementById('imagePreview');
    const fileInput = document.getElementById('image');
    previewDiv.style.display = 'none';
    fileInput.value = '';
}

// Drag and drop functionality
const fileInput = document.getElementById('image');
const fileInputWrapper = document.querySelector('.file-input-wrapper');

if (fileInputWrapper) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileInputWrapper.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        fileInputWrapper.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        fileInputWrapper.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        fileInputWrapper.classList.add('highlight');
    }

    function unhighlight(e) {
        fileInputWrapper.classList.remove('highlight');
    }

    fileInputWrapper.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        
        // Trigger preview
        previewImage({ target: { files: files } });
    }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

* {
    font-family: "Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

:root {
    --primary-color: #1872B5;
    --primary-dark: #0a214f;
    --primary-light: #eff6ff;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --info-color: #17a2b8;
    --text-primary: #0a214f;
    --text-secondary: #6b7280;
    --text-muted: #9ca3af;
    --border-color: #dbeafe;
    --bg-light: #f5f7fa;
    --bg-white: #ffffff;
    --shadow-sm: 0 4px 20px rgba(24, 114, 181, 0.08);
    --shadow-md: 0 20px 48px rgba(24, 114, 181, 0.20);
    --transition: all 0.35s cubic-bezier(.4,0,.2,1);
}

.logo-management-container {
    background: #f5f7fa;
    min-height: 100vh;
    padding: 0;
}

/* Page Header */
.page-header {
    position: relative;
    height: 180px;
    background: linear-gradient(135deg, #0a214f 0%, #1872B5 55%, #2596e1 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    padding: 0;
    margin: 0;
    border-radius: 0;
}

.page-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='1.5' fill='rgba(255,255,255,0.08)'/%3E%3C/svg%3E") repeat;
}

.header-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.page-title {
    font-family: 'Sora', sans-serif;
    font-size: 40px;
    font-weight: 800;
    color: #fff;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.25);
}

.page-title i {
    font-size: 44px;
}

.page-subtitle {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.65);
    margin: 8px 0 0 0;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

/* Alert Messages */
.custom-alert {
    border: none;
    border-left: 4px solid var(--primary-color);
    border-radius: 6px;
    padding: 15px 20px;
    margin-bottom: 25px;
    background: rgba(24, 114, 181, 0.05);
}

.custom-alert.alert-success {
    border-left-color: #28a745;
    background: rgba(40, 167, 69, 0.05);
}

.custom-alert.alert-danger {
    border-left-color: #dc3545;
    background: rgba(220, 53, 69, 0.05);
}

.alert-content {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
    font-weight: 600;
    font-size: 14px;
}

.alert-content i {
    font-size: 18px;
    flex-shrink: 0;
}

.custom-alert.alert-success i {
    color: #28a745;
}

.custom-alert.alert-danger i {
    color: #dc3545;
}

/* Cards */
.card {
    border: 1.5px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    border-radius: 18px;
    overflow: hidden;
    transition: var(--transition);
}

.card:hover {
    box-shadow: var(--shadow-md);
    border-color: #bfdbfe;
    transform: translateY(-6px);
}

.card-disabled {
    opacity: 0.6;
    pointer-events: none;
}

.card-header {
    padding: 20px 25px;
    border-bottom: none;
}

.form-header {
    background: linear-gradient(135deg, #1872B5 0%, #0a214f 100%);
    border-bottom: none;
    padding: 22px 25px;
}

.list-header {
    background: linear-gradient(135deg, #1872B5 0%, #0a214f 100%);
    color: var(--bg-white);
}

.header-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.card-title {
    font-family: 'Sora', sans-serif;
    font-size: 18px;
    font-weight: 800;
    margin: 0;
    color: var(--bg-white);
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: -0.02em;
}

.list-header .card-title {
    color: var(--bg-white);
}

.badge-limit {
    background: rgba(255, 255, 255, 0.2);
    color: var(--bg-white);
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.logo-count {
    background: rgba(255, 255, 255, 0.2);
    color: var(--bg-white);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

.card-body {
    padding: 30px;
}

.form-body {
    padding: 30px;
}

/* Form Styles */
.form-section {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    margin-bottom: 10px;
    font-size: 13px;
    font-weight: 700;
    color: var(--text-primary);
    font-family: 'Sora', sans-serif;
}

.label-text {
    display: block;
    margin-bottom: 4px;
}

.required {
    color: var(--danger-color);
    font-weight: 700;
}

.label-hint {
    display: block;
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 400;
    margin-top: 4px;
}

/* File Input */
.file-input-wrapper {
    position: relative;
    margin: 15px 0;
}

.file-input {
    display: none;
}

.file-input-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 45px 30px;
    border: 2px dashed var(--border-color);
    border-radius: 18px;
    background: var(--primary-light);
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
}

.file-input-wrapper.highlight .file-input-label,
.file-input-label:hover {
    border-color: var(--primary-color);
    background: rgba(24, 114, 181, 0.05);
    transform: translateY(-2px);
}

.upload-icon {
    font-size: 48px;
    color: var(--primary-color);
    margin-bottom: 15px;
    transition: var(--transition);
}

.file-input-label:hover .upload-icon {
    transform: scale(1.1);
    color: var(--primary-dark);
}

.upload-main {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
    font-family: 'Sora', sans-serif;
}

.upload-sub {
    font-size: 13px;
    color: var(--text-secondary);
    margin: 4px 0 0 0;
}

.error-feedback {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px;
    margin-top: 10px;
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.3);
    color: #dc3545;
    border-radius: 6px;
    font-size: 13px;
}

/* Previews */
.preview-container {
    margin-top: 25px;
    padding: 20px;
    border-radius: 18px;
    background: var(--primary-light);
    border: 1.5px solid rgba(24, 114, 181, 0.1);
    transition: var(--transition);
}

.preview-container:hover {
    border-color: var(--primary-color);
}

.preview-container.new-preview {
    border-color: var(--warning-color);
    background: rgba(255, 193, 7, 0.05);
}

.preview-header {
    margin-bottom: 15px;
}

.preview-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--primary-color);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-family: 'Sora', sans-serif;
}

.preview-image {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: var(--bg-white);
    border-radius: 6px;
    min-height: 150px;
}

.preview-image img {
    max-width: 100%;
    max-height: 250px;
    object-fit: contain;
    border-radius: 4px;
}

.preview-note {
    font-size: 12px;
    color: var(--text-muted);
    margin: 10px 0 0 0;
    font-style: italic;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.btn {
    padding: 10px 24px;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    font-family: 'Nunito', sans-serif;
}

.btn-primary {
    background: var(--primary-color);
    color: var(--bg-white);
}

.btn-primary:hover:not(:disabled) {
    background: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.btn-primary:disabled {
    background: #cccccc;
    cursor: not-allowed;
    opacity: 0.6;
}

.btn-success {
    background: #28a745;
    color: var(--bg-white);
}

.btn-success:hover {
    background: #218838;
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.btn-secondary {
    background: #6c757d;
    color: var(--bg-white);
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.btn-sm {
    padding: 8px 16px;
    font-size: 13px;
    border-radius: 20px;
}

.btn-edit {
    background: var(--warning-color);
    color: #000;
}

.btn-edit:hover {
    background: #e0a800;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
}

.btn-delete {
    background: var(--danger-color);
    color: var(--bg-white);
}

.btn-delete:hover {
    background: #c82333;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
}

.alert-info-custom {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px 20px;
    margin-top: 20px;
    background: rgba(255, 193, 7, 0.1);
    border: 1px solid rgba(255, 193, 7, 0.3);
    border-radius: 6px;
    color: #856404;
    font-size: 14px;
}

.alert-info-custom i {
    font-size: 16px;
    color: var(--warning-color);
}

/* Table Styles */
.table-responsive {
    border-radius: 6px;
    overflow: hidden;
}

.logo-table {
    margin: 0;
}

.logo-table thead {
    background: rgba(24, 114, 181, 0.05);
}

.logo-table th {
    border: none;
    padding: 15px 20px;
    font-weight: 700;
    color: var(--primary-color);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-family: 'Sora', sans-serif;
}

.logo-table td {
    padding: 18px 20px;
    border-color: var(--border-color);
    vertical-align: middle;
    font-size: 14px;
}

.logo-table tbody tr {
    transition: var(--transition);
}

.logo-table tbody tr:hover {
    background: rgba(24, 114, 181, 0.03);
    border-color: var(--border-color);
}

.col-id {
    width: 80px;
}

.col-preview {
    width: 200px;
}

.col-date {
    width: 150px;
}

.col-actions {
    width: 200px;
}

.logo-id {
    display: inline-block;
    padding: 4px 10px;
    background: rgba(24, 114, 181, 0.1);
    color: var(--primary-color);
    border-radius: 4px;
    font-weight: 700;
    font-size: 12px;
}

.logo-preview-box {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 80px;
    padding: 8px;
    background: var(--primary-light);
    border-radius: 6px;
    border: 1.5px solid rgba(24, 114, 181, 0.1);
}

.logo-thumbnail {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.badge-no-image {
    display: inline-block;
    padding: 6px 12px;
    background: #6c757d;
    color: var(--bg-white);
    border-radius: 4px;
    font-size: 12px;
    font-weight: 700;
}

.date-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.date-text {
    display: block;
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary);
}

.time-text {
    display: block;
    font-size: 12px;
    color: var(--text-muted);
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.delete-form {
    display: inline;
}

/* Empty State */
.empty-state,
.empty-state-placeholder {
    padding: 80px 24px;
    text-align: center;
    background: var(--bg-white);
    border-radius: 18px;
    box-shadow: var(--shadow-sm);
    border: 1.5px solid var(--border-color);
}

.empty-state-content {
    max-width: 400px;
    margin: 0 auto;
}

.empty-icon {
    font-size: 64px;
    color: rgba(24, 114, 181, 0.2);
    margin-bottom: 20px;
}

.empty-text {
    font-size: 20px;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0 0 8px 0;
    font-family: 'Sora', sans-serif;
}

.empty-subtext {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .page-title {
        font-size: 24px;
        gap: 8px;
    }

    .page-title i {
        font-size: 28px;
    }

    .page-subtitle {
        font-size: 11px;
    }

    .page-header {
        height: 155px;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }

    .action-buttons {
        flex-direction: column;
    }

    .action-buttons .btn {
        width: 100%;
    }

    .table-responsive {
        font-size: 12px;
    }

    .logo-table th,
    .logo-table td {
        padding: 12px 10px;
    }

    .col-actions {
        width: 100%;
    }

    .file-input-label {
        padding: 35px 20px;
    }

    .upload-icon {
        font-size: 36px;
    }

    .upload-main {
        font-size: 14px;
    }

    .logo-management-container .row {
        padding: 21px 24px 60px;
    }
}

@media (max-width: 576px) {
    .page-header {
        height: 133px;
    }

    .page-title {
        font-size: 20px;
    }

    .page-subtitle {
        font-size: 10px;
        margin: 0;
    }

    .logo-management-container {
        padding: 0;
    }

    .card-body {
        padding: 20px 15px;
    }

    .header-flex {
        flex-direction: column;
        align-items: flex-start;
    }

    .badge-limit {
        width: 100%;
    }

    .form-label {
        font-size: 12px;
    }

    .file-input-label {
        padding: 30px 15px;
    }

    .preview-container {
        padding: 15px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }

    .logo-management-container .row {
        padding: 15px 15px 60px;
    }
}
</style>

@endsection
