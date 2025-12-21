@extends('layouts.app')

@section('title', 'Edit Profile - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 text-center">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" 
                                    data-bs-target="#basic" type="button">Basic Info</button>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab" data-bs-toggle="tab" 
                                    data-bs-target="#details" type="button">Profile Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="resume-tab" data-bs-toggle="tab" 
                                    data-bs-target="#resume" type="button">Resume</button>
                        </li> -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" 
                                    data-bs-target="#password" type="button">Change Password</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="profileTabContent">
                        <!-- Basic Info Tab -->
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @if($user->isEmployer())
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="company_name" class="form-label">Company Name *</label>
                                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                                   id="company_name" name="company_name" value="{{ old('company_name', $user->company_name) }}" required>
                                            @error('company_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="industry" class="form-label">Industry</label>
                                            <input type="text" class="form-control @error('industry') is-invalid @enderror" 
                                                   id="industry" name="industry" value="{{ old('industry', $user->industry) }}">
                                            @error('industry')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="website" class="form-label">Website</label>
                                            <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                                   id="website" name="website" value="{{ old('website', $user->website) }}">
                                            @error('website')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                <div class="row py-3">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Update Basic Info</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Profile Details Tab -->
                        <!-- <div class="tab-pane fade" id="details" role="tabpanel">
                            <form action="{{ route('profile.details') }}" method="POST">
                                @csrf
                                
                                @if($user->isJobSeeker())
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="skills" class="form-label">Skills (comma separated)</label>
                                            <textarea class="form-control @error('skills') is-invalid @enderror" 
                                                      id="skills" name="skills" rows="3">{{ old('skills', is_array($user->skills) ? implode(', ', $user->skills) : $user->skills) }}</textarea>
                                            <small class="text-muted">Example: PHP, Laravel, MySQL, JavaScript</small>
                                            @error('skills')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="experience" class="form-label">Work Experience</label>
                                            <textarea class="form-control @error('experience') is-invalid @enderror" 
                                                      id="experience" name="experience" rows="5">{{ old('experience', $user->experience) }}</textarea>
                                            @error('experience')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="education" class="form-label">Education</label>
                                            <textarea class="form-control @error('education') is-invalid @enderror" 
                                                      id="education" name="education" rows="5">{{ old('education', $user->education) }}</textarea>
                                            @error('education')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Update Profile Details</button>
                                    </div>
                                </div>
                            </form>
                        </div> -->

                        <!-- Resume Tab -->
                        <!-- <div class="tab-pane fade" id="resume" role="tabpanel">
                            @if($user->isJobSeeker())
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h5>Current Resume</h5>
                                        @if($user->resume_path)
                                            <div class="alert alert-success">
                                                <i class="fas fa-file-pdf me-2"></i>
                                                <strong>Resume uploaded:</strong> 
                                                <a href="{{ Storage::url($user->resume_path) }}" target="_blank" class="text-decoration-none">
                                                    View Resume
                                                </a>
                                                <span class="ms-3 text-muted">
                                                    (Uploaded: {{ \Carbon\Carbon::parse($user->updated_at)->format('M d, Y') }})
                                                </span>
                                            </div>
                                        @else
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                No resume uploaded yet.
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Upload New Resume</h5>
                                        <form action="{{ route('profile.resume') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="resume" class="form-label">Select Resume File</label>
                                                <input type="file" class="form-control @error('resume') is-invalid @enderror" 
                                                       id="resume" name="resume" accept=".pdf,.doc,.docx">
                                                <small class="text-muted">Accepted formats: PDF, DOC, DOCX (Max: 2MB)</small>
                                                @error('resume')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary">Upload Resume</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Resume upload is only available for job seekers.
                                </div>
                            @endif
                        </div> -->

                        <!-- Password Tab -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="current_password" class="form-label">Current Password *</label>
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" name="current_password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">New Password *</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation">
                                    </div>
                                    
                                </div>

                                <div class="row py-3">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Activate tab based on URL hash
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash) {
            const tabTrigger = new bootstrap.Tab(document.querySelector(
                `[data-bs-target="${window.location.hash}"]`
            ));
            tabTrigger.show();
        }
    });
</script>
<style>
    /* Active tab background + text color */
    .nav-tabs .nav-link.active {
        background-color: #0d6efd; /* Bootstrap primary */
        color: #fff !important;
        border-color: #0d6efd;
    }

    /* Inactive tab hover effect (optional but nice) */
    .nav-tabs .nav-link:hover {
        color: #0d6efd;
    }
</style>

@endsection