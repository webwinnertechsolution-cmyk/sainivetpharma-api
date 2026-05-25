@extends('backend.layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Quotation Requests</h2>
                <span class="badge bg-primary fs-6">Total: {{ $quotations->total() }}</span>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Quotations Table -->
            <div class="card">
                <div class="card-body">
                    @if($quotations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Name</th>
                                        <th width="12%">Phone</th>
                                        <th width="18%">Email</th>
                                        <th width="15%">Product</th>
                                        <th width="10%">File</th>
                                        <th width="12%">Date</th>
                                        <th width="13%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotations as $index => $quotation)
                                        <tr>
                                            <td>{{ $quotation->id }}</td>
                                            <td>
                                                <strong>{{ $quotation->name }}</strong>
                                                @if($quotation->address)
                                                    <br><small class="text-muted"><i class="mdi mdi-map-marker"></i> {{ Str::limit($quotation->address, 30) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="tel:{{ $quotation->phone }}" class="text-decoration-none">
                                                    <i class="mdi mdi-phone"></i> {{ $quotation->phone }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $quotation->email }}" class="text-decoration-none">
                                                    <i class="mdi mdi-email"></i> {{ Str::limit($quotation->email, 25) }}
                                                </a>
                                            </td>
                                            <td>{{ $quotation->product_name }}</td>
                                            <td>
                                                @if($quotation->file_path)
                                                    <a href="/{{ $quotation->file_path }}" class="badge bg-info text-decoration-none" download>
                                                        <i class="mdi mdi-download"></i> Download
                                                    </a>
                                                @else
                                                    <span class="badge bg-secondary">No File</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>
                                                    {{ $quotation->created_at->format('M d, Y') }}<br>
                                                    <span class="text-muted">{{ $quotation->created_at->format('h:i A') }}</span>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('quotations.show', $quotation->id) }}" class="btn btn-sm btn-info text-white">
                                                    <i class="mdi mdi-eye"></i> View
                                                </a>
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
                                    Showing {{ $quotations->firstItem() }} to {{ $quotations->lastItem() }} of {{ $quotations->total() }} submissions
                                </p>
                            </div>
                            <div>
                                {{ $quotations->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-file-document-outline" style="font-size: 72px; color: #ccc;"></i>
                            <h4 class="mt-3 text-muted">No quotation requests yet</h4>
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
.badge {
    padding: 8px 12px;
}
</style>
@endsection
