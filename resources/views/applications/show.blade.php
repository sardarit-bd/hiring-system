@extends('layouts.app')

@section('title', 'Application Details - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <!-- Back Navigation -->
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="text-decoration-none d-inline-flex align-items-center text-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    <span>Back</span>
                </a>
            </div>

            <!-- Main Card -->
            <div class="card border-0 shadow-lg">
                <!-- Card Header -->
                <div class="card-header bg-white border-bottom-0 pt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h4 mb-1 fw-bold text-dark">Application Details</h2>
                            <p class="text-muted mb-0">Application ID: #{{ str_pad($application->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        @php
                            $statusColors = [
                                'pending' => ['bg' => 'bg-warning-subtle', 'text' => 'text-warning-emphasis', 'border' => 'border-warning-subtle'],
                                'reviewed' => ['bg' => 'bg-info-subtle', 'text' => 'text-info-emphasis', 'border' => 'border-info-subtle'],
                                'shortlisted' => ['bg' => 'bg-primary-subtle', 'text' => 'text-primary-emphasis', 'border' => 'border-primary-subtle'],
                                'hired' => ['bg' => 'bg-success-subtle', 'text' => 'text-success-emphasis', 'border' => 'border-success-subtle'],
                                'rejected' => ['bg' => 'bg-danger-subtle', 'text' => 'text-danger-emphasis', 'border' => 'border-danger-subtle']
                            ];
                            $statusConfig = $statusColors[$application->status];
                        @endphp
                        <div class="d-flex flex-column align-items-end">
                            <span class="badge {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }} border px-3 py-2 mb-2 rounded-pill fw-medium">
                                <i class="fas fa-circle fa-xs me-1"></i>
                                {{ ucfirst($application->status) }}
                            </span>
                            <small class="text-muted">Applied: {{ $application->applied_at->format('M d, Y') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">
                    <!-- Job & Applicant Info -->
                    <div class="row g-4 mb-5">
                        <!-- Job Information Card -->
                        <div class="col-md-6">
                            <div class="card h-100 border">
                                <div class="card-header bg-light py-3">
                                    <h5 class="mb-0 fw-semibold">
                                        <i class="fas fa-briefcase me-2 text-primary"></i>
                                        Job Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6 class="fw-bold text-dark mb-1">{{ $application->job->title }}</h6>
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-building me-1"></i>
                                            {{ $application->job->employer->company_name ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                <small>{{ $application->job->location }}</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fas fa-clock me-2"></i>
                                                <small>{{ ucfirst(str_replace('_', ' ', $application->job->job_type)) }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Applicant Information Card -->
                        <div class="col-md-6">
                            <div class="card h-100 border">
                                <div class="card-header bg-light py-3">
                                    <h5 class="mb-0 fw-semibold">
                                        <i class="fas fa-user me-2 text-success"></i>
                                        Applicant Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6 class="fw-bold text-dark mb-1">{{ $application->jobSeeker->name }}</h6>
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-envelope me-1"></i>
                                            {{ $application->jobSeeker->email }}
                                        </p>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fas fa-phone me-2"></i>
                                                <small>{{ $application->jobSeeker->phone ?? 'Not provided' }}</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fas fa-calendar me-2"></i>
                                                <small>{{ $application->applied_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Update Section -->
                    @if(auth()->user()->isEmployer() && $application->job->employer_id === auth()->id())
                    <div class="card border mb-5">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="fas fa-sync-alt me-2 text-info"></i>
                                Update Application Status
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('applications.status', $application) }}" method="POST" class="row g-3 align-items-end">
                                @csrf
                                @method('PATCH')
                                <div class="col-md-6">
                                    <!-- <label class="form-label fw-medium">Change Status</label> -->
                                    <select name="status" class="form-select" required>
                                        <option value="">Select new status...</option>
                                        <option value="reviewed" data-icon="fa-eye">Reviewed</option>
                                        <option value="shortlisted" data-icon="fa-list">Shortlisted</option>
                                        <option value="hired" data-icon="fa-check-circle">Hired</option>
                                        <option value="rejected" data-icon="fa-times-circle">Rejected</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check me-2"></i>
                                        Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Cover Letter Section -->
                    <div class="card border mb-5">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="fas fa-file-alt me-2 text-warning"></i>
                                Cover Letter
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="p-3 bg-light-subtle rounded border">
                                {!! nl2br(e($application->cover_letter)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Resume Download -->
                    @if($application->resume_path)
                    <div class="card border mb-5">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="fas fa-file-pdf me-2 text-danger"></i>
                                Resume 
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="fw-medium mb-1">
                                        <a href="{{ Storage::url($application->resume_path) }}" target="_blank" 
                                   class="">
                                    {{ basename($application->resume_path) }}
                                        </a>
                                    </h6>
                                    <!-- <small class="text-muted">
                                        <i class="fas fa-download me-1"></i>
                                        Click to download
                                    </small> -->
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Notes Section -->
                    @if(auth()->user()->isEmployer() && $application->job->employer_id === auth()->id())
                    <div class="card border">
                        <!-- <div class="card-header bg-light py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="fas fa-sticky-note me-2 text-secondary"></i>
                                Add Notes
                            </h5>
                        </div> -->
                        <div class="card-body">
                            @if($application->notes)
                            <div class="mb-4 p-3 bg-light-subtle rounded border">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Last updated: {{ $application->updated_at->format('M d, Y H:i') }}
                                    </small>
                                </div>
                                {!! nl2br(e($application->notes)) !!}
                            </div>
                            @endif
                            
                            <form action="{{ route('applications.status', $application) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label class="form-label fw-medium">
                                        {{ $application->notes ? 'Update Notes' : 'Add Notes' }}
                                    </label>
                                    <textarea name="notes" class="form-control" rows="4" 
                                              placeholder="Add private notes about this candidate...">{{ old('notes', $application->notes) }}</textarea>
                                    <!-- <div class="form-text">
                                        These notes are only visible to you and your team.
                                    </div> -->
                                </div>
                                <input type="hidden" name="status" value="{{ $application->status }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    {{ $application->notes ? 'Update Notes' : 'Save Notes' }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }
    
    /* .card:hover {
        transform: translateY(-2px);
    } */
    
    .badge {
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .form-select, .form-control {
        border: 1px solid #dee2e6;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
    }
    
    .text-primary {
        color: #0d6efd !important;
    }
    
    .bg-light-subtle {
        background-color: rgba(248, 249, 250, 0.7) !important;
    }
</style>
@endpush
@endsection