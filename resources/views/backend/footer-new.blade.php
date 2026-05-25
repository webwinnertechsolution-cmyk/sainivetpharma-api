@extends('backend.layouts.layout')

@push('styles')
<style>
.social-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
.social-row .social-icon { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #fff; font-size: 16px; flex-shrink: 0; }
.social-row .social-icon.fb  { background: #1877f2; }
.social-row .social-icon.ig  { background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); }
.social-row .social-icon.tw  { background: #000; }
.social-row .social-icon.yt  { background: #ff0000; }
.social-row .social-icon.li  { background: #0a66c2; }
.social-row .social-icon.wa  { background: #25d366; }
.link-row { display: flex; gap: 8px; margin-bottom: 8px; align-items: center; }
.link-row .btn-remove-link { flex-shrink: 0; }
#links-container .link-row:last-child { margin-bottom: 0; }
.col-card { border-left: 4px solid; border-radius: 6px; margin-bottom: 20px; }
.col-card.col1 { border-color: #0d6efd; }
.col-card.col2 { border-color: #198754; }
.col-card.col3 { border-color: #fd7e14; }
.col-card.col4 { border-color: #dc3545; }
.col-card .card-header { background: #f8f9fa; font-weight: 600; }
#footer {
    background-color: #30674d!important;
    color: #cacaca;
    padding: 100px 0 60px;
    border-style: solid;
    position: relative;
    font-size: 15px;
    line-height: 27px;
}
.footer-new-col {
    width: 58%;
    padding: 0 15px 40px;
    box-sizing: border-box;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="d-flex align-items-center mb-4 gap-3">
                <h2 class="mb-0">Footer Management</h2>
                <span class="badge bg-info text-dark">4 Columns Footer</span>
            </div>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ── FORM ─────────────────────────────────────────────── --}}
            <form action="{{ $footer ? route('footer.new.update', $footer->id) : route('footer.new.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- ═══════════════════════════════════════════════════
                     COLUMN 1  – Logo + Content + Social Media
                ════════════════════════════════════════════════════ --}}
                <div class="card col-card col1">
                    <div class="card-header">
                        <i class="fas fa-image text-primary me-2"></i>Column 1 — Logo, Content &amp; Social Media
                    </div>
                    <div class="card-body">
                        <div class="row">

                            {{-- Logo --}}
                            <div class="col-md-4 sdfgsdg">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Footer Logo</label>
                                    @if($footer && $footer->col1_logo)
                                        <div class="mb-2 p-2 border rounded d-inline-flex align-items-center gap-2">
                                            <img src="{{ asset('uploads/footer/' . $footer->col1_logo) }}"
                                                 alt="{{ $footer->col1_logo_alt }}"
                                                 style="max-height:60px; max-width:160px; object-fit:contain;">
                                            <label class="mb-0 text-danger d-flex align-items-center gap-1" style="cursor:pointer;">
                                                <input type="checkbox" name="remove_logo" value="1">
                                                <small>Remove</small>
                                            </label>
                                        </div>
                                    @endif
                                    <input type="file" name="col1_logo" class="form-control" accept="image/*">
                                    <small class="text-muted">PNG/SVG recommended (transparent background)</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Logo Alt Tag</label>
                                    <input type="text" name="col1_logo_alt" class="form-control"
                                           value="{{ old('col1_logo_alt', $footer->col1_logo_alt ?? '') }}"
                                           placeholder="Company Logo">
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Content / Description</label>
                                    <textarea name="col1_content" class="form-control" rows="4"
                                              placeholder="Tagline ya short description likho...">{{ old('col1_content', $footer->col1_content ?? '') }}</textarea>
                                    <small class="text-muted">Basic HTML allowed (e.g. &lt;br&gt;, &lt;strong&gt;)</small>
                                </div>
                            </div>

                            {{-- Social Media --}}
                            <div class="col-12">
                                <hr>
                                <h6 class="fw-semibold mb-3"><i class="fas fa-share-alt me-2 text-primary"></i>Social Media Links</h6>
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <div class="social-row">
                                            <div class="social-icon fb"><i class="fab fa-facebook-f"></i></div>
                                            <input type="url" name="col1_social_facebook" class="form-control"
                                                   value="{{ old('col1_social_facebook', $footer->col1_social_facebook ?? '') }}"
                                                   placeholder="https://facebook.com/yourpage">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="social-row">
                                            <div class="social-icon ig"><i class="fab fa-instagram"></i></div>
                                            <input type="url" name="col1_social_instagram" class="form-control"
                                                   value="{{ old('col1_social_instagram', $footer->col1_social_instagram ?? '') }}"
                                                   placeholder="https://instagram.com/yourpage">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="social-row">
                                            <div class="social-icon tw"><i class="fab fa-x-twitter"></i></div>
                                            <input type="url" name="col1_social_twitter" class="form-control"
                                                   value="{{ old('col1_social_twitter', $footer->col1_social_twitter ?? '') }}"
                                                   placeholder="https://x.com/yourpage">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="social-row">
                                            <div class="social-icon yt"><i class="fab fa-youtube"></i></div>
                                            <input type="url" name="col1_social_youtube" class="form-control"
                                                   value="{{ old('col1_social_youtube', $footer->col1_social_youtube ?? '') }}"
                                                   placeholder="https://youtube.com/@yourchannel">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="social-row">
                                            <div class="social-icon li"><i class="fab fa-linkedin-in"></i></div>
                                            <input type="url" name="col1_social_linkedin" class="form-control"
                                                   value="{{ old('col1_social_linkedin', $footer->col1_social_linkedin ?? '') }}"
                                                   placeholder="https://linkedin.com/company/yourcompany">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="social-row">
                                            <div class="social-icon wa"><i class="fab fa-whatsapp"></i></div>
                                            <input type="text" name="col1_social_whatsapp" class="form-control"
                                                   value="{{ old('col1_social_whatsapp', $footer->col1_social_whatsapp ?? '') }}"
                                                   placeholder="+91 9876543210 (number only)">
                                        </div>
                                    </div>

                                </div>{{-- /row social --}}
                            </div>

                        </div>{{-- /row --}}
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════
                     COLUMN 2  – Heading + Quick Links List
                ════════════════════════════════════════════════════ --}}
                <div class="card col-card col2">
                    <div class="card-header">
                        <i class="fas fa-list text-success me-2"></i>Column 2 — Heading &amp; Quick Links
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Column Heading</label>
                            <input type="text" name="col2_heading" class="form-control"
                                   value="{{ old('col2_heading', $footer->col2_heading ?? '') }}"
                                   placeholder="e.g. Quick Links">
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-semibold">Links List</label>
                            <small class="text-muted ms-2">Title aur URL dalo, jitne chahein utne add karo</small>
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

                        <button type="button" class="btn btn-success btn-sm mt-2" id="btn-add-link">
                            <i class="fas fa-plus me-1"></i> Add Link
                        </button>

                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════
                     COLUMN 3  – Heading + Content
                ════════════════════════════════════════════════════ --}}
                <div class="card col-card col3">
                    <div class="card-header">
                        <i class="fas fa-align-left text-warning me-2"></i>Column 3 — Heading &amp; Content
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Column Heading</label>
                            <input type="text" name="col3_heading" class="form-control"
                                   value="{{ old('col3_heading', $footer->col3_heading ?? '') }}"
                                   placeholder="e.g. Contact Us">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Content</label>
                            <textarea name="col3_content" class="form-control tinymce-editor" rows="6"
                                      placeholder="Address, phone, email ya kuch bhi...">{{ old('col3_content', $footer->col3_content ?? '') }}</textarea>
                            <small class="text-muted">HTML allowed — address, phone, email, etc.</small>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════
                     COLUMN 4  – Heading + Content
                ════════════════════════════════════════════════════ --}}
             <!--   <div class="card col-card col4">
                    <div class="card-header">
                        <i class="fas fa-align-left text-danger me-2"></i>Column 4 — Heading &amp; Content
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Column Heading</label>
                            <input type="text" name="col4_heading" class="form-control"
                                   value="{{ old('col4_heading', $footer->col4_heading ?? '') }}"
                                   placeholder="e.g. Newsletter / Working Hours">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Content</label>
                            <textarea name="col4_content" class="form-control tinymce-editor" rows="6"
                                      placeholder="Working hours, newsletter form code, ya kuch bhi...">{{ old('col4_content', $footer->col4_content ?? '') }}</textarea>
                            <small class="text-muted">HTML allowed</small>
                        </div>
                    </div>
                </div> -->

                {{-- ── Submit Buttons --}}
                <div class="d-flex justify-content-end gap-2 mb-5">
                    @if($footer)
                        <a href="{{ route('footer.new.delete', $footer->id) }}"
                           class="btn btn-outline-danger"
                           onclick="event.preventDefault(); if(confirm('Delete footer? Yeh action undo nahi hogi!')) { document.getElementById('delete-footer-form').submit(); }">
                            <i class="fas fa-trash me-1"></i> Delete Footer
                        </a>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save me-1"></i> Update Footer
                        </button>
                    @else
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Save Footer
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
    </div>
</div>
@endsection

@push('scripts')
<script>
// ── Add / Remove Links ────────────────────────────────────
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
            // Last row clear kar do, delete mat karo
            row.querySelectorAll('input').forEach(i => i.value = '');
        }
    }
});
</script>
@endpush