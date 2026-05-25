@extends('backend.layouts.layout')
@section('title', 'Home Video Sections')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">🎬 Home Video Sections</h2>
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

            <div class="alert alert-info d-flex align-items-start gap-3 mb-4">
                <span style="font-size:22px;">💡</span>
                <div>
                    <strong>Shortcode Usage:</strong> Section ID note karo aur Next.js page mein use karo:<br>
                    <code style="background:#fff;padding:3px 10px;border-radius:6px;font-size:13px;">
                        &lt;VideoSection sectionId={1} /&gt;
                    </code>
                </div>
            </div>

            <div class="row">

                {{-- FORM --}}
                <div class="col-lg-5 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">{{ isset($editSection) ? '✏️ Edit Section' : '➕ Add New Section' }}</h5>
                        </div>
                        <div class="card-body">

                            @if(isset($editSection))
                                <form action="{{ route('home.video.section.update', $editSection->id) }}" method="POST" enctype="multipart/form-data">
                            @else
                                <form action="{{ route('home.video.section.store') }}" method="POST" enctype="multipart/form-data">
                            @endif
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Heading <span class="text-danger">*</span></label>
                                <input type="text" name="heading" class="form-control"
                                    value="{{ old('heading', $editSection->heading ?? '') }}"
                                    placeholder="e.g. Our Latest Videos 🎥" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Sub Heading</label>
                                <input type="text" name="sub_heading" class="form-control"
                                    value="{{ old('sub_heading', $editSection->sub_heading ?? '') }}"
                                    placeholder="e.g. Watch our product demos">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">View All Button Text</label>
                                <input type="text" name="view_all_text" class="form-control"
                                    value="{{ old('view_all_text', $editSection->view_all_text ?? 'View All') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">View All URL</label>
                                <input type="text" name="view_all_url" class="form-control"
                                    value="{{ old('view_all_url', $editSection->view_all_url ?? '') }}"
                                    placeholder="e.g. /videos">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" min="0"
                                    value="{{ old('sort_order', $editSection->sort_order ?? 0) }}">
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                    {{ old('is_active', $editSection->is_active ?? 1) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">Active (Show on frontend)</label>
                            </div>

                            <hr>

                            {{-- Existing Videos in Edit Mode --}}
                            @if(isset($editSection) && !empty($editSection->videos))
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Existing Videos</label>
                                    <small class="text-muted d-block mb-2">Uncheck karo to delete karne ke liye</small>
                                    @foreach($editSection->videos as $i => $vid)
                                    <div class="border rounded p-2 mb-2 d-flex align-items-center gap-2">
                                        <input type="checkbox" name="keep_videos[]" value="{{ $i }}" checked
                                            class="form-check-input mt-0" style="width:18px;height:18px;flex-shrink:0;">
                                        @if(!empty($vid['thumbnail']))
                                            <img src="{{ asset('uploads/video-sections/thumbnails/' . $vid['thumbnail']) }}"
                                                style="width:60px;height:40px;object-fit:cover;border-radius:4px;flex-shrink:0;">
                                        @else
                                            <div style="width:60px;height:40px;background:#1872B5;border-radius:4px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;">🎬</div>
                                        @endif
                                        <input type="text" name="existing_titles[{{ $i }}]"
                                            class="form-control form-control-sm"
                                            value="{{ $vid['title'] ?? '' }}"
                                            placeholder="Video title">
                                    </div>
                                    @endforeach
                                </div>
                                <hr>
                            @endif

                            {{-- Upload Videos --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    {{ isset($editSection) ? '➕ Add More Videos' : 'Upload Videos' }}
                                </label>
                                <small class="text-muted d-block mb-2">Ek saath multiple videos select kar sakte ho</small>

                                <div class="mb-2">
                                    <label style="font-size:12px;" class="form-label">Video Files (mp4, webm, mov) — Multiple Select</label>
                                    <input type="file" name="videos[]" class="form-control" accept="video/*" multiple>
                                    <small class="text-muted">Ctrl/Cmd + Click se multiple files select karo</small>
                                </div>

                                <div class="mb-2">
                                    <label style="font-size:12px;" class="form-label">Thumbnails (optional) — Multiple Select</label>
                                    <input type="file" name="thumbnails[]" class="form-control" accept="image/*" multiple>
                                    <small class="text-muted">Videos ke order mein thumbnails upload karo</small>
                                </div>

                                {{-- Dynamic Title Fields --}}
                                <div class="mb-2">
                                    <label style="font-size:12px;" class="form-label">Video Titles (optional)</label>
                                    <div id="title-list">
                                        <input type="text" name="video_titles[]" class="form-control form-control-sm mb-1" placeholder="Video 1 title">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="addTitleField()">+ Add Title Field</button>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($editSection) ? '💾 Update' : '➕ Add Section' }}
                                </button>
                                @if(isset($editSection))
                                    <a href="{{ route('home.video.section') }}" class="btn btn-secondary">Cancel</a>
                                @endif
                            </div>

                            </form>
                        </div>
                    </div>
                </div>

                {{-- LIST --}}
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">All Video Sections ({{ $sections->count() }})</h5>
                        </div>
                        <div class="card-body p-0">
                            @if($sections->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">ID</th>
                                            <th>Heading</th>
                                            <th width="90">Videos</th>
                                            <th width="80">Status</th>
                                            <th width="130">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sections as $sec)
                                        <tr>
                                            <td class="align-middle text-center">
                                                <span class="badge bg-secondary fs-6">#{{ $sec->id }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="fw-semibold">{{ $sec->heading }}</div>
                                                @if($sec->sub_heading)
                                                    <small class="text-muted">{{ $sec->sub_heading }}</small>
                                                @endif
                                                <div class="mt-1">
                                                    <code style="font-size:11px;background:#f0f4f8;padding:2px 7px;border-radius:4px;">
                                                        @php echo htmlspecialchars('<VideoSection sectionId={' . $sec->id . '} />'); @endphp
                                                    </code>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="badge bg-info text-dark">{{ count($sec->videos ?? []) }} videos</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($sec->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('home.video.section.edit', $sec->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('home.video.section.delete', $sec->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this section?')">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger">Del</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="p-4 text-center text-muted">No video sections yet. Add your first one!</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function addTitleField() {
    const list = document.getElementById('title-list');
    const count = list.querySelectorAll('input').length + 1;
    const div = document.createElement('div');
    div.className = 'd-flex gap-1 mb-1';
    div.innerHTML = `
        <input type="text" name="video_titles[]" class="form-control form-control-sm" placeholder="Video ${count} title">
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()">✕</button>
    `;
    list.appendChild(div);
}
</script>

@endsection