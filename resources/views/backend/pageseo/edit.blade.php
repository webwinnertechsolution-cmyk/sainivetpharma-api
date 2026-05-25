@extends('backend.layouts.layout')
@section('title', 'Edit Page SEO')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit SEO for: {{ $pageSeo->page_name }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pageseo.update', $pageSeo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title', $pageSeo->title) }}">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description', $pageSeo->meta_description) }}</textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="route_name" class="form-label">Page Type (Route)</label>
                            <input type="text" class="form-control" id="route_name" name="route_name" value="{{ $pageSeo->route_name }}" readonly>
                            <small class="text-muted">Page Type cannot be changed once created.</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="page_slug" class="form-label">Page Slug</label>
                            <input type="text" class="form-control" id="page_slug" name="page_slug" value="{{ old('page_slug', $pageSeo->page_slug) }}">
                            <small class="text-muted">Optional. Identify specific page for dynamic usage (e.g. 3d-scanning).</small>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords" value="{{ old('meta_keywords', $pageSeo->meta_keywords) }}">
                            <small class="text-muted">Comma separated keywords</small>
                        </div>
                    </div>
                    
                    <hr>
                    <h5>Open Graph (Social Media)</h5>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="og_title" class="form-label">OG Title</label>
                            <input type="text" class="form-control" name="og_title" value="{{ old('og_title', $pageSeo->og_title) }}">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="og_description" class="form-label">OG Description</label>
                            <textarea class="form-control" name="og_description" rows="3">{{ old('og_description', $pageSeo->og_description) }}</textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="og_image" class="form-label">OG Image</label>
                            <input type="file" class="form-control" name="og_image">
                            @if($pageSeo->og_image)
                                <div class="mt-2">
                                    <img src="{{ asset('public/uploads/pages/' . $pageSeo->og_image) }}" alt="OG Image" style="height: 100px; width: auto;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update SEO Settings</button>
                    <a href="{{ route('admin.pageseo.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
