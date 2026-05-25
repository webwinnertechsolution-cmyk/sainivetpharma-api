@extends('backend.layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Quotation Details</h2>
                <a href="{{ route('quotations.index') }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Back to List
                </a>
            </div>

            <div class="card">
                <div class="card-header bg-white py-3">
                    <h4 class="card-title mb-0">Request #{{ $quotation->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Client Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="35%" class="bg-light">Name</th>
                                    <td>{{ $quotation->name }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Email</th>
                                    <td>
                                        <a href="mailto:{{ $quotation->email }}">{{ $quotation->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Phone</th>
                                    <td>
                                        <a href="tel:{{ $quotation->phone }}">{{ $quotation->phone }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Address</th>
                                    <td>{{ $quotation->address }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Project Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="35%" class="bg-light">Product Name</th>
                                    <td>{{ $quotation->product_name }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Submission Date</th>
                                    <td>{{ $quotation->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Uploaded File</th>
                                    <td>
                                        @if($quotation->file_path)
                                            <div class="d-flex align-items-center">
                                                <i class="mdi mdi-file-outline fs-3 text-info me-2"></i>
                                                <div>
                                                    <a href="/{{ $quotation->file_path }}" class="btn btn-sm btn-primary text-white" download>
                                                        <i class="mdi mdi-download"></i> Download File
                                                    </a>
                                                    <small class="d-block text-muted mt-1">{{ basename($quotation->file_path) }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">No File Uploaded</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="text-muted small">
                        Submitted from IP: {{ request()->ip() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
