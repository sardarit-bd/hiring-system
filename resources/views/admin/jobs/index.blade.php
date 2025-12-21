@extends('layouts.admin')

@section('title', 'Manage Jobs - ' . config('app.name'))

@section('page-title', 'Manage Jobs')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Jobs</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary me-2">All Jobs ({{ $jobs->total() }})</h6>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="fas fa-filter me-1"></i>Filters
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($jobs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Applications</th>
                                    <th>Deadline</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                    <tr>
                                        <td>{{ $job->id }}</td>
                                        <td>
                                            <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                                {{ Str::limit($job->title, 40) }}
                                            </a>
                                        </td>
                                        <td>{{ $job->employer->company_name ?? $job->employer->name }}</td>
                                        <td>{{ $job->category }}</td>
                                        <td>{{ $job->location }}</td>
                                        <td>
                                            @if($job->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($job->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                            
                                            @if($job->is_active && $job->deadline >= now())
                                                <span class="badge bg-primary">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $job->applications()->count() }}</span>
                                        </td>
                                        <td>{{ $job->deadline->format('M d, Y') }}</td>
                                        <td>
    <div class="btn-group btn-group-sm" role="group">
        <button type="button" class="btn btn-info" data-bs-toggle="modal" 
                data-bs-target="#jobModal{{ $job->id }}" title="View Details">
            <i class="fas fa-eye"></i>
        </button>
        
        @if($job->status === 'pending')
            <form action="{{ route('jobs.approve', $job) }}" method="POST" class="btn-group" role="group">
                @csrf
                <button type="submit" class="btn btn-success" title="Approve"
                        onclick="return confirm('Are you sure you want to approve this job?')">
                    <i class="fas fa-check"></i>
                </button>
            </form>
            <form action="{{ route('jobs.reject', $job) }}" method="POST" class="btn-group" role="group">
                @csrf
                <button type="submit" class="btn btn-danger" title="Reject"
                        onclick="return confirm('Are you sure you want to reject this job?')">
                    <i class="fas fa-times"></i>
                </button>
            </form>
        @endif
        
        @if($job->status === 'approved')
            <form action="{{ route('jobs.reject', $job) }}" method="POST" class="btn-group" role="group">
                @csrf
                <button type="submit" class="btn btn-warning" title="Reject"
                        onclick="return confirm('Are you sure you want to reject this job?')">
                    <i class="fas fa-times"></i>
                </button>
            </form>
        @endif
        
        @if($job->status === 'rejected')
            <form action="{{ route('jobs.approve', $job) }}" method="POST" class="btn-group" role="group">
                @csrf
                <button type="submit" class="btn btn-success" title="Approve"
                        onclick="return confirm('Are you sure you want to approve this job?')">
                    <i class="fas fa-check"></i>
                </button>
            </form>
        @endif
    </div>
</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $jobs->withQueryString()->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                        <h4>No jobs found</h4>
                        <p class="text-muted">Try adjusting your search filters.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Jobs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="GET" action="{{ route('admin.jobs') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Active Status</label>
                        <select name="active_status" class="form-select">
                            <option value="">All</option>
                            <option value="active" {{ request('active_status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="expired" {{ request('active_status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search jobs..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Job Details Modals -->
@foreach($jobs as $job)
<div class="modal fade" id="jobModal{{ $job->id }}" tabindex="-1" aria-labelledby="jobModalLabel{{ $job->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light px-5">
                <div class="d-flex w-100 align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="modal-title fw-bold" id="jobModalLabel{{ $job->id }}">
                            <i class="fas fa-briefcase me-2 text-primary"></i>
                            {{ $job->title }}
                        </h5>
                        <div class="text-muted small mt-1">
                            <i class="fas fa-building me-1"></i>
                            {{ $job->employer->company_name ?? $job->employer->name }}
                             <i class="fas fa-map-marker-alt ms-2 me-1"></i>
                            {{ $job->location }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            
            <div class="modal-body p-4">
                <!-- Status & Quick Info Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-info-circle me-1"></i> Job Status</h6>
                                <div class="d-flex flex-wrap align-items-center gap-2 mt-2">
                                    @if($job->status === 'approved')
                                        <span class="badge bg-success fs-6 py-2 px-3">
                                            <i class="fas fa-check-circle me-1"></i> Approved
                                        </span>
                                    @elseif($job->status === 'pending')
                                        <span class="badge bg-warning text-dark fs-6 py-2 px-3">
                                            <i class="fas fa-clock me-1"></i> Pending Review
                                        </span>
                                    @else
                                        <span class="badge bg-danger fs-6 py-2 px-3">
                                            <i class="fas fa-times-circle me-1"></i> Rejected
                                        </span>
                                    @endif
                                    
                                    @if($job->is_active && $job->deadline && $job->deadline >= now())
                                        <span class="badge bg-primary fs-6 py-2 px-3">
                                            <i class="fas fa-bolt me-1"></i> Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary fs-6 py-2 px-3">
                                            <i class="fas fa-ban me-1"></i> Inactive
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Applications</span>
                                        <span class="fw-bold">{{ $job->applications()->count() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Views</span>
                                        <span class="fw-bold">{{ $job->views }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted"><i class="fas fa-money-bill-wave me-1"></i> Salary Details</h6>
                                <div class="mt-2">
                                    @if($job->salary_min && $job->salary_max)
                                        <div class="d-flex align-items-center">
                                            <span class="fs-4 fw-bold text-success">${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</span>
                                            <span class="badge bg-light text-dark ms-2">{{ ucfirst($job->salary_type) }}</span>
                                        </div>
                                    @elseif($job->salary_min)
                                        <div class="fs-4 fw-bold text-success">${{ number_format($job->salary_min) }} {{ ucfirst($job->salary_type) }}</div>
                                    @else
                                        <div class="fs-5 text-muted">Negotiable Salary</div>
                                    @endif
                                </div>
                                
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Vacancy</span>
                                        <span class="fw-bold">{{ $job->vacancy }} position(s)</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Job Type</span>
                                        <span class="fw-bold text-capitalize">{{ str_replace('_', ' ', $job->job_type) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Deadline</span>
                                        <span class="fw-bold {{ $job->deadline && $job->deadline < now() ? 'text-danger' : 'text-success' }}">
                                            @if($job->deadline)
                                                {{ $job->deadline->format('M d, Y') }}
                                            @else
                                                Not set
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Tabs -->
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="jobTab{{ $job->id }}" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab{{ $job->id }}" data-bs-toggle="tab" 
                                        data-bs-target="#description{{ $job->id }}" type="button" role="tab">
                                    <i class="fas fa-file-alt me-1"></i> Description
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="requirements-tab{{ $job->id }}" data-bs-toggle="tab" 
                                        data-bs-target="#requirements{{ $job->id }}" type="button" role="tab">
                                    <i class="fas fa-tasks me-1"></i> Requirements
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="employer-tab{{ $job->id }}" data-bs-toggle="tab" 
                                        data-bs-target="#employer{{ $job->id }}" type="button" role="tab">
                                    <i class="fas fa-building me-1"></i> Employer
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content border border-top-0 rounded-bottom p-4" id="jobTabContent{{ $job->id }}">
                            <!-- Description Tab -->
                            <div class="tab-pane fade show active" id="description{{ $job->id }}" role="tabpanel">
                                <h6 class="text-primary mb-3"><i class="fas fa-align-left me-2"></i>Job Description</h6>
                                <div class="bg-light p-4 rounded">
                                    {!! nl2br(e($job->description)) !!}
                                </div>
                            </div>
                            
                            <!-- Requirements Tab -->
                            <div class="tab-pane fade" id="requirements{{ $job->id }}" role="tabpanel">
                                <h6 class="text-primary mb-3"><i class="fas fa-list-check me-2"></i>Job Requirements</h6>
                                <div class="bg-light p-4 rounded">
                                    {!! nl2br(e($job->requirements)) !!}
                                </div>
                            </div>
                            
                            <!-- Employer Tab -->
                            <div class="tab-pane fade" id="employer{{ $job->id }}" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Company Information</h6>
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                <span class="text-muted">Company Name</span>
                                                <span class="fw-bold">{{ $job->employer->company_name ?? 'Not provided' }}</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                <span class="text-muted">Contact Email</span>
                                                <span class="fw-bold">{{ $job->employer->email }}</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                <span class="text-muted">Phone</span>
                                                <span class="fw-bold">{{ $job->employer->phone ?? 'Not provided' }}</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                <span class="text-muted">Industry</span>
                                                <span class="fw-bold">{{ $job->employer->industry ?? 'Not specified' }}</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                                <span class="text-muted">Website</span>
                                                @if($job->employer->website)
                                                    <a href="{{ $job->employer->website }}" target="_blank" class="text-decoration-none">
                                                        <i class="fas fa-external-link-alt me-1"></i> Visit
                                                    </a>
                                                @else
                                                    <span class="text-muted">Not provided</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3"><i class="fas fa-calculator me-2"></i>Job Statistics</h6>
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <div class="row text-center">
                                                    <div class="col-6 mb-3">
                                                        <div class="display-6 fw-bold text-primary">{{ $job->vacancy }}</div>
                                                        <small class="text-muted">Vacancy</small>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <div class="display-6 fw-bold text-info">{{ $job->applications()->count() }}</div>
                                                        <small class="text-muted">Applications</small>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="display-6 fw-bold text-warning">{{ $job->views }}</div>
                                                        <small class="text-muted">Views</small>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="display-6 fw-bold text-success">
                                                            @if($job->deadline && $job->deadline >= now())
                                                                {{ round(now()->floatDiffInDays($job->deadline)) }}
                                                            @else
                                                                0
                                                            @endif
                                                        </div>

                                                        <small class="text-muted">Days Left</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary w-100" target="_blank">
                                            <i class="fas fa-external-link-alt me-2"></i> View Public Page
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="mailto:{{ $job->employer->email }}" class="btn btn-outline-success w-100">
                                            <i class="fas fa-envelope me-2"></i> Email Employer
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ route('admin.users') }}?search={{ urlencode($job->employer->email) }}&role=employer" 
                                           class="btn btn-outline-info w-100">
                                            <i class="fas fa-user-tie me-2"></i> Employer Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-center w-100">
                    <div class="text-muted small">
                        <i class="fas fa-calendar-plus me-1"></i>
                        Posted: {{ $job->created_at->format('M d, Y') }}
                        @if($job->updated_at && $job->updated_at != $job->created_at)
                            • Updated: {{ $job->updated_at->format('M d, Y') }}
                        @endif
                    </div>
                    <!-- <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                        <a href="{{ route('jobs.edit', $job) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit Job
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('styles')
<style>
    .modal {
        backdrop-filter: blur(2px);
    }
    
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
    }
    
    .btn-group-sm > .btn,
    .btn-group > .btn {
        border-radius: 0;
    }
    
    .btn-group-sm > .btn:first-child,
    .btn-group > .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    
    .btn-group-sm > .btn:last-child,
    .btn-group > .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
    
    /* Responsive styles for buttons */
    @media (max-width: 768px) {
        .btn-group {
            display: flex;
            flex-wrap: wrap;
        }
        
        .btn-group .btn {
            margin-bottom: 2px;
        }
        
        .modal-dialog {
            margin: 0.5rem;
        }
    }
</style>
@endpush
@endsection