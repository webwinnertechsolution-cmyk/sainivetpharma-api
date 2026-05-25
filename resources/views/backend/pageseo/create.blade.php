@extends('backend.layouts.layout')
@section('title', 'Add New Page SEO')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add New Page SEO</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pageseo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="page_name" class="form-label">Page Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="page_name" value="{{ old('page_name') }}" placeholder="e.g. About Us" required>
                            <small class="text-muted">Friendly name for the admin panel.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="route_name" class="form-label">Page Type (Route) <span class="text-danger">*</span></label>
                            <select class="form-control" name="route_name" required>
                                <option value="" disabled selected>Select Page Type</option>
                                <option value="home">Home Page</option>
                                <option value="about">About Us</option>
                                <option value="contact">Contact Us</option>
                                <option value="services.wear-liners">Service: Wear Liners</option>
                                <option value="services.conveyor-guards">Service: Conveyor Guards</option>
                                <option value="service.detail">Service Detail (Dynamic)</option>
                                <option value="frontend.blog">Blog Index</option>
                                <option value="industries">Industries</option>
                                <option value="faq">FAQ</option>
                                <option value="shop">Shop</option>
                                <option value="shop-new">Shop New</option>
                            </select>
                            <small class="text-muted">Select the type of page you are adding SEO for.</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="page_slug" class="form-label">Page Slug (for Dynamic Pages)</label>
                            <input type="text" class="form-control" id="page_slug" name="page_slug" placeholder="e.g. 3d-scanning">
                            <small class="text-muted">Required ONLY if you selected "Service Detail" or similar dynamic routes. Leave empty for static pages.</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords" value="{{ old('meta_keywords') }}">
                            <small class="text-muted">Comma separated keywords</small>
                        </div>
                    </div>
                    
                    <hr>
                    <h5>Open Graph (Social Media)</h5>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="og_title" class="form-label">OG Title</label>
                            <input type="text" class="form-control" name="og_title" value="{{ old('og_title') }}">
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="og_description" class="form-label">OG Description</label>
                            <textarea class="form-control" name="og_description" rows="3">{{ old('og_description') }}</textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="og_image" class="form-label">OG Image</label>
                            <input type="file" class="form-control" name="og_image">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Page SEO</button>
                    <a href="{{ route('admin.pageseo.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
