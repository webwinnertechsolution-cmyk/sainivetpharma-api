@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">📧 Contact Form Submissions</h2>
            
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

            <!-- Contact Submissions List -->
            <div class="card">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Contact Submissions</h5>
                    <span class="badge bg-primary fs-6">{{ $contacts->total() }} Total Contacts</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 150px;">Name</th>
                                    <th style="width: 180px;">Email</th>
                                    <th style="width: 120px;">Phone</th>
                                    <th>Product</th>
                                    <th style="width: 200px;">Message</th>
                                    <th style="width: 150px;">Submitted At</th>
                                    <th style="width: 120px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>
                                        <strong>{{ $contact->name }}</strong>
                                        @if($contact->address)
                                            <br><small class="text-muted">📍 {{ Str::limit($contact->address, 25) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope"></i> {{ $contact->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                                            <i class="fas fa-phone"></i> {{ $contact->phone }}
                                        </a>
                                    </td>
                                    <td>{{ $contact->product_name ?: '-' }}</td>
                                    <td>{{ Str::limit($contact->message, 50) ?: '-' }}</td>
                                    <td>
                                        <small>{{ $contact->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" 
                                                class="btn btn-sm btn-info mb-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewModal{{ $contact->id }}"
                                                title="View Full Details">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <form action="{{ route('admin.contacts.delete', $contact->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger mb-1"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                        
                                        <!-- View Modal -->
                                        <div class="modal fade" id="viewModal{{ $contact->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-info-circle"></i> Contact Details #{{ $contact->id }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="info-box mb-3">
                                                                    <label class="fw-bold text-primary">
                                                                        <i class="fas fa-user"></i> Name:
                                                                    </label>
                                                                    <p>{{ $contact->name }}</p>
                                                                </div>
                                                                
                                                                <div class="info-box mb-3">
                                                                    <label class="fw-bold text-primary">
                                                                        <i class="fas fa-envelope"></i> Email:
                                                                    </label>
                                                                    <p><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                                                                </div>
                                                                
                                                                <div class="info-box mb-3">
                                                                    <label class="fw-bold text-primary">
                                                                        <i class="fas fa-phone"></i> Phone:
                                                                    </label>
                                                                    <p><a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></p>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-6">
                                                                <div class="info-box mb-3">
                                                                    <label class="fw-bold text-primary">
                                                                        <i class="fas fa-map-marker-alt"></i> Address:
                                                                    </label>
                                                                    <p>{{ $contact->address ?: 'Not provided' }}</p>
                                                                </div>
                                                                
                                                                <div class="info-box mb-3">
                                                                    <label class="fw-bold text-primary">
                                                                        <i class="fas fa-box"></i> Product Name:
                                                                    </label>
                                                                    <p>{{ $contact->product_name ?: 'Not provided' }}</p>
                                                                </div>
                                                                
                                                                <div class="info-box mb-3">
                                                                    <label class="fw-bold text-primary">
                                                                        <i class="fas fa-clock"></i> Submitted:
                                                                    </label>
                                                                    <p>{{ $contact->created_at->format('d M Y, h:i A') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="info-box mb-3">
                                                            <label class="fw-bold text-primary">
                                                                <i class="fas fa-comment"></i> Message:
                                                            </label>
                                                            <div class="message-box p-3 bg-light rounded">
                                                                {{ $contact->message ?: 'No message provided' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="mailto:{{ $contact->email }}" class="btn btn-success">
                                                            <i class="fas fa-reply"></i> Reply via Email
                                                        </a>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <h5>No Contact Submissions Yet!</h5>
                                            <p class="mb-0">When someone fills the contact form, it will appear here.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($contacts->hasPages())
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $contacts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table td {
    vertical-align: middle;
}

.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border: none;
}

.info-box label {
    margin-bottom: 5px;
    display: block;
}

.info-box p {
    margin-bottom: 0;
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 5px;
}

.message-box {
    max-height: 200px;
    overflow-y: auto;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.btn-sm {
    font-size: 0.875rem;
}

/* Alert auto-fade */
.alert {
    animation: slideIn 0.5s ease-in-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover effect on table rows */
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}

/* Badge styling */
.badge {
    padding: 8px 15px;
}

/* Modal improvements */
.modal-header {
    border-bottom: 2px solid rgba(255,255,255,0.2);
}

.modal-footer {
    border-top: 2px solid #dee2e6;
}
</style>

<!-- Auto-dismiss alerts after 5 seconds -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>

@endsection
