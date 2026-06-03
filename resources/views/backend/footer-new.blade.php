@extends('backend.layouts.layout')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1100px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 12px; color: #6b7280; font-weight: 500; }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7; color: #065f46;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px;
    }
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 12px;
    }

    /* Cards */
    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }

    /* Column card accent borders */
    .page-card.col1 { border-left: 4px solid #1872B5; }
    .page-card.col2 { border-left: 4px solid #059669; }
    .page-card.col3 { border-left: 4px solid #d97706; }

    /* Header variants */
    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-green {
        background: linear-gradient(135deg, #065f46 0%, #059669 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-amber {
        background: linear-gradient(135deg, #92400e 0%, #d97706 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }

    /* Section sub-headers inside card body */
    .section-subheader {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        padding: 7px 16px; color: #fff;
        margin: 14px -16px 14px; display: flex; align-items: center; gap: 6px;
        font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
        letter-spacing: 0.05em; text-transform: uppercase;
    }

    .card-body { padding: 16px; }

    /* Form elements */
    .form-label {
        font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700;
        color: #0a214f; margin-bottom: 6px; display: block;
    }
    .form-label small { display: block; font-size: 10px; font-weight: 500; color: #6b7280; margin-top: 2px; }

    .form-control, .form-select {
        border: 1.5px solid #e5e7eb; border-radius: 6px;
        padding: 7px 10px; font-size: 12px; font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease; width: 100%;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1872B5; box-shadow: 0 0 0 3px rgba(24,114,181,0.1); outline: none;
    }
    textarea.form-control { resize: vertical; }
    .form-group { margin-bottom: 12px; }

    hr { border: none; border-top: 1px solid #e5e7eb; margin: 14px 0; }

    /* Two col grid */
    .two-col-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 16px; }

    /* Social rows */
    .social-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .social-row { display: flex; align-items: center; gap: 8px; }
    .social-icon {
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
        border-radius: 50%; color: #fff; font-size: 13px; flex-shrink: 0;
    }
    .social-icon.fb  { background: #1877f2; }
    .social-icon.ig  { background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); }
    .social-icon.tw  { background: #000; }
    .social-icon.yt  { background: #ff0000; }
    .social-icon.li  { background: #0a66c2; }
    .social-icon.wa  { background: #25d366; }

    /* Links */
    .link-row { display: flex; gap: 8px; margin-bottom: 8px; align-items: center; }
    .btn-remove-link { flex-shrink: 0; }

    /* Logo preview */
    .logo-preview {
        display: inline-flex; align-items: center; gap: 8px;
        background: #f9fafb; border: 1.5px solid #e5e7eb;
        border-radius: 8px; padding: 8px 12px; margin-bottom: 8px;
    }
    .logo-preview img { max-height: 50px; max-width: 140px; object-fit: contain; }
    .remove-label { font-size: 10px; color: #ef4444; display: flex; align-items: center; gap: 4px; cursor: pointer; font-family: 'Sora', sans-serif; font-weight: 700; }

    /* Buttons */
    .btn {
        padding: 7px 14px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 11px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-primary   { background: linear-gradient(135deg, #1872B5, #2596e1); color: white; box-shadow: 0 4px 12px rgba(24,114,181,0.3); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(24,114,181,0.4); color: white; }
    .btn-success   { background: linear-gradient(135deg, #065f46, #059669); color: white; box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
    .btn-success:hover { transform: translateY(-1px); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); color: #1f2937; }
    .btn-danger    { background: linear-gradient(135deg, #ef4444, #f87171); color: white; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); color: white; }
    .btn-outline-danger { background: transparent; border: 1.5px solid #ef4444; color: #ef4444; }
    .btn-outline-danger:hover { background: #ef4444; color: white; transform: translateY(-1px); }
    .btn-sm { padding: 4px 9px; font-size: 10px; }
    .btn-add-link { background: linear-gradient(135deg, #065f46, #059669); color: white; box-shadow: 0 4px 12px rgba(5,150,105,0.25); }
    .btn-add-link:hover { transform: translateY(-1px); color: white; }

    .btn-group-custom { display: flex; gap: 8px; margin-top: 6px; justify-content: flex-end; flex-wrap: wrap; }

    /* Column label badge */
    .col-badge {
        font-size: 10px; background: rgba(255,255,255,0.2); color: #fff;
        padding: 2px 8px; border-radius: 20px; font-weight: 700;
        font-family: 'Sora', sans-serif;
    }
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }

    @media (max-width: 768px) {
        .two-col-grid { grid-template-columns: 1fr; }
        .social-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 480px) {
        .social-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">🦶 Footer Management</h1>
        <p class="page-subtitle">Manage footer columns — logo, social media, links &amp; content</p>
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

    <form action="{{ $footer ? route('footer.new.update', $footer->id) : route('footer.new.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ══════════════════════════════════════
             COLUMN 1 — Logo + Content + Social
        ════════════════════════════════════════ --}}
        <div class="page-card col1">
            <div class="card-header-gradient">
                <div class="card-header-row">
                    <h2 class="card-header-title">
                        <i class="fas fa-image"></i> Column 1 — Logo, Content &amp; Social Media
                    </h2>
                    <span class="col-badge">COL 1</span>
                </div>
            </div>
            <div class="card-body">

                <div class="two-col-grid">

                    {{-- Logo --}}
                    <div>
                        <div class="form-group">
                            <label class="form-label">
                                Footer Logo
                                <small>PNG/SVG recommended (transparent bg)</small>
                            </label>
                            @if($footer && $footer->col1_logo)
                                <div class="logo-preview">
                                    <img src="{{ asset('uploads/footer/' . $footer->col1_logo) }}"
                                         alt="{{ $footer->col1_logo_alt }}">
                                    <label class="remove-label">
                                        <input type="checkbox" name="remove_logo" value="1">
                                        Remove
                                    </label>
                                </div>
                            @endif
                            <input type="file" name="col1_logo" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Logo Alt Tag</label>
                            <input type="text" name="col1_logo_alt" class="form-control"
                                   value="{{ old('col1_logo_alt', $footer->col1_logo_alt ?? '') }}"
                                   placeholder="Company Logo">
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="form-group">
                        <label class="form-label">
                            Content / Description
                            <small>Basic HTML allowed (e.g. &lt;br&gt;, &lt;strong&gt;)</small>
                        </label>
                        <textarea name="col1_content" class="form-control" rows="6"
                                  placeholder="Tagline ya short description...">{{ old('col1_content', $footer->col1_content ?? '') }}</textarea>
                    </div>

                </div>

                {{-- Social Media --}}
                <div class="section-subheader">
                    <i class="fas fa-share-alt"></i> Social Media Links
                </div>

                <div class="social-grid">
                    <div class="social-row">
                        <div class="social-icon fb"><i class="fab fa-facebook-f"></i></div>
                        <input type="url" name="col1_social_facebook" class="form-control"
                               value="{{ old('col1_social_facebook', $footer->col1_social_facebook ?? '') }}"
                               placeholder="https://facebook.com/yourpage">
                    </div>
                    <div class="social-row">
                        <div class="social-icon ig"><i class="fab fa-instagram"></i></div>
                        <input type="url" name="col1_social_instagram" class="form-control"
                               value="{{ old('col1_social_instagram', $footer->col1_social_instagram ?? '') }}"
                               placeholder="https://instagram.com/yourpage">
                    </div>
                    <div class="social-row">
                        <div class="social-icon tw"><i class="fab fa-x-twitter"></i></div>
                        <input type="url" name="col1_social_twitter" class="form-control"
                               value="{{ old('col1_social_twitter', $footer->col1_social_twitter ?? '') }}"
                               placeholder="https://x.com/yourpage">
                    </div>
                    <div class="social-row">
                        <div class="social-icon yt"><i class="fab fa-youtube"></i></div>
                        <input type="url" name="col1_social_youtube" class="form-control"
                               value="{{ old('col1_social_youtube', $footer->col1_social_youtube ?? '') }}"
                               placeholder="https://youtube.com/@yourchannel">
                    </div>
                    <div class="social-row">
                        <div class="social-icon li"><i class="fab fa-linkedin-in"></i></div>
                        <input type="url" name="col1_social_linkedin" class="form-control"
                               value="{{ old('col1_social_linkedin', $footer->col1_social_linkedin ?? '') }}"
                               placeholder="https://linkedin.com/company/...">
                    </div>
                    <div class="social-row">
                        <div class="social-icon wa"><i class="fab fa-whatsapp"></i></div>
                        <input type="text" name="col1_social_whatsapp" class="form-control"
                               value="{{ old('col1_social_whatsapp', $footer->col1_social_whatsapp ?? '') }}"
                               placeholder="+91 9876543210">
                    </div>
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════════════
             COLUMN 2 — Heading + Quick Links
        ════════════════════════════════════════ --}}
        <div class="page-card col2">
            <div class="card-header-green">
                <div class="card-header-row">
                    <h2 class="card-header-title">
                        <i class="fas fa-list"></i> Column 2 — Heading &amp; Quick Links
                    </h2>
                    <span class="col-badge">COL 2</span>
                </div>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label class="form-label">Column Heading</label>
                    <input type="text" name="col2_heading" class="form-control"
                           value="{{ old('col2_heading', $footer->col2_heading ?? '') }}"
                           placeholder="e.g. Quick Links">
                </div>

                <div class="section-subheader" style="background: linear-gradient(135deg,#065f46,#059669);">
                    <i class="fas fa-link"></i> Links List
                    <span style="font-size:10px;font-weight:500;opacity:0.85;margin-left:4px;">— Title aur URL dalo, jitne chahein utne add karo</span>
                </div>

                <div id="links-container">
                    @php
                        $existingLinks = $footer && $footer->col2_links ? $footer->col2_links : [['title'=>'','url'=>'']];
                    @endphp
                    @foreach($existingLinks as $i => $link)
                    <div class="link-row">
                        <input type="text" name="link_title[]" class="form-control"
                               value="{{ old('link_title.' . $i, $link['title'] ?? '') }}"
                               placeholder="Link Title (e.g. About Us)">
                        <input type="text" name="link_url[]" class="form-control"
                               value="{{ old('link_url.' . $i, $link['url'] ?? '') }}"
                               placeholder="URL (e.g. /about)">
                        <button type="button" class="btn btn-danger btn-sm btn-remove-link" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-add-link btn-sm mt-2" id="btn-add-link">
                    <i class="fas fa-plus"></i> Add Link
                </button>

            </div>
        </div>

        {{-- ══════════════════════════════════════
             COLUMN 3 — Heading + Content
        ════════════════════════════════════════ --}}
        <div class="page-card col3">
            <div class="card-header-amber">
                <div class="card-header-row">
                    <h2 class="card-header-title">
                        <i class="fas fa-align-left"></i> Column 3 — Heading &amp; Content
                    </h2>
                    <span class="col-badge">COL 3</span>
                </div>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label class="form-label">Column Heading</label>
                    <input type="text" name="col3_heading" class="form-control"
                           value="{{ old('col3_heading', $footer->col3_heading ?? '') }}"
                           placeholder="e.g. Contact Us">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Content
                        <small>HTML allowed — address, phone, email, etc.</small>
                    </label>
                    <textarea name="col3_content" class="form-control tinymce-editor" rows="6"
                              placeholder="Address, phone, email ya kuch bhi...">{{ old('col3_content', $footer->col3_content ?? '') }}</textarea>
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════════════
             Submit Buttons
        ════════════════════════════════════════ --}}
        <div class="btn-group-custom" style="margin-bottom: 32px;">
            @if($footer)
                <button type="button" class="btn btn-outline-danger"
                    onclick="if(confirm('Delete footer? Yeh action undo nahi hogi!')) { document.getElementById('delete-footer-form').submit(); }">
                    <i class="fas fa-trash"></i> Delete Footer
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Footer
                </button>
            @else
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Footer
                </button>
            @endif
        </div>

    </form>

    {{-- Hidden delete form --}}
    @if($footer)
    <form id="delete-footer-form" action="{{ route('footer.new.delete', $footer->id) }}" method="POST" class="d-none">
        @csrf
    </form>
    @endif

</div>
@endsection

@push('scripts')
<script>
document.getElementById('btn-add-link').addEventListener('click', function () {
    const container = document.getElementById('links-container');
    const row = document.createElement('div');
    row.className = 'link-row';
    row.innerHTML = `
        <input type="text" name="link_title[]" class="form-control" placeholder="Link Title (e.g. About Us)">
        <input type="text" name="link_url[]" class="form-control" placeholder="URL (e.g. /about)">
        <button type="button" class="btn btn-danger btn-sm btn-remove-link" title="Remove">
            <i class="fas fa-times"></i>
        </button>`;
    container.appendChild(row);
});

document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-remove-link')) {
        const row = e.target.closest('.link-row');
        const container = document.getElementById('links-container');
        if (container.querySelectorAll('.link-row').length > 1) {
            row.remove();
        } else {
            row.querySelectorAll('input').forEach(i => i.value = '');
        }
    }
});

setTimeout(() => {
    document.querySelectorAll('.alert-success, .alert-danger').forEach(el => el.remove());
}, 5000);
</script>
@endpush
