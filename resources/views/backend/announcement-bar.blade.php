@extends('backend.layouts.layout')
@section('title', 'Announcement Bar')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Nunito', sans-serif;
        background: #f5f7fa;
    }

    .announcement-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0;
    }

    .announcement-header {
        margin-bottom: 14px;
        padding: 0 20px;
    }

    .announcement-title {
        font-family: 'Sora', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: #0a214f;
        margin-bottom: 4px;
        letter-spacing: -0.02em;
    }

    .announcement-subtitle {
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Alert Styles */
    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7;
        color: #065f46;
        padding: 10px 12px;
        border-radius: 8px;
        margin: 0 20px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 500;
        font-size: 12px;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5;
        color: #7f1d1d;
        padding: 10px 12px;
        border-radius: 8px;
        margin: 0 20px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 500;
        font-size: 12px;
    }

    .alert .btn-close {
        opacity: 1;
        filter: invert(0);
    }

    /* Card Styles */
    .announcement-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10, 33, 79, 0.08);
        overflow: hidden;
        margin: 0 20px 16px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .announcement-card:hover {
        box-shadow: 0 12px 32px rgba(10, 33, 79, 0.12);
    }

    .card-header-gradient {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 20px;
        color: #ffffff;
    }

    .card-header-title {
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-body {
        padding: 16px;
    }

    /* Form Styles */
    .form-label {
        font-family: 'Sora', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #0a214f;
        margin-bottom: 6px;
        display: block;
    }

    .form-label small {
        display: block;
        font-size: 10px;
        font-weight: 500;
        color: #6b7280;
        margin-top: 2px;
    }

    .form-control,
    .form-select {
        border: 1.5px solid #e5e7eb;
        border-radius: 6px;
        padding: 7px 10px;
        font-size: 12px;
        font-family: 'Nunito', sans-serif;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1872B5;
        box-shadow: 0 0 0 3px rgba(24, 114, 181, 0.1);
        outline: none;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #ef4444;
    }

    .form-control-color {
        height: 36px;
        border-radius: 6px;
        cursor: pointer;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 11px;
        margin-top: 4px;
        display: block;
    }

    /* Form Row */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }

    .form-row-three {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }

    .form-group {
        margin-bottom: 0;
    }

    /* Announcement List */
    .announcement-list-item {
        display: flex;
        gap: 8px;
        margin-bottom: 8px;
        align-items: center;
    }

    .announcement-list-item input {
        flex: 1;
    }

    .btn-outline-danger {
        border: 1.5px solid #ef4444;
        color: #ef4444;
        padding: 5px 10px;
        font-size: 11px;
        border-radius: 6px;
        background: transparent;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-outline-danger:hover {
        background: #fecaca;
        color: #991b1b;
    }

    .btn-outline-secondary {
        border: 1.5px solid #d1d5db;
        color: #6b7280;
        padding: 5px 12px;
        font-size: 11px;
        border-radius: 6px;
        background: transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 700;
    }

    .btn-outline-secondary:hover {
        background: #f3f4f6;
        color: #374151;
    }

    /* Buttons */
    .btn-group-custom {
        display: flex;
        gap: 8px;
        margin-top: 14px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 7px 14px;
        border-radius: 6px;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 11px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1872B5, #2596e1);
        color: white;
        box-shadow: 0 4px 12px rgba(24, 114, 181, 0.3);
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(24, 114, 181, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #f87171);
        color: white;
        font-weight: 700;
    }

    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #1f2937;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .btn-secondary:hover {
        background: #d1d5db;
        transform: translateY(-1px);
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        margin-top: 2px;
    }

    .form-check-label {
        font-size: 12px;
        color: #0a214f;
        font-weight: 500;
        margin-left: 6px;
    }

    /* Preview Section */
    .preview-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .preview-text {
        flex: 1;
        text-align: center;
        transition: opacity 0.4s ease;
    }

    .preview-phone {
        white-space: nowrap;
        padding-left: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .preview-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        font-size: 11px;
    }

    .preview-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .preview-info-label {
        color: #6b7280;
        font-weight: 600;
    }

    .preview-info-value {
        color: #0a214f;
        font-weight: 700;
    }

    .usage-code {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        padding: 10px;
        border-radius: 6px;
        font-size: 11px;
        font-family: 'Courier New', monospace;
        color: #1f2937;
        word-break: break-all;
        margin-bottom: 8px;
    }

    .usage-endpoint {
        background: #f3f4f6;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 10px;
        font-family: 'Courier New', monospace;
        color: #0a214f;
        margin-top: 8px;
        display: inline-block;
    }

    .text-muted {
        color: #6b7280;
        font-size: 11px;
    }

    strong {
        color: #0a214f;
    }

    .text-danger {
        color: #ef4444;
    }

    hr {
        border: none;
        border-top: 1px solid #e5e7eb;
        margin: 12px 0;
    }
.afasss {
    margin-left: 41px;
}
    .form-check .form-check-label {
    display: block;
    margin-left: 0;
    font-size: 0.875rem;
    line-height: 1.5;
}
    .announcement-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(10, 33, 79, 0.08);
    overflow: hidden;
    margin: 0;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}
    /* Responsive */
    @media (max-width: 1024px) {
        .form-row,
        .form-row-three {
            grid-template-columns: 1fr;
        }

        .preview-info {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .announcement-container {
            padding: 0;
        }

        .announcement-header,
        .announcement-card {
            margin-left: 0;
            margin-right: 0;
        }

        .announcement-title {
            font-size: 18px;
        }

        .card-body {
            padding: 12px;
        }

        .btn-group-custom {
            flex-direction: column-reverse;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .preview-bar {
            flex-direction: column;
            text-align: center;
            gap: 8px;
        }

        .preview-phone {
            padding-left: 0;
        }
    }
</style>

<div class="announcement-container">
    <!-- Header -->
    <div class="announcement-header">
        <h1 class="announcement-title">📢 Announcement Bar</h1>
        <p class="announcement-subtitle">Manage sliding announcements and contact information</p>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert-success">
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Alert -->
    @if(session('error'))
        <div class="alert-danger">
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin: 0 20px;">

        {{-- FORM CARD --}}
        <div class="announcement-card">
            <div class="card-header-gradient">
                <h2 class="card-header-title">
                    @if($bar)
                        <i class="fas fa-pen"></i> Edit Announcement Bar
                    @else
                        <i class="fas fa-plus-circle"></i> Create Announcement Bar
                    @endif
                </h2>
            </div>

            <div class="card-body">
                @if($bar)
                    <form action="{{ route('announcement.bar.update', $bar->id) }}" method="POST">
                @else
                    <form action="{{ route('announcement.bar.store') }}" method="POST">
                @endif
                @csrf

                    {{-- Announcements --}}
                    <div style="margin-bottom: 14px;">
                        <label class="form-label">
                            Sliding Announcements <span class="text-danger">*</span>
                            <small>Each line slides every 3 seconds</small>
                        </label>
                        <div id="announcement-list">
                            @if($bar && count($bar->announcements) > 0)
                                @foreach($bar->announcements as $i => $ann)
                                    <div class="announcement-list-item">
                                        <input type="text" name="announcements[]" class="form-control"
                                            value="{{ $ann }}" placeholder="Announcement text...">
                                        @if($i > 0)
                                            <button type="button" class="btn-outline-danger" onclick="this.parentElement.remove()">✕</button>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="announcement-list-item">
                                    <input type="text" name="announcements[]" class="form-control" placeholder="e.g. Free shipping on orders over ₹999!">
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn-outline-secondary" onclick="addAnnouncement()">
                            + Add Another Line
                        </button>
                    </div>

                    <hr>

                    {{-- Phone Section --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone_label" class="form-label">Phone Label</label>
                            <input type="text" name="phone_label" class="form-control"
                                value="{{ old('phone_label', $bar->phone_label ?? 'Call Us') }}"
                                placeholder="Call Us">
                        </div>
                        <div class="form-group">
                            <label for="phone_number" class="form-label">
                                Phone Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="phone_number" class="form-control"
                                value="{{ old('phone_number', $bar->phone_number ?? '') }}"
                                placeholder="+91 98765 43210" required>
                        </div>
                    </div>

                    <div style="margin-bottom: 12px;">
                        <label for="phone_url" class="form-label">
                            Phone URL
                            <small>(optional)</small>
                        </label>
                        <input type="text" name="phone_url" class="form-control"
                            value="{{ old('phone_url', $bar->phone_url ?? '') }}"
                            placeholder="tel:+919876543210 or https://wa.me/919876543210">
                    </div>

                    <hr>

                    {{-- Styling --}}
                    <div class="form-row-three">
                        <div class="form-group">
                            <label for="bg_color" class="form-label">BG Color</label>
                            <input type="color" name="bg_color" class="form-control form-control-color"
                                value="{{ old('bg_color', $bar->bg_color ?? '#1a1a1a') }}">
                        </div>
                        <div class="form-group">
                            <label for="text_color" class="form-label">Text Color</label>
                            <input type="color" name="text_color" class="form-control form-control-color"
                                value="{{ old('text_color', $bar->text_color ?? '#ffffff') }}">
                        </div>
                        <div class="form-gro
                            up">
                            <label for="slide_interval" class="form-label">Interval (ms)</label>
                            <input type="number" name="slide_interval" class="form-control"
                                value="{{ old('slide_interval', $bar->slide_interval ?? 3000) }}"
                                min="1000" max="10000" step="500">
                        </div>
                    </div>

                    {{-- Active Toggle --}}
                    <div class="afasss" style="margin-bottom: 12px;">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                {{ old('is_active', $bar->is_active ?? 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (Show on website)
                            </label>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="btn-group-custom">
                        @if($bar)
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <form action="{{ route('announcement.bar.delete', $bar->id) }}" method="POST"
                                onsubmit="return confirm('Delete announcement bar?')" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        @else
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create
                            </button>
                        @endif
                    </div>

                </form>
            </div>
        </div>

        {{-- PREVIEW CARD --}}
        <div class="announcement-card">
            <div class="card-header-gradient">
                <h2 class="card-header-title">
                    <i class="fas fa-eye"></i> Live Preview
                </h2>
            </div>

            <div class="card-body">
                @if($bar)
                    <div class="preview-bar" id="preview-bar" style="
                        background-color: {{ $bar->bg_color }};
                        color: {{ $bar->text_color }};
                    ">
                        <div class="preview-text" id="preview-text">
                            {{ $bar->announcements[0] ?? '' }}
                        </div>
                        <div class="preview-phone">
                            📞 {{ $bar->phone_number }}
                        </div>
                    </div>

                    <div class="preview-info">
                        <div class="preview-info-item">
                            <span class="preview-info-label">Announcements:</span>
                            <span class="preview-info-value">{{ count($bar->announcements) }}</span>
                        </div>
                        <div class="preview-info-item">
                            <span class="preview-info-label">Interval:</span>
                            <span class="preview-info-value">{{ $bar->slide_interval / 1000 }}s</span>
                        </div>
                        <div class="preview-info-item">
                            <span class="preview-info-label">Status:</span>
                            <span class="preview-info-value">{{ $bar->is_active ? '✅ On' : '❌ Off' }}</span>
                        </div>
                        <div class="preview-info-item">
                            <span class="preview-info-label">Phone:</span>
                            <span class="preview-info-value" style="font-size: 10px;">{{ $bar->phone_number }}</span>
                        </div>
                    </div>

                    <script>
                    (function(){
                        const texts = @json($bar->announcements);
                        const el    = document.getElementById('preview-text');
                        let i = 0;
                        if (!el || texts.length < 2) return;
                        setInterval(() => {
                            el.style.opacity = '0';
                            setTimeout(() => {
                                i = (i + 1) % texts.length;
                                el.textContent  = texts[i];
                                el.style.opacity = '1';
                            }, 400);
                        }, {{ $bar->slide_interval }});
                    })();
                    </script>
                @else
                    <div style="text-align: center; padding: 24px 12px; color: #6b7280;">
                        <p style="font-size: 12px; margin: 0;">Create announcement bar to see preview here</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- USAGE CARD --}}
    <div class="announcement-card" style="margin-top: 0;">
        <div class="card-header-gradient">
            <h2 class="card-header-title">
                <i class="fas fa-code"></i> Usage in Next.js
            </h2>
        </div>
        <div class="card-body">
            <div class="usage-code">&lt;AnnouncementBar /&gt;</div>
            <small class="text-muted">API endpoint:</small>
            <div class="usage-endpoint">/api/announcement-bar</div>
        </div>
    </div>

</div>

<script>
function addAnnouncement() {
    const list  = document.getElementById('announcement-list');
    const count = list.querySelectorAll('input').length + 1;
    const div   = document.createElement('div');
    div.className = 'announcement-list-item';
    div.innerHTML = `
        <input type="text" name="announcements[]" class="form-control" placeholder="Announcement ${count}...">
        <button type="button" class="btn-outline-danger" onclick="this.parentElement.remove()">✕</button>
    `;
    list.appendChild(div);
}
</script>

@endsection
