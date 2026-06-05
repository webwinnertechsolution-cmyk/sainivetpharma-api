 
@extends('backend.layouts.layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Contact Form Submissions</h2>
                <span class="badge bg-primary fs-6">Total: {{ $contacts->total() }}</span>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
             {{-- FILTER FORM --}}
<form method="GET" action="{{ route('admin.contacts') }}">
    <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 16px; margin-bottom: 20px;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end;">
            
            <div style="flex: 1; min-width: 180px;">
                <label style="font-size: 11px; font-weight: 700; color: #374151; display: block; margin-bottom: 5px;">
                    🔍 Search
                </label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Name, email, phone..."
                    style="width: 100%; border: 1.5px solid #e5e7eb; border-radius: 6px; padding: 7px 10px; font-size: 12px;">
            </div>

            <div style="min-width: 150px;">
                <label style="font-size: 11px; font-weight: 700; color: #374151; display: block; margin-bottom: 5px;">
                    📅 From Date
                </label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    style="width: 100%; border: 1.5px solid #e5e7eb; border-radius: 6px; padding: 7px 10px; font-size: 12px;">
            </div>

            <div style="min-width: 150px;">
                <label style="font-size: 11px; font-weight: 700; color: #374151; display: block; margin-bottom: 5px;">
                    📅 To Date
                </label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    style="width: 100%; border: 1.5px solid #e5e7eb; border-radius: 6px; padding: 7px 10px; font-size: 12px;">
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit"
                    style="background: linear-gradient(135deg, #1872B5, #2596e1); color: white; border: none; padding: 7px 16px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer;">
                    Apply Filter
                </button>
                <a href="{{ route('admin.contacts') }}"
                    style="background: #e5e7eb; color: #374151; padding: 7px 16px; border-radius: 6px; font-size: 11px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center;">
                    Reset
                </a>
            </div>
        </div>

        @if(request('date_from') || request('date_to') || request('search'))
        <div style="margin-top: 10px; font-size: 11px; color: #6b7280;">
            Filtered results
            @if(request('search')) — Search: <strong>{{ request('search') }}</strong> @endif
            @if(request('date_from')) — From: <strong>{{ request('date_from') }}</strong> @endif
            @if(request('date_to')) — To: <strong>{{ request('date_to') }}</strong> @endif
            · Total: <strong>{{ $contacts->total() }}</strong> records
        </div>
        @endif
    </div>
</form>
            <!-- Contact Submissions Table -->
            <div class="card">
                <div class="card-body">
                    @if($contacts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Name</th>
                                        <th width="12%">Phone</th>
                                        <th width="18%">Email</th>
                                        <th width="15%">Product</th>
                                        <th width="12%">Date</th>
                                        <th width="23%" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $index => $contact)
                                        <tr>
                                            <td>{{ $contacts->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $contact->name }}</strong>
                                                @if($contact->address)
                                                    <br><small class="text-muted"><i class="mdi mdi-map-marker"></i> {{ Str::limit($contact->address, 30) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                                                    <i class="mdi mdi-phone"></i> {{ $contact->phone }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                                    <i class="mdi mdi-email"></i> {{ Str::limit($contact->email, 25) }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $contact->product_name ?: '-' }}
                                            </td>
                                            <td>
                                                <small>
                                                    {{ $contact->created_at->format('M d, Y') }}<br>
                                                    <span class="text-muted">{{ $contact->created_at->format('h:i A') }}</span>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('contact.submission.view', $contact->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="View Details">
                                                        <i class="mdi mdi-eye"></i> View
                                                    </a>
                                                    
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteModal{{ $contact->id }}"
                                                            title="Delete">
                                                        <i class="mdi mdi-delete"></i> Delete
                                                    </button>
                                                </div>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{ $contact->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title">Confirm Delete</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this submission from <strong>{{ $contact->name }}</strong>?</p>
                                                                <p class="text-muted mb-0">This action cannot be undone.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <form action="{{ route('contact.submission.delete', $contact->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="mdi mdi-delete"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-0">
                                    Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of {{ $contacts->total() }} submissions
                                </p>
                            </div>
                            <div>
                                {{ $contacts->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-email-outline" style="font-size: 72px; color: #ccc;"></i>
                            <h4 class="mt-3 text-muted">No contact submissions yet</h4>
                            <p class="text-muted">Contact submissions will appear here when visitors submit the form.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.btn-group .btn {
    margin: 0;
}

.badge {
    padding: 8px 15px;
}


</style>



@endsection
