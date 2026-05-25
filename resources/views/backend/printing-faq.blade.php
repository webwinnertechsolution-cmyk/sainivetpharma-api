@extends('backend.layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Printing FAQ</h2>
            
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

            <!-- Add/Edit Form -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" id="formTitle">
                        {{ isset($editPrintingFaq) ? 'Edit Printing FAQ' : 'Add New Printing FAQ' }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editPrintingFaq) ? route('printing-faq.update', $editPrintingFaq->id) : route('printing-faq.store') }}" 
                          method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="heading" class="form-label">Heading</label>
                                    <input type="text" 
                                           class="form-control @error('heading') is-invalid @enderror" 
                                           id="heading" 
                                           name="heading" 
                                           value="{{ old('heading', isset($editPrintingFaq) ? $editPrintingFaq->heading : '') }}"
                                           placeholder="Enter heading">
                                    @error('heading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="editor" 
                                              name="description" 
                                              rows="6"
                                              placeholder="Enter description">{{ old('description', isset($editPrintingFaq) ? $editPrintingFaq->description : '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        @if(isset($editPrintingFaq))
                            <a href="{{ route('printing-faq') }}" class="btn btn-secondary me-md-2">
                                Cancel Edit
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update Printing FAQ
                            </button>
                        @else
                            <button type="reset" class="btn btn-secondary me-md-2">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Printing FAQ
                            </button>
                        @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Printing FAQs List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">All Printing FAQs ({{ $printingFaqCount }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Heading</th>
                                    <th>Description</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($printingFaqs as $printingFaq)
                                <tr>
                                    <td>{{ $printingFaq->id }}</td>
                                    <td>{{ Str::limit($printingFaq->heading, 50) ?: '-' }}</td>
                                    <td>{{ Str::limit(strip_tags($printingFaq->description), 100) ?: '-' }}</td>
                                    <td>
                                        <small>{{ $printingFaq->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $printingFaq->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('printing-faq.edit', $printingFaq->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('printing-faq.delete', $printingFaq->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this printing FAQ?');">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger mb-1"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-question-circle fa-3x mb-3"></i>
                                            <p class="mb-0">No printing FAQs found. Add your first printing FAQ above!</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
}
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection
