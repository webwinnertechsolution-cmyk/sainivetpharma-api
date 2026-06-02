@extends('backend.layouts.layout')
@section('content')

<!-- Page Banner -->
<div class="logo-banner">
    <div class="logo-banner-content">
        <h1>Logo Management</h1>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

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
            <div class="logo-card mb-4 {{ !$canAdd && !isset($editLogo) ? 'opacity-50' : '' }}">
                <div class="logo-card-header">
                    <h5 class="mb-0" id="formTitle">
                        {{ isset($editLogo) ? 'Edit Logo' : 'Add New Logo' }}
                        @if(!$canAdd && !isset($editLogo))
                            <span class="limit-badge">Limit Reached (Max 1 Logo)</span>
                        @endif
                    </h5>
                </div>
                <div class="logo-card-body">
                    <form action="{{ isset($editLogo) ? route('logo.update', $editLogo->id) : route('logo.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf

                        <fieldset {{ !$canAdd && !isset($editLogo) ? 'disabled' : '' }}>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label for="image" class="form-label logo-label">
                                            Logo Image {{ !isset($editLogo) ? '*' : '' }}
                                            <small class="text-muted">(Recommended: PNG/SVG with transparent background)</small>
                                        </label>
                                        <input type="file" 
                                               class="form-control logo-input @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*"
                                               {{ !isset($editLogo) ? 'required' : '' }}
                                               onchange="previewImage(event)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        @if(isset($editLogo) && $editLogo->image)
                                            <div class="mt-3 p-3 border rounded current-image-box" id="currentImage">
                                                <p class="mb-2 fw-bold" style="color:#30674d;">Current Logo:</p>
                                                <img src="{{ asset('uploads/logo/' . $editLogo->image) }}" 
                                                     alt="Current Logo" 
                                                     class="current-logo-img">
                                                <p class="text-muted small mt-2 mb-0">Leave empty to keep current logo</p>
                                            </div>
                                        @endif

                                        <div class="mt-3 p-3 border rounded preview-box" id="imagePreview" style="display: none;">
                                            <p class="mb-2 fw-bold" style="color:#30674d;">New Logo Preview:</p>
                                            <img id="preview" src="" alt="Preview" class="preview-logo-img">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                @if(isset($editLogo))
                                    <a href="{{ route('logo') }}" class="btn logo-btn-secondary me-md-2">
                                        Cancel Edit
                                    </a>
                                    <button type="submit" class="btn logo-btn-success">
                                        <i class="fas fa-save"></i> Update Logo
                                    </button>
                                @else
                                    <button type="reset" class="btn logo-btn-secondary me-md-2" onclick="resetPreview()">
                                        Reset
                                    </button>
                                    <button type="submit" class="btn logo-btn-primary" {{ !$canAdd ? 'disabled' : '' }}>
                                        <i class="fas fa-plus"></i> Add Logo
                                    </button>
                                @endif
                            </div>
                        </fieldset>

                        @if(!$canAdd && !isset($editLogo))
                            <div class="alert logo-alert-warning mt-3 mb-0">
                                <i class="fas fa-info-circle"></i> Only one logo is allowed. Please delete the existing logo to add a new one.
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Logo List -->
            <div class="logo-card">
                <div class="logo-card-header-dark">
                    <h5 class="mb-0">Current Logo</h5>
                </div>
                <div class="logo-card-body">
                    <div class="table-responsive">
                        <table class="table logo-table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Logo Preview</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logos as $logo)
                                <tr>
                                    <td>{{ $logo->id }}</td>
                                    <td>
                                        @if($logo->image)
                                            <div class="logo-preview-cell">
                                                <img src="{{ asset('uploads/logo/' . $logo->image) }}" 
                                                     alt="Logo" 
                                                     class="logo-table-img">
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $logo->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $logo->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('logo.edit', $logo->id) }}" 
                                           class="btn logo-btn-edit mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('logo.delete', $logo->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this logo?');">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn logo-btn-delete mb-1"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p class="mb-0">No logo found. Upload your logo above!</p>
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

function resetPreview() {
    const previewDiv = document.getElementById('imagePreview');
    previewDiv.style.display = 'none';
}
</script>

<style>
/* Font Family - Inter from Frontend */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

.container-fluid {
    font-family: "Inter", sans-serif;
    max-width: 1200px;
    padding: 0 15px;
}

/* Page Banner - Matches Frontend Blog Banner */
.logo-banner {
    width: 100%;
    height: 107px;
    background: #f0f4f0;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin-bottom: 40px;
}

.logo-banner-content {
    position: relative;
    z-index: 1;
    text-align: center;
}

.logo-banner h1 {
    color: #30674d;
    font-size: 30px;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-family: "Inter", sans-serif;
}

/* Cards - Matches Frontend Blog Cards */
.logo-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    margin-bottom: 30px;
    border: none;
}

.logo-card:hover {
    box-shadow: 0 5px 20px rgba(48, 103, 77, 0.15);
}

.logo-card-header {
    background: #30674d;
    color: #fff;
    padding: 20px 25px;
    border-bottom: none;
}

.logo-card-header h5 {
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 0.5px;
    font-family: "Inter", sans-serif;
}

.logo-card-header-dark {
    background: #234a39;
    color: #fff;
    padding: 20px 25px;
    border-bottom: none;
}

.logo-card-header-dark h5 {
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 0.5px;
    font-family: "Inter", sans-serif;
}

.logo-card-body {
    padding: 25px;
    background: #fff;
}

/* Limit Badge */
.limit-badge {
    background: #f0f4f0;
    color: #234a39;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    margin-left: 10px;
    display: inline-block;
}

/* Form Labels & Inputs */
.logo-label {
    font-family: "Inter", sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.logo-label small {
    font-weight: 400;
    color: #777;
    display: block;
    margin-top: 4px;
    font-size: 12px;
}

.logo-input {
    border: 1px solid #e7e7e7;
    border-radius: 5px;
    padding: 12px 15px;
    font-family: "Inter", sans-serif;
    font-size: 14px;
    transition: all 0.3s;
}

.logo-input:focus {
    border-color: #30674d;
    box-shadow: 0 0 0 3px rgba(48, 103, 77, 0.1);
}

/* Image Preview Boxes */
.current-image-box,
.preview-box {
    background-color: #f8f8f8 !important;
    border: 1px solid #e7e7e7 !important;
    border-radius: 5px;
}

.current-logo-img,
.preview-logo-img {
    max-width: 300px;
    max-height: 200px;
    border: 1px solid #ddd;
    padding: 10px;
    background: white;
    border-radius: 5px;
}

/* Buttons - Frontend Green Theme */
.logo-btn-primary {
    background: #30674d;
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 600;
    font-family: "Inter", sans-serif;
    transition: all 0.3s;
    cursor: pointer;
}

.logo-btn-primary:hover {
    background: #234a39;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(48, 103, 77, 0.25);
    color: #fff;
}

.logo-btn-primary:disabled {
    background: #a0b8a8;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.logo-btn-success {
    background: #30674d;
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 600;
    font-family: "Inter", sans-serif;
    transition: all 0.3s;
    cursor: pointer;
}

.logo-btn-success:hover {
    background: #234a39;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(48, 103, 77, 0.25);
    color: #fff;
}

.logo-btn-secondary {
    background: #f0f4f0;
    color: #30674d;
    border: 1px solid #30674d;
    padding: 10px 24px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 600;
    font-family: "Inter", sans-serif;
    transition: all 0.3s;
    cursor: pointer;
    text-decoration: none;
}

.logo-btn-secondary:hover {
    background: #30674d;
    color: #fff;
    transform: translateY(-2px);
}

/* Table Buttons */
.logo-btn-edit {
    background: #f0f4f0;
    color: #30674d;
    border: 1px solid #30674d;
    padding: 6px 14px;
    border-radius: 5px;
    font-size: 13px;
    font-weight: 500;
    font-family: "Inter", sans-serif;
    transition: all 0.3s;
    text-decoration: none;
}

.logo-btn-edit:hover {
    background: #30674d;
    color: #fff;
    transform: translateY(-2px);
}

.logo-btn-delete {
    background: #fff;
    color: #dc3545;
    border: 1px solid #dc3545;
    padding: 6px 14px;
    border-radius: 5px;
    font-size: 13px;
    font-weight: 500;
    font-family: "Inter", sans-serif;
    transition: all 0.3s;
}

.logo-btn-delete:hover {
    background: #dc3545;
    color: #fff;
    transform: translateY(-2px);
}

/* Table Styling */
.logo-table {
    font-family: "Inter", sans-serif;
    border-collapse: separate;
    border-spacing: 0;
}

.logo-table thead th {
    background: #f8f8f8;
    color: #30674d;
    font-weight: 600;
    font-size: 14px;
    padding: 15px;
    border-bottom: 2px solid #30674d;
    border-top: none;
}

.logo-table tbody td {
    padding: 15px;
    vertical-align: middle;
    font-size: 14px;
    color: #333;
    border-bottom: 1px solid #f0f0f0;
}

.logo-table tbody tr:hover {
    background: #f8f9fa;
}

/* Logo Preview in Table */
.logo-preview-cell {
    background-color: #f8f9fa;
    display: inline-block;
    padding: 15px;
    border-radius: 5px;
    border: 1px solid #e7e7e7;
}

.logo-table-img {
    max-width: 200px;
    max-height: 100px;
    object-fit: contain;
    border-radius: 5px;
    background: white;
    padding: 5px;
}

/* Empty State */
.empty-state {
    color: #aaa;
    font-family: "Inter", sans-serif;
}

.empty-state i {
    color: #30674d;
    opacity: 0.3;
}

/* Alert Styling */
.logo-alert-warning {
    background: #f0f4f0;
    border: 1px solid #30674d;
    color: #234a39;
    border-radius: 5px;
    padding: 12px 15px;
    font-family: "Inter", sans-serif;
    font-size: 14px;
}

.logo-alert-warning i {
    color: #30674d;
    margin-right: 8px;
}

/* Opacity for disabled state */
.opacity-50 {
    opacity: 0.6;
    pointer-events: none;
}

/* Responsive */
@media (max-width: 767px) {
    .logo-banner {
        height: 95px;
    }

    .logo-banner h1 {
        font-size: 22px;
    }

    .logo-card-header,
    .logo-card-header-dark {
        padding: 15px 20px;
    }

    .logo-card-body {
        padding: 20px 15px;
    }

    .logo-table thead th,
    .logo-table tbody td {
        padding: 10px;
        font-size: 13px;
    }

    .logo-btn-primary,
    .logo-btn-success,
    .logo-btn-secondary {
        padding: 8px 16px;
        font-size: 13px;
    }

    .current-logo-img,
    .preview-logo-img {
        max-width: 100%;
    }
}
</style>

@endsection
