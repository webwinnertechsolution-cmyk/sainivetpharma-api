@extends('backend.layouts.layout')
@section('title', 'Announcement Bar')
@section('content')

<div class="container-fluid">
<div class="row">
<div class="col-12">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">📢 Announcement Bar</h2>
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
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">{{ $bar ? '✏️ Edit Announcement Bar' : '➕ Add Announcement Bar' }}</h5>
                </div>
                <div class="card-body">

                    @if($bar)
                        <form action="{{ route('announcement.bar.update', $bar->id) }}" method="POST">
                    @else
                        <form action="{{ route('announcement.bar.store') }}" method="POST">
                    @endif
                    @csrf

                    {{-- Announcements (sliding text) --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Sliding Announcements <span class="text-danger">*</span></label>
                        <small class="text-muted d-block mb-2">Har ek line alag announcement hogi — 3 sec mein slide hogi</small>
                        <div id="announcement-list">
                            @if($bar && count($bar->announcements) > 0)
                                @foreach($bar->announcements as $i => $ann)
                                    <div class="d-flex gap-2 mb-2">
                                        <input type="text" name="announcements[]" class="form-control"
                                            value="{{ $ann }}" placeholder="Announcement text...">
                                        @if($i > 0)
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()">✕</button>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="mb-2">
                                    <input type="text" name="announcements[]" class="form-control" placeholder="e.g. Free shipping on orders over ₹999!">
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="addAnnouncement()">
                            + Add Another Line
                        </button>
                    </div>

                    <hr>

                    {{-- Phone --}}
                    <div class="row">
                        <div class="col-5 mb-3">
                            <label class="form-label fw-bold">Phone Label</label>
                            <input type="text" name="phone_label" class="form-control"
                                value="{{ old('phone_label', $bar->phone_label ?? 'Call Us') }}"
                                placeholder="Call Us">
                        </div>
                        <div class="col-7 mb-3">
                            <label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone_number" class="form-control"
                                value="{{ old('phone_number', $bar->phone_number ?? '') }}"
                                placeholder="+91 98765 43210" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone URL <small class="text-muted">(optional)</small></label>
                        <input type="text" name="phone_url" class="form-control"
                            value="{{ old('phone_url', $bar->phone_url ?? '') }}"
                            placeholder="tel:+919876543210  OR  https://wa.me/919876543210">
                    </div>

                    <hr>

                    {{-- Style --}}
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label class="form-label fw-bold">Background Color</label>
                            <input type="color" name="bg_color" class="form-control form-control-color"
                                value="{{ old('bg_color', $bar->bg_color ?? '#1a1a1a') }}">
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label fw-bold">Text Color</label>
                            <input type="color" name="text_color" class="form-control form-control-color"
                                value="{{ old('text_color', $bar->text_color ?? '#ffffff') }}">
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label fw-bold">Slide Interval (ms)</label>
                            <input type="number" name="slide_interval" class="form-control"
                                value="{{ old('slide_interval', $bar->slide_interval ?? 3000) }}"
                                min="1000" max="10000" step="500">
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                            {{ old('is_active', $bar->is_active ?? 1) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_active">Active (Show on frontend)</label>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            {{ $bar ? '💾 Update' : '➕ Create' }}
                        </button>
                        @if($bar)
                            <form action="{{ route('announcement.bar.delete', $bar->id) }}" method="POST"
                                onsubmit="return confirm('Delete announcement bar?')" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">🗑️ Delete</button>
                            </form>
                        @endif
                    </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- PREVIEW --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">👀 Live Preview</h5>
                </div>
                <div class="card-body p-0">
                    @if($bar)
                        <div id="preview-bar" style="
                            background-color: {{ $bar->bg_color }};
                            color: {{ $bar->text_color }};
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            padding: 10px 20px;
                            font-size: 13px;
                            font-weight: 500;
                        ">
                            <div id="preview-text" style="flex:1;text-align:center;">
                                {{ $bar->announcements[0] ?? '' }}
                            </div>
                            <div style="white-space:nowrap;padding-left:16px;">
                                📞 {{ $bar->phone_number }}
                            </div>
                        </div>
                        <div class="p-3 text-muted small">
                            <strong>Total announcements:</strong> {{ count($bar->announcements) }}<br>
                            <strong>Slide interval:</strong> {{ $bar->slide_interval / 1000 }} seconds<br>
                            <strong>Status:</strong> {{ $bar->is_active ? '✅ Active' : '❌ Inactive' }}
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
                            el.style.transition = 'opacity 0.4s ease';
                        })();
                        </script>
                    @else
                        <div class="p-4 text-center text-muted">
                            Pehle announcement bar create karo — preview yahan dikhega.
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-header">
                    <h6 class="mb-0">💡 Usage in Next.js</h6>
                </div>
                <div class="card-body">
                    <code style="font-size:12px;background:#f0f4f8;padding:6px 12px;border-radius:6px;display:block;">
                        &lt;AnnouncementBar /&gt;
                    </code>
                    <small class="text-muted d-block mt-2">
                        API endpoint: <code>/api/announcement-bar</code>
                    </small>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>

<script>
function addAnnouncement() {
    const list  = document.getElementById('announcement-list');
    const count = list.querySelectorAll('input').length + 1;
    const div   = document.createElement('div');
    div.className = 'd-flex gap-2 mb-2';
    div.innerHTML = `
        <input type="text" name="announcements[]" class="form-control" placeholder="Announcement ${count}...">
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()">✕</button>
    `;
    list.appendChild(div);
}
</script>

@endsection