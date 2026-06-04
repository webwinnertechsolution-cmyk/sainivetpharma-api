@extends('backend.layouts.layout')
@section('title', 'Contact Submissions')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap');

    * { box-sizing: border-box; }
    body { font-family: 'Nunito', sans-serif; background: #f5f7fa; }

    .page-container { max-width: 1400px; margin: 0 auto; padding: 0; }

    .page-header { margin-bottom: 14px; }
    .page-title { font-family: 'Sora', sans-serif; font-size: 17px; font-weight: 800; color: #0a214f; margin-bottom: 4px; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 10px; color: #6b7280; font-weight: 500; }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7; color: #065f46;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 11px;
    }
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5; color: #7f1d1d;
        padding: 10px 12px; border-radius: 8px; margin-bottom: 14px;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 500; font-size: 11px;
    }

    .page-card {
        background: #ffffff; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(10,33,79,0.08);
        overflow: hidden; border: 1px solid #e5e7eb;
        transition: all 0.3s ease; margin-bottom: 16px;
    }
    .page-card:hover { box-shadow: 0 12px 32px rgba(10,33,79,0.12); }

    .card-header-dark {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        padding: 12px 20px; color: #ffffff;
    }
    .card-header-title {
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }
    .card-header-row { display: flex; justify-content: space-between; align-items: center; }
    .table-count { font-size: 10px; background: rgba(255,255,255,0.2); color: #fff; padding: 2px 10px; border-radius: 20px; font-weight: 700; }

    .card-body { padding: 0; }

    /* Table */
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 11px; }
    thead tr { background: #f9fafb; }
    thead th {
        padding: 9px 12px; font-family: 'Sora', sans-serif; font-weight: 700;
        color: #0a214f; font-size: 10px; border-bottom: 2px solid #e5e7eb; white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody td { padding: 9px 12px; color: #374151; vertical-align: middle; font-size: 11px; }

    .badge-id { background: #e0e7ff; color: #3730a3; font-size: 10px; padding: 3px 8px; border-radius: 20px; font-family: 'Sora', sans-serif; font-weight: 700; display: inline-block; }

    .btn {
        padding: 6px 13px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 10px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-info    { background: linear-gradient(135deg, #0284c7, #38bdf8); color: white; box-shadow: 0 4px 12px rgba(2,132,199,0.3); }
    .btn-info:hover { transform: translateY(-1px); color: white; }
    .btn-danger  { background: linear-gradient(135deg, #ef4444, #f87171); color: white; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); }
    .btn-sm { padding: 4px 8px; font-size: 10px; }

    .contact-name { font-weight: 700; color: #0a214f; font-size: 11px; }
    .contact-address { font-size: 10px; color: #9ca3af; margin-top: 2px; }
    .contact-link { color: #1872B5; text-decoration: none; font-size: 11px; display: flex; align-items: center; gap: 4px; }
    .contact-link:hover { text-decoration: underline; color: #1872B5; }

    .empty-state { text-align: center; padding: 50px 20px; color: #6b7280; }
    .empty-state i { font-size: 40px; display: block; margin-bottom: 12px; opacity: 0.3; }
    .empty-state h5 { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; }
    .empty-state p { font-size: 11px; margin: 0; }

    /* Pagination */
    .pagination-wrapper {
        display: flex; justify-content: space-between; align-items: center;
        padding: 12px 16px; border-top: 1px solid #e5e7eb;
    }
    .pagination-info { font-size: 10px; color: #6b7280; font-family: 'Nunito', sans-serif; }

    /* Delete Modal */
    .del-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .del-modal-overlay.show { display: flex; }
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">📬 Contact Form Submissions</h1>
        <p class="page-subtitle">Visitors dwara submit kiye gaye contact forms</p>
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

    {{-- Table Card --}}
    <div class="page-card">
        <div class="card-header-dark">
            <div class="card-header-row">
                <h2 class="card-header-title"><i class="fas fa-envelope-open-text"></i> All Submissions</h2>
                <span class="table-count">Total: {{ $contacts->total() }}</span>
            </div>
        </div>

        <div class="card-body">
            @if($contacts->count() > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:50px;">ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Product</th>
                                <th style="width:100px;">Date</th>
                                <th style="width:120px; text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $index => $contact)
                            <tr>
                                <td style="text-align:center;">
                                    <span class="badge-id">#{{ $contacts->firstItem() + $index }}</span>
                                </td>
                                <td>
                                    <div class="contact-name">{{ $contact->name }}</div>
                                    @if($contact->address)
                                        <div class="contact-address"><i class="fas fa-map-marker-alt"></i> {{ Str::limit($contact->address, 30) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <a href="tel:{{ $contact->phone }}" class="contact-link">
                                        <i class="fas fa-phone"></i> {{ $contact->phone }}
                                    </a>
                                </td>
                                <td>
                                    <a href="mailto:{{ $contact->email }}" class="contact-link">
                                        <i class="fas fa-envelope"></i> {{ Str::limit($contact->email, 25) }}
                                    </a>
                                </td>
                                <td style="color:#6b7280;">{{ $contact->product_name ?: '—' }}</td>
                                <td>
                                    <div style="font-size:10px; color:#374151;">{{ $contact->created_at->format('d M Y') }}</div>
                                    <div style="font-size:10px; color:#9ca3af;">{{ $contact->created_at->format('h:i A') }}</div>
                                </td>
                                <td style="text-align:center;">
                                    <div style="display:flex; gap:5px; align-items:center; justify-content:center;">
                                        <a href="{{ route('contact.submission.view', $contact->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <form action="{{ route('contact.submission.delete', $contact->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirmDelete(event, '{{ addslashes($contact->name) }}')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Del
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="pagination-wrapper">
                    <span class="pagination-info">
                        Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of {{ $contacts->total() }} submissions
                    </span>
                    <div>
                        {{ $contacts->links() }}
                    </div>
                </div>

            @else
                <div class="empty-state">
                    <i class="fas fa-envelope"></i>
                    <h5>Koi submission nahi mili</h5>
                    <p>Jab visitors form submit karenge, yahan dikhega.</p>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Delete Confirm Modal --}}
<div class="del-modal-overlay" id="deleteModal">
    <div style="background:#fff; border-radius:12px; width:310px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="background:linear-gradient(135deg,#ef4444,#f87171); padding:12px 16px; color:white; display:flex; align-items:center; justify-content:space-between;">
            <h6 style="font-family:'Sora',sans-serif; font-size:12px; font-weight:700; margin:0;">
                <i class="fas fa-exclamation-triangle"></i> Confirm Delete
            </h6>
            <button style="background:none; border:none; color:white; font-size:15px; cursor:pointer;" onclick="closeDeleteModal()">✕</button>
        </div>
        <div style="padding:18px 16px; text-align:center;">
            <p style="font-size:11px; color:#374151; margin:0 0 6px;">Delete karna chahte hain?</p>
            <strong id="deleteItemName" style="color:#ef4444; font-size:12px;"></strong>
            <p style="font-size:10px; color:#9ca3af; margin-top:6px;">Yeh action undo nahi hoga.</p>
        </div>
        <div style="padding:10px 16px; display:flex; gap:8px; justify-content:center; border-top:1px solid #f3f4f6;">
            <button class="btn btn-secondary btn-sm" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger btn-sm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Haan, Delete
            </button>
        </div>
    </div>
</div>

<script>
    let pendingDeleteForm = null;

    function confirmDelete(e, name) {
        e.preventDefault();
        pendingDeleteForm = e.target;
        document.getElementById('deleteItemName').textContent = '"' + name + '"';
        document.getElementById('deleteModal').classList.add('show');
        return false;
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
        pendingDeleteForm = null;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (pendingDeleteForm) pendingDeleteForm.submit();
    });

    setTimeout(() => {
        document.querySelectorAll('.alert-success, .alert-danger').forEach(el => el.remove());
    }, 5000);
</script>

@endsection
