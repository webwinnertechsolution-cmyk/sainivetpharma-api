@extends('backend.layouts.layout')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 20px; }

    .page-header { margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 26px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 13px; color: #6b7280; font-weight: 500; }

    .breadcrumb-bar { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 12px; color: #6b7280; }
    .breadcrumb-bar a { color: #1872B5; text-decoration: none; font-weight: 600; }
    .breadcrumb-bar a:hover { text-decoration: underline; }
    .breadcrumb-bar .sep { opacity: 0.4; }

    /* ALERTS */
    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7; color: #065f46;
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

    .card-header-primary {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px; color: #ffffff;
    }

    .card-body { padding: 16px; }

    /* BUTTONS */
    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
    .btn-danger { background: linear-gradient(135deg, #dc2626, #ef4444); color: white; box-shadow: 0 4px 12px rgba(239,68,68,0.3); }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(239,68,68,0.4); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-sm { padding: 4px 9px; font-size: 10px; }

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
    .table tbody tr:hover { background: #f9fafb; transition: background 0.2s; }

    .badge {
        display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 10px;
        font-weight: 600; font-family: 'Sora', sans-serif;
    }
    .badge-primary { background: #dbeafe; color: #1e40af; }
    .badge-success { background: #dcfce7; color: #166534; }
    .badge-secondary { background: #e5e7eb; color: #4b5563; }

    .img-thumbnail {
        border: 1px solid #e5e7eb; border-radius: 6px; padding: 2px; transition: all 0.2s;
    }
    .img-thumbnail:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

    /* EMPTY STATE */
    .empty-state { text-align: center; padding: 40px 20px; color: #9ca3af; }
    .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; color: #d1d5db; opacity: 0.5; }
    .empty-state p { font-size: 13px; }

    /* STATS BAR */
    .stats-bar {
        display: flex; gap: 12px; margin-bottom: 16px; flex-wrap: wrap;
    }
    .stat-pill {
        background: white; border: 1px solid #e5e7eb; border-radius: 8px;
        padding: 8px 14px; font-size: 12px; font-family: 'Sora', sans-serif;
        font-weight: 600; color: #0a214f; display: flex; align-items: center; gap: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .stat-pill .dot { width: 8px; height: 8px; border-radius: 50%; }
    .dot-green { background: #10b981; }
    .dot-gray { background: #9ca3af; }
    .dot-blue { background: #1872B5; }

    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .table { font-size: 11px; }
        .table td, .table th { padding: 8px; }
    }
</style>

<div class="page-container">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-bar">
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span class="sep">›</span>
        <span>Blog Management</span>
    </div>

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-newspaper" style="color: #1872B5;"></i> Blog Management
            </h1>
            <p class="page-subtitle">Manage your blog posts, categories, and tags</p>
        </div>
        <a href="{{ route('blog.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Post
        </a>
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

    {{-- STATS BAR --}}
    @php
        $totalBlogs     = $blogs->count();
        $publishedBlogs = $blogs->where('status', 'published')->count();
        $draftBlogs     = $blogs->where('status', 'draft')->count();
    @endphp
    <div class="stats-bar">
        <div class="stat-pill"><span class="dot dot-blue"></span> Total: {{ $totalBlogs }}</div>
        <div class="stat-pill"><span class="dot dot-green"></span> Published: {{ $publishedBlogs }}</div>
        <div class="stat-pill"><span class="dot dot-gray"></span> Drafts: {{ $draftBlogs }}</div>
    </div>

    {{-- BLOG LIST --}}
    <div class="page-card">
        <div class="card-header-primary">
            <h3 class="card-header-title"><i class="fas fa-list"></i> All Blog Posts</h3>
        </div>
        <div class="card-body">
            @if($blogs->count() > 0)
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th style="width: 100px;">Image</th>
                                <th>Title</th>
                                <th style="width: 140px;">Categories</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 110px;">Published</th>
                                <th style="width: 160px; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                            <tr>
                                <td><strong>#{{ $blog->id }}</strong></td>
                                <td>
                                    @if($blog->featured_image)
                                        <img src="{{ asset('uploads/blogs/' . $blog->featured_image) }}"
                                             alt="{{ $blog->image_alt_tag ?? 'Blog' }}"
                                             style="width: 80px; height: 60px; object-fit: cover; border-radius: 5px;"
                                             class="img-thumbnail">
                                    @else
                                        <span class="badge badge-secondary">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ Str::limit($blog->title, 50) }}</strong><br>
                                    <code style="font-size: 10px; color: #6b7280;">{{ Str::limit($blog->slug, 40) }}</code>
                                </td>
                                <td>
                                    @forelse($blog->categories as $category)
                                        <span class="badge badge-primary">{{ $category->name }}</span><br>
                                    @empty
                                        <span style="font-size: 10px; color: #9ca3af;">—</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if($blog->status === 'published')
                                        <span class="badge badge-success">✅ Published</span>
                                    @else
                                        <span class="badge badge-secondary">📋 Draft</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->published_at)
                                        <small><strong>{{ $blog->published_at->format('d M Y') }}</strong></small><br>
                                        <small style="color: #9ca3af;">{{ $blog->published_at->format('h:i A') }}</small>
                                    @else
                                        <small style="color: #9ca3af;">—</small>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('blog.edit', $blog->id) }}"
                                       class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('blog.delete', $blog->id) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('Delete this blog post?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
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
                    <i class="fas fa-newspaper"></i>
                    <p><strong>No blog posts yet</strong></p>
                    <p style="font-size: 11px; margin-top: 8px;">
                        <a href="{{ route('blog.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create your first post
                        </a>
                    </p>
                </div>
            @endif
        </div>
    </div>

</div>

<script>
// Auto-dismiss alerts
setTimeout(() => {
    document.querySelectorAll('.alert-success, .alert-danger').forEach(el => el.remove());
}, 5000);
</script>

@endsection
