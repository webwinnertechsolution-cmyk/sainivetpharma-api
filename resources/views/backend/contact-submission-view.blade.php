 
@extends('backend.layouts.layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Contact Submission Details</h2>
                <a href="{{ route('contact.submissions') }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Back to List
                </a>
            </div>
            
            <!-- Contact Details Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="mdi mdi-account-circle"></i> Submission from {{ $contact->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="text-muted mb-2"><i class="mdi mdi-account"></i> Full Name</label>
                                <h5>{{ $contact->name }}</h5>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted mb-2"><i class="mdi mdi-phone"></i> Phone Number</label>
                                <h5>
                                    <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                                        {{ $contact->phone }}
                                    </a>
                                </h5>
                            </div>

                            <div class="mb-4">
                                <label class="text-muted mb-2"><i class="mdi mdi-email"></i> Email Address</label>
                                <h5>
                                    <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                        {{ $contact->email }}
                                    </a>
                                </h5>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            @if($contact->address)
                                <div class="mb-4">
                                    <label class="text-muted mb-2"><i class="mdi mdi-map-marker"></i> Address</label>
                                    <h5>{{ $contact->address }}</h5>
                                </div>
                            @endif

                            @if($contact->product_name)
                                <div class="mb-4">
                                    <label class="text-muted mb-2"><i class="mdi mdi-package-variant"></i> Product Name</label>
                                    <h5>{{ $contact->product_name }}</h5>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="text-muted mb-2"><i class="mdi mdi-clock-outline"></i> Submitted On</label>
                                <h5>
                                    {{ $contact->created_at->format('F d, Y') }}
                                    <br>
                                    <small class="text-muted">{{ $contact->created_at->format('h:i A') }} ({{ $contact->created_at->diffForHumans() }})</small>
                                </h5>
                            </div>
                        </div>
                    </div>

                    <!-- Message Section -->
                    @if($contact->message)
                        <hr class="my-4">
                        <div class="mb-3">
                            <label class="text-muted mb-2"><i class="mdi mdi-message-text"></i> Message</label>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $contact->message }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <hr class="my-4">
                    <div class="d-flex gap-2">
                        <a href="mailto:{{ $contact->email }}" class="btn btn-success">
                            <i class="mdi mdi-email"></i> Reply via Email
                        </a>
                        <a href="tel:{{ $contact->phone }}" class="btn btn-info">
                            <i class="mdi mdi-phone"></i> Call
                        </a>
                        <button type="button" 
                                class="btn btn-danger ms-auto" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            <i class="mdi mdi-delete"></i> Delete Submission
                        </button>
                    </div>
                </div>
            </div>

            <!-- Additional Information Card -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="mdi mdi-information"></i> Additional Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Submission ID:</strong> #{{ $contact->id }}
                            </p>
                            <p class="mb-2">
                                <strong>Created:</strong> {{ $contact->created_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Last Updated:</strong> {{ $contact->updated_at->format('M d, Y h:i A') }}
                            </p>
                            <p class="mb-2">
                                <strong>Days Ago:</strong> {{ $contact->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this submission from <strong>{{ $contact->name }}</strong>?</p>
                <div class="alert alert-warning">
                    <i class="mdi mdi-alert"></i> This action cannot be undone. All data will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('contact.submission.delete', $contact->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="mdi mdi-delete"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

label.text-muted {
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.gap-2 {
    gap: 0.5rem !important;
}
</style>

@endsection
