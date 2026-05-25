@extends('backend.layouts.layout')
@section('title', 'Page SEO Manager')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Page SEO Manager</h4>
                <a href="{{ route('admin.pageseo.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Add New Page
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Route</th>
                                <th>Slug</th>
                                <th>Meta Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pageSeos as $seo)
                            <tr>
                                <td>{{ $seo->id }}</td>
                                <td>{{ $seo->page_name }}</td>
                                <td><code>{{ $seo->route_name }}</code></td>
                                <td><code>{{ $seo->page_slug }}</code></td>
                                <td>{{ \Illuminate\Support\Str::limit($seo->title, 30) }}</td>
                                <td>
                                    <a href="{{ route('admin.pageseo.edit', $seo->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
