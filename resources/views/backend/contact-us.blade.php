@extends('backend.layouts.layout')
@section('title', 'Contact Us')
@section('content')

<div class="container-fluid">
<div class="row">
<div class="col-12">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">📞 Contact Us Page</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">

        {{-- FORM --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">{{ $contactUs ? '✏️ Edit Contact Us' : '➕ Add Contact Us' }}</h5>
                </div>
                <div class="card-body">

                    @if($contactUs)
                        <form action="{{ route('contact.us.update', $contactUs->id) }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('contact.us.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                    @csrf

                    {{-- Headings --}}
                   {{-- Headings --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Page Heading</label>
        <input type="text" name="page_heading" class="form-control"
            value="{{ old('page_heading', $contactUs->page_heading ?? '') }}"
            placeholder="e.g. Contact Us">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Pre Heading <small class="text-muted">(Contact Details)</small></label>
        <input type="text" name="pre_heading" class="form-control"
            value="{{ old('pre_heading', $contactUs->pre_heading ?? '') }}"
            placeholder="e.g. Contact Details">
    </div>
</div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="sub_heading" class="form-control" rows="2"
                            placeholder="e.g. Have a question or need assistance?...">{{ old('sub_heading', $contactUs->sub_heading ?? '') }}</textarea>
                    </div>

                    <hr>

                    {{-- Contact Info --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $contactUs->phone ?? '') }}"
                                placeholder="e.g. +91 98765 43210">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="text" name="email" class="form-control"
                                value="{{ old('email', $contactUs->email ?? '') }}"
                                placeholder="e.g. info@example.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Address</label>
                        <textarea name="address" class="form-control" rows="2"
                            placeholder="e.g. 57, Block B, South Ex. Part II, New Delhi">{{ old('address', $contactUs->address ?? '') }}</textarea>
                    </div>

                    <hr>

                    {{-- Image --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contact Page Image</label>
                        @if($contactUs && $contactUs->image)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/contact-us/' . $contactUs->image) }}"
                                    style="height:100px;border-radius:6px;border:1px solid #ddd;" alt="Current Image">
                                <small class="text-muted d-block mt-1">Current image</small>
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Image Alt Tag</label>
                        <input type="text" name="image_alt" class="form-control"
                            value="{{ old('image_alt', $contactUs->image_alt ?? '') }}"
                            placeholder="Image description for SEO">
                    </div>

                    <hr>

                    {{-- Map --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Google Map Embed URL</label>
                        <small class="text-muted d-block mb-1">
                            Google Maps → Share → Embed a map → sirf <code>src="..."</code> ki value paste karo
                        </small>
                        <textarea name="map_embed" class="form-control" rows="3"
                            placeholder="https://www.google.com/maps/embed?pb=...">{{ old('map_embed', $contactUs->map_embed ?? '') }}</textarea>
                    </div>

                    {{-- Map Preview --}}
                    @if($contactUs && $contactUs->map_embed)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Map Preview</label>
                            <iframe src="{{ $contactUs->map_embed }}"
                                width="100%" height="250" style="border:0;border-radius:8px;" allowfullscreen loading="lazy">
                            </iframe>
                        </div>
                    @endif

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            {{ $contactUs ? '💾 Update' : '➕ Save' }}
                        </button>
                        @if($contactUs)
                            <form action="{{ route('contact.us.delete', $contactUs->id) }}" method="POST"
                                onsubmit="return confirm('Delete karna chahte ho?')" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">🗑️ Delete</button>
                            </form>
                        @endif
                    </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- INFO CARD --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">📋 Current Data</h5>
                </div>
                <div class="card-body">
                    @if($contactUs)
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th>Page Heading</th>
                                <td>{{ $contactUs->page_heading ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pre Heading</th>
                                <td>{{ $contactUs->pre_heading ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $contactUs->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $contactUs->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $contactUs->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Map</th>
                                <td>{{ $contactUs->map_embed ? '✅ Set' : '❌ Not Set' }}</td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td>{{ $contactUs->image ? '✅ Set' : '❌ Not Set' }}</td>
                            </tr>
                        </table>
                    @else
                        <div class="text-center text-muted py-4">
                            <p>Abhi koi data nahi hai.</p>
                            <p>Form fill karke save karo.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-header">
                    <h6 class="mb-0">💡 API Endpoint</h6>
                </div>
                <div class="card-body">
                    <code style="font-size:12px;background:#f0f4f8;padding:6px 12px;border-radius:6px;display:block;">
                        /api/contact-us
                    </code>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>

@endsection