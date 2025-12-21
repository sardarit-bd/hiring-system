@extends('layouts.app')

@section('title', 'Job Seeker Dashboard - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Left Sidebar - Profile Summary -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-4">
                    <!-- Profile Picture with Upload Option -->
                    <div class="mb-4">
                        <div class="position-relative d-inline-block">
                            <!-- Profile Picture -->
                            <div id="profile-picture-container">
                                @if(Auth::user()->profile_picture)
                                    <img id="profile-picture-img" 
                                        src="{{ Storage::url(Auth::user()->profile_picture) }}" 
                                        alt="Profile" 
                                        class="rounded-circle shadow" 
                                        width="120" 
                                        height="120"
                                        style="object-fit: cover;">
                                @else
                                    <img id="profile-picture-img" 
                                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=fff&size=120&bold=true" 
                                        alt="Profile" 
                                        class="rounded-circle shadow" 
                                        width="120" 
                                        height="120">
                                @endif
                            </div>
                            
                            <!-- Upload Button -->
                            <span id="upload-profile-picture" 
                                class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 border border-3 border-white d-flex align-items-center justify-content-center"
                                style="cursor: pointer; width: 36px; height: 36px;"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="Change profile picture">
                                <i class="fas fa-camera text-white" style="font-size: 14px;"></i>
                            </span>
                            
                            <!-- Verified Badge -->
                            <span class="position-absolute bottom-0 start-0 bg-success rounded-circle p-2 border border-3 border-white d-flex align-items-center justify-content-center"
                                style="width: 36px; height: 36px;">
                                <i class="fas fa-check text-white" style="font-size: 12px;"></i>
                            </span>
                        </div>
                        
                        <!-- Profile Picture Upload Form (Hidden) -->
                        <form id="profile-picture-form" method="POST" enctype="multipart/form-data" style="display: none;">
                            @csrf
                            <input type="file" 
                                   id="profile-picture-input" 
                                   name="profile_picture" 
                                   accept="image/*"
                                   class="form-control d-none">
                        </form>
                        
                        <!-- Remove Button (Only show if has picture) -->
                        @if(Auth::user()->profile_picture)
                        <div class="mt-2">
                            <button id="remove-profile-picture" 
                                    class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash-alt me-1"></i> Remove Photo
                            </button>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Name and Title -->
                    <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-3">
                        <i class="fas fa-briefcase me-1"></i>
                        {{ Auth::user()->jobSeekerProfile->professional_title ?? 'Job Seeker' }}
                    </p>
                    
                    <!-- Profile Completion -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-sm text-muted">Profile Completion</span>
                            <span class="text-sm fw-bold">{{ Auth::user()->jobSeekerProfile->profile_completion ?? 0 }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-gradient-primary" role="progressbar" 
                                 style="width: {{ Auth::user()->jobSeekerProfile->profile_completion ?? 0 }}%;" 
                                 aria-valuenow="{{ Auth::user()->jobSeekerProfile->profile_completion ?? 0 }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                        @if((Auth::user()->jobSeekerProfile->profile_completion ?? 0) < 70)
                            <small class="text-warning d-block mt-2">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                Complete your profile for better job matches
                            </small>
                        @endif
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="list-group list-group-flush border-top">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                            <span>
                                <i class="fas fa-file-alt text-primary me-2"></i>
                                Applications
                            </span>
                            <span class="badge bg-primary rounded-pill">{{ Auth::user()->applications()->count() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                            <span>
                                <i class="fas fa-eye text-info me-2"></i>
                                Profile Views
                            </span>
                            <span class="badge bg-info rounded-pill">0</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                            <span>
                                <i class="fas fa-star text-warning me-2"></i>
                                Shortlisted
                            </span>
                            <span class="badge bg-warning rounded-pill">0</span>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="mt-4">
                        <a href="{{ route('job-seeker.profile.edit') }}" class="btn btn-primary btn-sm w-100 mb-2">
                            <i class="fas fa-user-edit me-1"></i> Edit Profile
                        </a>
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-primary btn-sm w-100 mb-2">
                            <i class="fas fa-search me-1"></i> Find Jobs
                        </a>
                        <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-history me-1"></i> Applications
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Skills Card -->
            <!-- <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-code me-2 text-primary"></i>
                        Top Skills
                    </h6>
                </div>
                <div class="card-body">
                    @if(Auth::user()->skills)
                        @php
                            $skills = json_decode(Auth::user()->skills, true);
                            $skills = is_array($skills) ? array_slice($skills, 0, 8) : [];
                        @endphp
                        @foreach($skills as $skill)
                            <span class="badge bg-light text-dark border mb-2 me-1 px-3 py-2">
                                {{ $skill }}
                            </span>
                        @endforeach
                        @if(count($skills) === 0)
                            <p class="text-muted text-center mb-0">No skills added</p>
                        @endif
                    @else
                        <p class="text-muted text-center mb-0">No skills added</p>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="btn btn-link btn-sm d-block mt-2">
                        <i class="fas fa-plus me-1"></i> Add More Skills
                    </a>
                </div>
            </div> -->
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Welcome Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="">
                            <h3 class="text-center">Welcome back, <span class="text-primary">{{ Auth::user()->name }}!</span></h3>
                            <!-- <p class="text-muted mb-0">
                                @if(Auth::user()->jobSeekerProfile && Auth::user()->jobSeekerProfile->summary)
                                    {{ Str::limit(Auth::user()->jobSeekerProfile->summary, 200) }}
                                @else
                                    Complete your profile to get personalized job recommendations and increase your chances of getting hired.
                                @endif
                            </p> -->
                        </div>
                        <!-- <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="d-grid gap-2">
                                <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-search me-2"></i> Browse Jobs
                                </a>
                                <a href="{{ route('job-seeker.profile.edit') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-user-edit me-2"></i> Edit Profile
                                </a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            
            <!-- Profile Sections -->
            <div class="row">
                <!-- Education -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-graduation-cap text-primary me-2"></i>
                                Education
                            </h5>
                            <a href="{{ route('job-seeker.profile.edit') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            @if(Auth::user()->educations->count() > 0)
                                @foreach(Auth::user()->educations->take(2) as $education)
                                    <div class="border-start border-3 border-primary ps-3 mb-3">
                                        <h6 class="mb-1">{{ $education->degree }}</h6>
                                        <p class="text-muted mb-1">{{ $education->institution }}</p>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $education->start_year }} - 
                                            {{ $education->is_current ? 'Present' : $education->end_year }}
                                        </small>
                                        @if($education->result)
                                            <div class="mt-1">
                                                <span class="badge bg-light text-dark">
                                                    Result: {{ $education->result }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                @if(Auth::user()->educations->count() > 2)
                                    <div class="text-center">
                                        <a href="{{ route('job-seeker.profile.edit') }}" class="text-primary">
                                            +{{ Auth::user()->educations->count() - 2 }} more
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-2">No education added yet</p>
                                    <a href="{{ route('job-seeker.profile.edit') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus me-1"></i> Add Education
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Experience -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-briefcase text-success me-2"></i>
                                Experience
                            </h5>
                            <a href="{{ route('job-seeker.profile.edit') }}" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            @if(Auth::user()->experiences->count() > 0)
                                @foreach(Auth::user()->experiences->take(2) as $experience)
                                    <div class="border-start border-3 border-success ps-3 mb-3">
                                        <h6 class="mb-1">{{ $experience->job_title }}</h6>
                                        <p class="text-muted mb-1">{{ $experience->company_name }}</p>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $experience->period }}
                                            @if($experience->duration)
                                                <span class="ms-2">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $experience->duration }}
                                                </span>
                                            @endif
                                        </small>
                                        @if($experience->location)
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $experience->location }}
                                            </small>
                                        @endif
                                    </div>
                                @endforeach
                                @if(Auth::user()->experiences->count() > 2)
                                    <div class="text-center">
                                        <a href="{{ route('job-seeker.profile.edit') }}" class="text-success">
                                            +{{ Auth::user()->experiences->count() - 2 }} more
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-2">No experience added yet</p>
                                    <a href="{{ route('job-seeker.profile.edit') }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i> Add Experience
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Projects -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-project-diagram text-info me-2"></i>
                                Projects
                            </h5>
                            <a href="{{ route('job-seeker.profile.edit') }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            @if(Auth::user()->projects->count() > 0)
                                @foreach(Auth::user()->projects->take(2) as $project)
                                    <div class="border-start border-3 border-info ps-3 mb-3">
                                        <h6 class="mb-1">{{ $project->project_name }}</h6>
                                        @if($project->technologies && count($project->technologies) > 0)
                                            <div class="mb-2">
                                                @foreach(array_slice($project->technologies, 0, 3) as $tech)
                                                    <span class="badge bg-light text-dark border mb-1 me-1">
                                                        {{ $tech }}
                                                    </span>
                                                @endforeach
                                                @if(count($project->technologies) > 3)
                                                    <span class="badge bg-secondary mb-1">
                                                        +{{ count($project->technologies) - 3 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="d-flex gap-2 mt-2">
                                            @if($project->github_link)
                                                <a href="{{ $project->github_link }}" target="_blank" 
                                                   class="btn btn-sm btn-outline-dark">
                                                    <i class="fab fa-github me-1"></i> GitHub
                                                </a>
                                            @endif
                                            @if($project->live_link)
                                                <a href="{{ $project->live_link }}" target="_blank" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-external-link-alt me-1"></i> Live Demo
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                @if(Auth::user()->projects->count() > 2)
                                    <div class="text-center">
                                        <a href="{{ route('job-seeker.profile.edit') }}" class="text-info">
                                            +{{ Auth::user()->projects->count() - 2 }} more
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-2">No projects added yet</p>
                                    <a href="{{ route('job-seeker.profile.edit') }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-plus me-1"></i> Add Project
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Certifications -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                            <h5 class="mb-0">
                                <i class="fas fa-certificate text-warning me-2"></i>
                                Certifications
                            </h5>
                            <a href="{{ route('job-seeker.profile.edit') }}" class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            @if(Auth::user()->certifications->count() > 0)
                                @foreach(Auth::user()->certifications->take(2) as $certification)
                                    <div class="border-start border-3 border-warning ps-3 mb-3">
                                        <h6 class="mb-1">{{ $certification->certification_name }}</h6>
                                        <p class="text-muted mb-1">{{ $certification->issuing_organization }}</p>
                                        <small class="text-muted d-block">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            Issued: {{ $certification->issue_date->format('M Y') }}
                                            @if($certification->expiration_date && !$certification->does_not_expire)
                                                <span class="ms-2">
                                                    <i class="fas fa-calendar-times me-1"></i>
                                                    Expires: {{ $certification->expiration_date->format('M Y') }}
                                                </span>
                                            @endif
                                        </small>
                                        @if($certification->is_valid)
                                            <span class="badge bg-success mt-2">
                                                <i class="fas fa-check me-1"></i> Valid
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                                @if(Auth::user()->certifications->count() > 2)
                                    <div class="text-center">
                                        <a href="{{ route('job-seeker.profile.edit') }}" class="text-warning">
                                            +{{ Auth::user()->certifications->count() - 2 }} more
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-certificate fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-2">No certifications added yet</p>
                                    <a href="{{ route('job-seeker.profile.edit') }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-plus me-1"></i> Add Certification
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt text-danger me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <a href="{{ route('profile.edit') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-file-alt text-primary fa-2x"></i>
                                    </div>
                                    <h6 class="mb-0">Update Resume</h6>
                                    <small class="text-muted">Upload your CV</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a href="{{ route('jobs.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-search text-success fa-2x"></i>
                                    </div>
                                    <h6 class="mb-0">Find Jobs</h6>
                                    <small class="text-muted">Browse opportunities</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a href="{{ route('applications.index') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-history text-info fa-2x"></i>
                                    </div>
                                    <h6 class="mb-0">Applications</h6>
                                    <small class="text-muted">View your applications</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a href="{{ route('job-seeker.profile.edit') }}" class="card h-100 border-0 shadow-sm text-decoration-none">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-user-cog text-warning fa-2x"></i>
                                    </div>
                                    <h6 class="mb-0">Profile Settings</h6>
                                    <small class="text-muted">Manage profile</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Picture Upload Modal -->
<div class="modal fade" id="profilePictureModal" tabindex="-1" aria-labelledby="profilePictureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profilePictureModalLabel">Upload Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div id="image-preview" class="mb-3">
                        <img id="preview-img" src="" alt="Preview" class="img-fluid rounded-circle" style="max-width: 200px; display: none;">
                    </div>
                    <div id="upload-area" class="border-dashed p-5 text-center">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h5>Drop your image here</h5>
                        <p class="text-muted">or click to browse</p>
                        <input type="file" id="modal-profile-picture-input" accept="image/*" class="form-control d-none">
                        <button class="btn btn-primary mt-2" onclick="document.getElementById('modal-profile-picture-input').click()">
                            <i class="fas fa-folder-open me-2"></i> Choose File
                        </button>
                    </div>
                    <small class="text-muted d-block mt-3">
                        Supported formats: JPG, PNG, GIF<br>
                        Max file size: 2MB
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="upload-profile-picture-btn" class="btn btn-primary" disabled>
                    <i class="fas fa-upload me-2"></i> Upload Photo
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    /* .card:hover {
        transform: translateY(-5px);
    } */
    .progress-bar {
        border-radius: 10px;
    }
    .border-start {
        border-left-width: 4px !important;
    }
    .badge {
        font-weight: 500;
    }
    .btn-outline-primary:hover {
        background-color: #4e73df;
        color: white;
    }
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }
    .border-dashed {
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        background-color: #f8f9fa;
        cursor: pointer;
    }
    .border-dashed:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }
    #profile-picture-container {
        position: relative;
    }
    #upload-profile-picture:hover {
        background-color: #224abe;
    }
    #preview-img {
        max-height: 300px;
        object-fit: cover;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Profile completion alert
    @if(Auth::user()->jobSeekerProfile && Auth::user()->jobSeekerProfile->profile_completion < 50)
        const alertHTML = `
            <div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Complete Your Profile!</h5>
                        <p class="mb-0">
                            Your profile is only {{ Auth::user()->jobSeekerProfile->profile_completion }}% complete. 
                            Complete it to get 3x more job matches.
                            <a href="{{ route('job-seeker.profile.edit') }}" class="alert-link fw-bold">Complete Now →</a>
                        </p>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            </div>
        `;
        
        document.querySelector('.col-lg-9').insertAdjacentHTML('afterbegin', alertHTML);
    @endif
    
    // Animate progress bar
    const progressBar = document.querySelector('.progress-bar');
    if (progressBar) {
        const width = progressBar.style.width;
        progressBar.style.width = '0%';
        setTimeout(() => {
            progressBar.style.width = width;
        }, 300);
    }
    
    // Profile picture upload functionality
    const uploadBtn = document.getElementById('upload-profile-picture');
    const removeBtn = document.getElementById('remove-profile-picture');
    const modalProfilePictureInput = document.getElementById('modal-profile-picture-input');
    const uploadProfilePictureBtn = document.getElementById('upload-profile-picture-btn');
    const previewImg = document.getElementById('preview-img');
    const imagePreview = document.getElementById('image-preview');
    const uploadArea = document.getElementById('upload-area');
    let selectedFile = null;
    
    // Open modal on camera icon click
    if (uploadBtn) {
        uploadBtn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('profilePictureModal'));
            modal.show();
        });
    }
    
    // Handle file selection in modal
    if (modalProfilePictureInput) {
        modalProfilePictureInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                selectedFile = e.target.files[0];
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                    uploadArea.style.display = 'none';
                    uploadProfilePictureBtn.disabled = false;
                };
                reader.readAsDataURL(selectedFile);
            }
        });
    }
    
    // Handle drag and drop
    if (uploadArea) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#4e73df';
            this.style.backgroundColor = '#e9ecef';
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '#dee2e6';
            this.style.backgroundColor = '#f8f9fa';
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#dee2e6';
            this.style.backgroundColor = '#f8f9fa';
            
            if (e.dataTransfer.files.length > 0) {
                selectedFile = e.dataTransfer.files[0];
                modalProfilePictureInput.files = e.dataTransfer.files;
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                    uploadArea.style.display = 'none';
                    uploadProfilePictureBtn.disabled = false;
                };
                reader.readAsDataURL(selectedFile);
            }
        });
    }
    
    // Upload profile picture
    if (uploadProfilePictureBtn) {
        uploadProfilePictureBtn.addEventListener('click', function() {
            if (!selectedFile) return;
            
            const formData = new FormData();
            formData.append('profile_picture', selectedFile);
            formData.append('_token', '{{ csrf_token() }}');
            
            // Show loading state
            const originalText = uploadProfilePictureBtn.innerHTML;
            uploadProfilePictureBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Uploading...';
            uploadProfilePictureBtn.disabled = true;
            
            // Upload via AJAX
            axios.post('{{ route("job-seeker.profile.picture.update") }}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                // Update profile picture in UI
                const profilePictureImg = document.getElementById('profile-picture-img');
                if (profilePictureImg) {
                    profilePictureImg.src = response.data.image_url + '?' + new Date().getTime();
                }
                
                // Show success message
                showToast('Success', response.data.message, 'success');
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('profilePictureModal'));
                modal.hide();
                
                // Reset modal
                resetModal();
                
                // Show remove button if not already shown
                if (removeBtn) {
                    removeBtn.style.display = 'block';
                } else {
                    // Create remove button if it doesn't exist
                    const removeBtnContainer = document.querySelector('.mt-2');
                    if (removeBtnContainer) {
                        removeBtnContainer.innerHTML = `
                            <button id="remove-profile-picture" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash-alt me-1"></i> Remove Photo
                            </button>
                        `;
                        // Add event listener to new remove button
                        document.getElementById('remove-profile-picture').addEventListener('click', removeProfilePicture);
                    }
                }
            })
            .catch(error => {
                let errorMessage = 'An error occurred while uploading the image.';
                if (error.response && error.response.data && error.response.data.message) {
                    errorMessage = error.response.data.message;
                }
                showToast('Error', errorMessage, 'danger');
            })
            .finally(() => {
                // Reset button
                uploadProfilePictureBtn.innerHTML = originalText;
                uploadProfilePictureBtn.disabled = false;
            });
        });
    }
    
    // Remove profile picture
    function removeProfilePicture() {
        if (!confirm('Are you sure you want to remove your profile picture?')) return;
        
        // Show loading state
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Removing...';
        this.disabled = true;
        
        axios.delete('{{ route("job-seeker.profile.picture.remove") }}')
            .then(response => {
                // Update profile picture to default
                const profilePictureImg = document.getElementById('profile-picture-img');
                if (profilePictureImg) {
                    const name = '{{ urlencode(Auth::user()->name) }}';
                    profilePictureImg.src = `https://ui-avatars.com/api/?name=${name}&background=4e73df&color=fff&size=120&bold=true`;
                }
                
                // Hide remove button
                this.style.display = 'none';
                
                showToast('Success', response.data.message, 'success');
            })
            .catch(error => {
                showToast('Error', 'Failed to remove profile picture.', 'danger');
                this.innerHTML = originalText;
                this.disabled = false;
            });
    }
    
    // Add event listener to remove button if exists
    if (removeBtn) {
        removeBtn.addEventListener('click', removeProfilePicture);
    }
    
    // Reset modal
    function resetModal() {
        selectedFile = null;
        previewImg.src = '';
        previewImg.style.display = 'none';
        uploadArea.style.display = 'block';
        uploadProfilePictureBtn.disabled = true;
        modalProfilePictureInput.value = '';
    }
    
    // Toast notification function
    function showToast(title, message, type) {
        const toastHTML = `
            <div class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}:</strong> ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        const toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '1055';
        toastContainer.innerHTML = toastHTML;
        document.body.appendChild(toastContainer);
        
        const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'));
        toast.show();
        
        // Remove toast after hiding
        toastContainer.addEventListener('hidden.bs.toast', function () {
            document.body.removeChild(toastContainer);
        });
    }
});
</script>
@endpush
@endsection