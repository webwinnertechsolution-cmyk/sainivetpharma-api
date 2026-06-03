@extends('backend.layouts.layout')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1200px; margin: 0 auto; padding: 20px; }

    .page-header { margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 13px; color: #6b7280; font-weight: 500; }

    .breadcrumb-bar { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 12px; color: #6b7280; }
    .breadcrumb-bar a { color: #1872B5; text-decoration: none; font-weight: 600; }
    .breadcrumb-bar a:hover { text-decoration: underline; }
    .breadcrumb-bar .sep { opacity: 0.4; }

    /* ALERTS */
    .alert-success {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        border: 1px solid #93c5fd; color: #1e40af;
        padding: 12px 14px; border-radius: 8px; margin-bottom: 16px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px; animation: slideIn 0.3s ease;
    }
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 12px 14px; border-radius: 8px; margin-bottom: 16px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px; animation: slideIn 0.3s ease;
    }
    @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    /* CARDS */
    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }

    .card-header-light {
        background: #f9fafb; padding: 12px 16px;
        border-bottom: 1.5px solid #e5e7eb;
    }
    .card-header-primary {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-purple {
        background: linear-gradient(135deg, #4c1d95, #7c3aed);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-orange {
        background: linear-gradient(135deg, #92400e, #d97706);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px; color: #0a214f;
    }
    .card-header-primary .card-header-title,
    .card-header-purple .card-header-title,
    .card-header-orange .card-header-title { color: #ffffff; }

    .card-body { padding: 16px; }

    /* FORMS */
    .form-label {
        font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700;
        color: #0a214f; margin-bottom: 6px; display: block;
    }
    .form-label small { display: block; font-size: 10px; font-weight: 500; color: #6b7280; margin-top: 2px; }
    .form-control, .form-select {
        border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 8px 10px; font-size: 12px; font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease; width: 100%;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1872B5; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); outline: none;
    }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { color: #ef4444; font-size: 11px; margin-top: 4px; display: block; }
    .form-group { margin-bottom: 12px; }

    /* BUTTONS */
    .btn {
        padding: 8px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary { 
        background: linear-gradient(135deg, #1872B5, #2596e1); 
        color: white; 
        box-shadow: 0 4px 12px rgba(24,114,181,0.3); 
    }
    .btn-primary:hover { 
        transform: translateY(-1px); 
        box-shadow: 0 6px 16px rgba(24,114,181,0.4); 
        color: white; 
    }
    .btn-danger { 
        background: linear-gradient(135deg, #dc2626, #ef4444); 
        color: white; 
        box-shadow: 0 4px 12px rgba(239,68,68,0.3); 
    }
    .btn-danger:hover { 
        transform: translateY(-1px); 
        box-shadow: 0 6px 16px rgba(239,68,68,0.4); 
        color: white; 
    }
    .btn-sm { padding: 5px 10px; font-size: 10px; }
    .btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
    .btn-group { display: flex; gap: 8px; flex-wrap: wrap; }
    .w-100 { width: 100%; }

    /* TABLE */
    .table-wrapper { overflow-x: auto; }
    .table {
        width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 0;
    }
    .table th {
        background: #f9fafb; font-weight: 700; color: #0a214f; padding: 10px 12px;
        border-bottom: 1.5px solid #e5e7eb; text-align: left; font-family: 'Sora', sans-serif;
    }
    .table td {
        padding: 10px 12px; color: #374151; border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background: #f9fafb; transition: background 0.2s;
    }
    .table tbody tr:last-child td { border-bottom: 1px solid #e5e7eb; }

    .badge {
        display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 10px;
        font-weight: 600; font-family: 'Sora', sans-serif;
    }
    .badge-blue { background: #dbeafe; color: #1e40af; }
    .badge-purple { background: #e9d5ff; color: #6b21a8; }
    .badge-orange { background: #fed7aa; color: #92400e; }

    /* EMPTY STATE */
    .empty-state {
        text-align: center; padding: 40px 20px; color: #9ca3af;
    }
    .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; color: #d1d5db; opacity: 0.5; }
    .empty-state p { font-size: 13px; }

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

.form-group label {
    font-size: 12px;
    line-height: 1;
    vertical-align: top;
    margin-bottom: 0.5rem;
}
    /* RESPONSIVE */
    @media (max-width: 768px) {
        .page-title { font-size: 22px; }
        .btn { width: 100%; justify-content: center; }
        .table { font-size: 11px; }
        .table td, .table th { padding: 8px; }
    }

    .text-danger { color: #ef4444; }
    .text-center { text-align: center; }
    code { background: #f1f5f9; padding: 2px 6px; border-radius: 3px; font-size: 11px; color: #1e40af; }
</style>

<div class="page-container">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-bar">
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span class="sep">›</span>
        <span>Blog Tags</span>
    </div>

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-tags" style="color: #7c3aed;"></i> Blog Tags Management
            </h1>
            <p class="page-subtitle">Create and organize blog post tags</p>
        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert-success">
            <span>✅ {{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-danger">
            <span>⚠️ {{ session('error') }}</span>
        </div>
    @endif

    {{-- ADD TAG FORM --}}
    <div class="page-card">
        <div class="card-header-purple">
            <h3 class="card-header-title">
                <i class="fas fa-plus-circle"></i> Add New Tag
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('blog.tag.store') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr auto; gap: 12px; align-items: flex-end;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Tag Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="e.g. Technology, Design, Tutorial"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Tag
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TAGS LIST --}}
    <div class="page-card">
        <div class="card-header-primary">
            <h3 class="card-header-title">
                <i class="fas fa-list"></i> All Tags ({{ $tags->count() }})
            </h3>
        </div>
        <div class="card-body">
            @if($tags->count() > 0)
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th>Tag Name</th>
                                <th style="width: 200px;">Slug</th>
                                <th style="width: 120px; text-align: center;">Posts</th>
                                <th style="width: 120px;">Created</th>
                                <th style="width: 120px; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                            <tr>
                                <td><strong>#{{ $tag->id }}</strong></td>
                                <td>
                                    <strong style="color: #0a214f;">{{ $tag->name }}</strong>
                                </td>
                                <td>
                                    <code>{{ $tag->slug }}</code>
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge badge-blue">
                                        <i class="fas fa-file-alt"></i> {{ $tag->blogs_count ?? 0 }}
                                    </span>
                                </td>
                                <td>
                                    <small style="color: #6b7280;">{{ $tag->created_at->format('d M Y') }}</small>
                                </td>
                                <td style="text-align: center;">
                                    <form action="{{ route('blog.tag.delete', $tag->id) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Delete this tag? It will be removed from all posts.');">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger"
                                                title="Delete tag">
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
                <div class="empty-state">
                    <i class="fas fa-tags"></i>
                    <p><strong>No tags created yet</strong></p>
                    <p style="font-size: 11px; margin-top: 8px;">Add your first tag above to get started organizing your blog posts!</p>
                </div>
            @endif
        </div>
    </div>

</div>

<script>
    // Auto-dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert-success,.alert-danger').forEach(el => el.remove());
    }, 5000);
</script>

@endsection
