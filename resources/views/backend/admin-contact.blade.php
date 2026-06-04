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

    .contact-name { font-weight: 700; color: #0a214f; font-size: 11px; }
    .contact-address { font-size: 10px; color: #9ca3af; margin-top: 2px; }
    .contact-link { color: #1872B5; text-decoration: none; font-size: 11px; display: inline-flex; align-items: center; gap: 4px; }
    .contact-link:hover { text-decoration: underline; color: #1872B5; }

    .btn {
        padding: 6px 13px; border-radius: 6px; font-family: 'Sora', sans-serif;
        font-weight: 700; font-size: 10px; border: none; cursor: pointer;
        transition: all 0.3s ease; display: inline-flex; align-items: center;
        gap: 5px; text-decoration: none;
    }
    .btn-info      { background: linear-gradient(135deg, #0284c7, #38bdf8); color: white; box-shadow: 0 4px 12px rgba(2,132,199,0.3); }
    .btn-info:hover { transform: translateY(-1px); color: white; }
    .btn-success   { background: linear-gradient(135deg, #059669, #34d399); color: white; box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
    .btn-success:hover { transform: translateY(-1px); color: white; }
    .btn-danger    { background: linear-gradient(135deg, #ef4444, #f87171); color: white; }
    .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(239,68,68,0.3); color: white; }
    .btn-secondary { background: #e5e7eb; color: #1f2937; border: none; }
    .btn-secondary:hover { background: #d1d5db; transform: translateY(-1px); color: #1f2937; }
    .btn-sm { padding: 4px 8px; font-size: 10px; }

    .empty-state { text-align: center; padding: 50px 20px; color: #6b7280; }
    .empty-state i { font-size: 40px; display: block; margin-bottom: 12px; opacity: 0.3; }
    .empty-state h5 { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px; }
    .empty-state p { font-size: 11px; margin: 0; }

    /* ===== IMPROVED PAGINATION STYLES ===== */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px;
        border-top: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        flex-wrap: wrap;
        gap: 16px;
    }

    .pagination-info {
        font-size: 11px;
        color: #374151;
        font-weight: 600;
        font-family: 'Sora', sans-serif;
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Pagination Links */
    .pagination {
        display: flex;
        align-items: center;
        gap: 4px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        display: inline-flex;
        align-items: center;
    }

    /* Page Link Base Styles */
    .pagination a,
    .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        padding: 0 6px;
        font-size: 10px;
        font-family: 'Sora', sans-serif;
        font-weight: 600;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        text-decoration: none;
        transition: all 0.25s ease;
        color: #374151;
        background: #ffffff;
        cursor: pointer;
    }

    /* Active Page */
    .pagination .active span {
        background: linear-gradient(135deg, #1872B5 0%, #0284c7 100%);
        color: #ffffff;
        border-color: #1872B5;
        box-shadow: 0 2px 8px rgba(24,114,181,0.25);
    }

    /* Hover State */
    .pagination a:hover {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-color: #0284c7;
        color: #0284c7;
        transform: translateY(-1px);
    }

    /* Disabled State */
    .pagination .disabled span {
        background: #f3f4f6;
        color: #d1d5db;
        border-color: #e5e7eb;
        cursor: not-allowed;
    }

    /* Previous/Next Buttons */
    .pagination a[rel="prev"],
    .pagination a[rel="next"] {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        color: #374151;
        border-color: #d1d5db;
    }

    .pagination a[rel="prev"]:hover,
    .pagination a[rel="next"]:hover {
        background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
        color: #ffffff;
        border-color: #0284c7;
    }

    .pagination a[rel="prev"] i,
    .pagination a[rel="next"] i {
        font-size: 9px;
        margin: 0 2px;
    }

    /* Dots/Ellipsis */
    .pagination .pagination-dots span {
        background: transparent;
        border: none;
        cursor: default;
    }

    .pagination .pagination-dots span:hover {
        background: transparent;
        transform: none;
    }

    /* Responsive Pagination */
    @media (max-width: 768px) {
        .pagination-wrapper {
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .pagination-info {
            order: 1;
            width: 100%;
            text-align: center;
        }

        .pagination-controls {
            order: 2;
        }

        .pagination a,
        .pagination span {
            min-width: 24px;
            height: 24px;
            font-size: 9px;
            padding: 0 4px;
        }
    }

    @media (max-width: 480px) {
        .pagination {
            gap: 2px;
        }

        .pagination a,
        .pagination span {
            min-width: 20px;
            height: 20px;
            font-size: 8px;
            padding: 0 3px;
        }

        .pagination-info {
            font-size: 10px;
        }
    }

    /* Delete Modal */
    .del-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; }
    .del-modal-overlay.show { display: flex; }

    /* View Modal */
    .view-modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9998; align-items: center; justify-content: center; }
    .view-modal-overlay.show { display: flex; }
    .view-modal-box {
        background: #fff; border-radius: 12px; width: 580px; max-width: 95vw;
        overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-height: 90vh; display: flex; flex-direction: column;
    }
    .view-modal-header {
        background: linear-gradient(135deg, #0a214f 0%, #1872B5 100%);
        padding: 12px 16px; color: white;
        display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;
    }
    .view-modal-header h6 { font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700; margin: 0; }
    .view-modal-body { padding: 16px; overflow-y: auto; flex: 1; }
    .view-modal-footer {
        padding: 10px 16px; display: flex; gap: 8px; justify-content: flex-end;
        border-top: 1px solid #f3f4f6; flex-shrink: 0;
    }

    .info-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px; }
    .info-item { }
    .info-label {
        font-family: 'Sora', sans-serif; font-size: 10px; font-weight: 700;
        color: #0a214f; margin-bottom: 4px; display: flex; align-items: center; gap: 5px;
    }
    .info-value {
        font-size: 11px; color: #374151; background: #f9fafb;
        padding: 7px 10px; border-radius: 6px; border: 1px solid #e5e7eb;
        min-height: 30px; word-break: break-word;
    }
    .info-value a { color: #1872B5; text-decoration: none; }
    .info-value a:hover { text-decoration: underline; }
    .info-value.message-box { max-height: 120px; overflow-y: auto; white-space: pre-wrap; line-height: 1.6; }
    .info-value.empty { color: #9ca3af; font-style: italic; }

    .section-divider {
        font-family: 'Sora', sans-serif; font-size: 9px; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.08em; color: #9ca3af;
        margin: 14px 0 10px; display: flex; align-items: center; gap: 8px;
    }
    .section-divider::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }
        .form-check.form-switch {
    width: 61%;
    margin-left: 42px!important;
}
    .form-check .form-check-label {
    display: block;
    margin-left: 0;
    font-size: 0.875rem;
    line-height: 1.5;
}
    .btn.btn-sm, .ajax-upload-dragdrop .btn-sm.ajax-file-upload, .btn-group-sm > .btn, .ajax-upload-dragdrop .btn-group-sm > .ajax-file-upload {
    font-size: 9px!important;
}

.form-group label {
    font-size: 12px;
    line-height: 1;
    vertical-align: top;
    margin-bottom: 0.5rem;
}
</style>

<div class="page-container">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">📬 Contact Form Submissions</h1>
        <p class="page-subtitle">Contact forms submitted by website visitors.</p>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert-success">
            <span>✅ {{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-size:14px;color:#065f46;">✕</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-danger">
            <span>⚠️ {{ session('error') }}</span>
            <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-size:14px;color:#7f1d1d;">✕</button>
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
	</div>
	{{---
<div class="page-card" style="margin-bottom: 14px;">
			<div class="card-header-dark" style="padding: 10px 16px;">
				<h2 class="card-header-title">
					<i class="fas fa-filter"></i> Filter by Date
				</h2>
			</div>
			<div style="padding: 14px 16px;">
				<form method="GET" action="{{ route('contact.submissions') }}"
					  style="display: flex; align-items: flex-end; gap: 12px; flex-wrap: wrap;">

					<div style="display: flex; flex-direction: column; gap: 4px;">
						<label style="font-family:'Sora',sans-serif; font-size:10px; font-weight:700; color:#0a214f;">
							<i class="fas fa-calendar-alt"></i> From Date
						</label>
						<input type="date" name="date_from"
							   value="{{ request('date_from') }}"
							   style="padding:7px 10px; border:1px solid #e5e7eb; border-radius:6px;
									  font-size:11px; font-family:'Nunito',sans-serif; color:#374151;
									  background:#f9fafb; outline:none; cursor:pointer;">
					</div>

					<div style="display: flex; flex-direction: column; gap: 4px;">
						<label style="font-family:'Sora',sans-serif; font-size:10px; font-weight:700; color:#0a214f;">
							<i class="fas fa-calendar-alt"></i> To Date
						</label>
						<input type="date" name="date_to"
							   value="{{ request('date_to') }}"
							   style="padding:7px 10px; border:1px solid #e5e7eb; border-radius:6px;
									  font-size:11px; font-family:'Nunito',sans-serif; color:#374151;
									  background:#f9fafb; outline:none; cursor:pointer;">
					</div>

					<div style="display:flex; gap:8px; align-items:flex-end; padding-bottom:1px;">
						<button type="submit" class="btn btn-info btn-sm">
							<i class="fas fa-search"></i> Filter
						</button>
						@if(request('date_from') || request('date_to'))
							<a href="{{ route('contact.submissions') }}" class="btn btn-secondary btn-sm">
								<i class="fas fa-times"></i> Clear
							</a>
						@endif
					</div>

					@if(request('date_from') || request('date_to'))
						<div style="display:flex; align-items:center;">
							<span style="font-size:10px; background:#fef3c7; color:#92400e; padding:4px 10px;
										 border-radius:20px; font-weight:700; font-family:'Sora',sans-serif;
										 border:1px solid #fcd34d;">
								<i class="fas fa-filter"></i>
								Filter active:
								@if(request('date_from')) From {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }} @endif
								@if(request('date_to')) To {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }} @endif
							</span>
						</div>
					@endif

				</form>
			</div>
		</div>
		--}}
        <div style="padding:0;">
            @if($contacts->count() > 0)
			
					

                <div class="table-wrapper">
				
                    <table>
                        <thead>
                            <tr>
                                <th style="width:50px;">ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Product</th>
                                <th>Message</th>
                                <th style="width:100px;">Date</th>
                                <th style="width:120px; text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $contact)
                            <tr>
                                <td style="text-align:center;">
                                    <span class="badge-id">#{{ $contact->id }}</span>
                                </td>
                                <td>
                                    <div class="contact-name">{{ $contact->name }}</div>
                                    @if($contact->address)
                                        <div class="contact-address"><i class="fas fa-map-marker-alt"></i> {{ Str::limit($contact->address, 25) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <a href="mailto:{{ $contact->email }}" class="contact-link">
                                        <i class="fas fa-envelope"></i> {{ Str::limit($contact->email, 25) }}
                                    </a>
                                </td>
                                <td>
                                    <a href="tel:{{ $contact->phone }}" class="contact-link">
                                        <i class="fas fa-phone"></i> {{ $contact->phone }}
                                    </a>
                                </td>
                                <td style="color:#6b7280;">{{ $contact->product_name ?: '—' }}</td>
                                <td style="color:#6b7280;">{{ Str::limit($contact->message, 50) ?: '—' }}</td>
                                <td>
                                    <div style="font-size:10px; color:#374151;">{{ $contact->created_at->format('d M Y') }}</div>
                                    <div style="font-size:10px; color:#9ca3af;">{{ $contact->created_at->format('h:i A') }}</div>
                                </td>
                                <td style="text-align:center;">
                                    <div style="display:flex; gap:5px; align-items:center; justify-content:center;">
                                        <button type="button" class="btn btn-info btn-sm"
                                            onclick="openViewModal(
                                                '{{ $contact->id }}',
                                                '{{ addslashes($contact->name) }}',
                                                '{{ addslashes($contact->email) }}',
                                                '{{ addslashes($contact->phone) }}',
                                                '{{ addslashes($contact->address ?? '') }}',
                                                '{{ addslashes($contact->product_name ?? '') }}',
                                                '{{ addslashes($contact->message ?? '') }}',
                                                '{{ $contact->created_at->format('d M Y, h:i A') }}'
                                            )">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <form action="{{ route('admin.contacts.delete', $contact->id) }}"
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
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5>Koi submission nahi mili</h5>
                                        <p>Jab visitors form submit karenge, yahan dikhega.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- IMPROVED PAGINATION --}}
                @if($contacts->hasPages())
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        <i class="fas fa-list"></i>
                        Showing <strong>{{ $contacts->firstItem() }}</strong> to <strong>{{ $contacts->lastItem() }}</strong> 
                        of <strong>{{ $contacts->total() }}</strong> submissions
                    </div>
                    <div class="pagination-controls">
                        {{ $contacts->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                @endif

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

{{-- View Modal --}}
<div class="view-modal-overlay" id="viewModal">
    <div class="view-modal-box">
        <div class="view-modal-header">
            <h6><i class="fas fa-info-circle"></i> Contact Details <span id="modalId"></span></h6>
            <button style="background:none;border:none;color:white;font-size:16px;cursor:pointer;" onclick="closeViewModal()">✕</button>
        </div>
        <div class="view-modal-body">
            <div class="section-divider">Personal Info</div>
            <div class="info-row">
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-user" style="color:#1872B5;"></i> Name</div>
                    <div class="info-value" id="modalName"></div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-clock" style="color:#1872B5;"></i> Submitted At</div>
                    <div class="info-value" id="modalDate"></div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-envelope" style="color:#1872B5;"></i> Email</div>
                    <div class="info-value" id="modalEmail"></div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-phone" style="color:#1872B5;"></i> Phone</div>
                    <div class="info-value" id="modalPhone"></div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-map-marker-alt" style="color:#1872B5;"></i> Address</div>
                    <div class="info-value" id="modalAddress"></div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-box" style="color:#1872B5;"></i> Product</div>
                    <div class="info-value" id="modalProduct"></div>
                </div>
            </div>
            <div class="section-divider">Message</div>
            <div class="info-label"><i class="fas fa-comment" style="color:#1872B5;"></i> Message</div>
            <div class="info-value message-box" id="modalMessage"></div>
        </div>
        <div class="view-modal-footer">
            <button class="btn btn-secondary btn-sm" onclick="closeViewModal()">
                <i class="fas fa-times"></i> Close
            </button>
            <a id="modalReplyBtn" href="#" class="btn btn-success btn-sm">
                <i class="fas fa-reply"></i> Reply via Email
            </a>
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
    // View Modal
    function openViewModal(id, name, email, phone, address, product, message, date) {
        document.getElementById('modalId').textContent = '#' + id;
        document.getElementById('modalName').textContent = name || '—';
        document.getElementById('modalDate').textContent = date || '—';
        document.getElementById('modalPhone').textContent = phone || '—';
        document.getElementById('modalProduct').textContent = product || 'Not provided';

        const emailEl = document.getElementById('modalEmail');
        emailEl.innerHTML = email ? '<a href="mailto:' + email + '">' + email + '</a>' : '—';

        const addrEl = document.getElementById('modalAddress');
        addrEl.textContent = address || 'Not provided';
        if (!address) addrEl.classList.add('empty'); else addrEl.classList.remove('empty');

        const msgEl = document.getElementById('modalMessage');
        msgEl.textContent = message || 'No message provided';
        if (!message) msgEl.classList.add('empty'); else msgEl.classList.remove('empty');

        document.getElementById('modalReplyBtn').href = 'mailto:' + email;
        document.getElementById('viewModal').classList.add('show');
    }
    function closeViewModal() {
        document.getElementById('viewModal').classList.remove('show');
    }

    // Delete Modal
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

    // Close modals on overlay click
    document.getElementById('viewModal').addEventListener('click', function(e) {
        if (e.target === this) closeViewModal();
    });
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // Auto dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert-success, .alert-danger').forEach(el => el.remove());
    }, 5000);
</script>

@endsection
