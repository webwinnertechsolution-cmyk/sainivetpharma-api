@extends('backend.layouts.layout')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Footer Main - Location Addresses</h2>
            
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
            <div class="card mb-4 {{ !$canAdd && !isset($editFooter) ? 'opacity-50' : '' }}">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" id="formTitle">
                        {{ isset($editFooter) ? 'Edit Footer Locations' : 'Add Footer Locations' }}
                        @if(!$canAdd && !isset($editFooter))
                            <span class="badge bg-warning text-dark ms-2">Limit Reached (Max 1 Item)</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($editFooter) ? route('footermain.update', $editFooter->id) : route('footermain.store') }}" 
                          method="POST">
                        @csrf
                        
                        <fieldset {{ !$canAdd && !isset($editFooter) ? 'disabled' : '' }}>
                            
                            <!-- Location 1 Section -->
                            <div class="card mb-4 border-primary">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-map-marker-alt text-danger"></i> Location 1</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Location 1 Icon -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="location1_icon" class="form-label">Icon Class *</label>
                                                <input type="text" 
                                                       class="form-control @error('location1_icon') is-invalid @enderror" 
                                                       id="location1_icon" 
                                                       name="location1_icon" 
                                                       value="{{ old('location1_icon', isset($editFooter) ? $editFooter->location1_icon : 'fas fa-map-marker-alt') }}"
                                                       placeholder="fas fa-map-marker-alt"
                                                       required>
                                                @error('location1_icon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">
                                                    Use Font Awesome classes (e.g., fas fa-map-marker-alt)
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Location 1 Text -->
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="location1_text" class="form-label">Location Address 1 *</label>
                                                <textarea class="form-control @error('location1_text') is-invalid @enderror" 
                                                       id="location1_text" 
                                                       name="location1_text" 
                                                       rows="3"
                                                       placeholder="Enter location address 1"
                                                       required>{{ old('location1_text', isset($editFooter) ? $editFooter->location1_text : '') }}</textarea>
                                                @error('location1_text')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">
                                                    Example: RED Engineers | <span style="color:#DA200B">RED-</span>LABS<br>A04/216 Harbour Road, Mackay Harbour. QLD 4740
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location 2 Section -->
                            <div class="card mb-4 border-success">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-map-marker-alt text-danger"></i> Location 2</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Location 2 Icon -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="location2_icon" class="form-label">Icon Class *</label>
                                                <input type="text" 
                                                       class="form-control @error('location2_icon') is-invalid @enderror" 
                                                       id="location2_icon" 
                                                       name="location2_icon" 
                                                       value="{{ old('location2_icon', isset($editFooter) ? $editFooter->location2_icon : 'fas fa-map-marker-alt') }}"
                                                       placeholder="fas fa-map-marker-alt"
                                                       required>
                                                @error('location2_icon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">
                                                    Use Font Awesome classes (e.g., fas fa-map-marker-alt)
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Location 2 Text -->
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="location2_text" class="form-label">Location Address 2 *</label>
                                                <textarea class="form-control @error('location2_text') is-invalid @enderror" 
                                                       id="location2_text" 
                                                       name="location2_text" 
                                                       rows="3"
                                                       placeholder="Enter location address 2"
                                                       required>{{ old('location2_text', isset($editFooter) ? $editFooter->location2_text : '') }}</textarea>
                                                @error('location2_text')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">
                                                    Example: Suite 1870/324 Queen St, Brisbane City, QLD, 4000
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Copyright Section -->
                            <div class="card mb-4 border-info">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-copyright text-info"></i> Copyright Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Copyright Year -->
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="copyright_year" class="form-label">Copyright Year *</label>
                                                <input type="text" 
                                                       class="form-control @error('copyright_year') is-invalid @enderror" 
                                                       id="copyright_year" 
                                                       name="copyright_year" 
                                                       value="{{ old('copyright_year', isset($editFooter) ? $editFooter->copyright_year : date('Y')) }}"
                                                       placeholder="2024"
                                                       required>
                                                @error('copyright_year')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Copyright Text -->
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="copyright_text" class="form-label">Copyright Text *</label>
                                                <input type="text" 
                                                       class="form-control @error('copyright_text') is-invalid @enderror" 
                                                       id="copyright_text" 
                                                       name="copyright_text" 
                                                       value="{{ old('copyright_text', isset($editFooter) ? $editFooter->copyright_text : 'Red-Labs') }}"
                                                       placeholder="Red-Labs"
                                                       required>
                                                @error('copyright_text')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Powered By Text -->
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="powered_by_text" class="form-label">Powered By Text *</label>
                                                <input type="text" 
                                                       class="form-control @error('powered_by_text') is-invalid @enderror" 
                                                       id="powered_by_text" 
                                                       name="powered_by_text" 
                                                       value="{{ old('powered_by_text', isset($editFooter) ? $editFooter->powered_by_text : 'Red Engineers') }}"
                                                       placeholder="Red Engineers"
                                                       required>
                                                @error('powered_by_text')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Powered By Link -->
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="powered_by_link" class="form-label">Powered By Link *</label>
                                                <input type="url" 
                                                       class="form-control @error('powered_by_link') is-invalid @enderror" 
                                                       id="powered_by_link" 
                                                       name="powered_by_link" 
                                                       value="{{ old('powered_by_link', isset($editFooter) ? $editFooter->powered_by_link : 'https://redengineers.com.au/') }}"
                                                       placeholder="https://redengineers.com.au/"
                                                       required>
                                                @error('powered_by_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                @if(isset($editFooter))
                                    <a href="{{ route('footermain') }}" class="btn btn-secondary me-md-2">
                                        Cancel Edit
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update Footer Locations
                                    </button>
                                @else
                                    <button type="reset" class="btn btn-secondary me-md-2">
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary" {{ !$canAdd ? 'disabled' : '' }}>
                                        <i class="fas fa-plus"></i> Add Footer Locations
                                    </button>
                                @endif
                            </div>
                        </fieldset>
                        
                        @if(!$canAdd && !isset($editFooter))
                            <div class="alert alert-warning mt-3 mb-0">
                                <i class="fas fa-info-circle"></i> Only one footer configuration is allowed. Please delete the existing item to add a new one.
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Footer Main List -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Current Footer Locations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th style="width: 150px;">Location 1 Icon</th>
                                    <th>Location 1 Address</th>
                                    <th style="width: 150px;">Location 2 Icon</th>
                                    <th>Location 2 Address</th>
                                    <th style="width: 150px;">Created At</th>
                                    <th style="width: 150px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($footers as $footer)
                                <tr>
                                    <td>{{ $footer->id }}</td>
                                    <td class="text-center">
                                        <i class="{{ $footer->location1_icon }} fa-2x text-danger"></i>
                                        <br>
                                        <small class="text-muted">{{ $footer->location1_icon }}</small>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 250px;" title="{{ $footer->location1_text }}">
                                            {{ Str::limit($footer->location1_text, 100) }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <i class="{{ $footer->location2_icon }} fa-2x text-danger"></i>
                                        <br>
                                        <small class="text-muted">{{ $footer->location2_icon }}</small>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 250px;" title="{{ $footer->location2_text }}">
                                            {{ Str::limit($footer->location2_text, 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $footer->created_at->format('d M Y') }}</small><br>
                                        <small class="text-muted">{{ $footer->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('footermain.edit', $footer->id) }}" 
                                           class="btn btn-sm btn-warning mb-1"
                                           title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('footermain.delete', $footer->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this footer configuration?');">
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
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                                            <p class="mb-0">No footer locations found. Add your locations above!</p>
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
.opacity-50 {
    opacity: 0.6;
    pointer-events: none;
}
</style>

@endsection
