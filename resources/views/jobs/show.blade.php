@extends('layouts.app')

@section('title', $openjob->title . ' - ' . config('app.name'))

@section('content')

<style>
/* ================= Job Details Page Design ================= */
.job-page .card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
}

.job-page h1,
.job-page h2,
.job-page h4,
.job-page h5 {
    font-weight: 600;
}

.job-page .badge {
    padding: 6px 14px;
    font-size: 13px;
    border-radius: 20px;
}

.job-meta p {
    margin-bottom: 8px;
    font-size: 14px;
    color: #555;
}

.job-meta i {
    color: #2563eb;
}

.job-description,
.requirements {
    font-size: 15px;
    line-height: 1.7;
    color: #444;
    background: #f9fafb;
    padding: 15px;
    border-radius: 10px;
}

.sidebar-card .card-header {
    background: #f8fafc;
    font-weight: 600;
}

.apply-btn {
    padding: 12px;
    font-size: 15px;
    border-radius: 10px;
}

.related-job-card {
    transition: all .3s ease;
}

.related-job-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,.08);
}

.quick-stats h5 {
    font-weight: 700;
    color: #2563eb;
}

.modal-content {
    border-radius: 16px;
}
</style>

<div class="container py-5 job-page">
    <div class="row">
        <!-- ================= LEFT CONTENT ================= -->
        <div class="col-lg-8">

            <!-- Job Details -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="h3 mb-2 text-primary">{{ $openjob->title }}</h1>
                            <h2 class="h6 text-muted">
                                {{ $openjob->employer->company_name ?? $openjob->employer->name }}
                            </h2>
                        </div>

                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Posted {{ $openjob->created_at?->diffForHumans() }}
                        </small>

                        <!-- @if($openjob->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($openjob->status === 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif -->
                    </div>

                    <div class="row mb-4 job-meta">
                        <div class="col-md-6">
                            <p><i class="fas fa-map-marker-alt me-2"></i>{{ $openjob->location }}</p>
                            <p><i class="fas fa-briefcase me-2"></i>{{ ucfirst(str_replace('_',' ',$openjob->job_type)) }}</p>
                            <p><i class="fas fa-layer-group me-2"></i>{{ $openjob->category }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="fas fa-money-bill-wave me-2"></i>{{ $openjob->salary_range }}</p>
                            <p><i class="fas fa-users me-2"></i>{{ $openjob->vacancy }} Vacancy</p>
                            <p><i class="fas fa-calendar-alt me-2"></i>
                                {{ $openjob->deadline ? $openjob->deadline->format('F d, Y') : 'Not specified' }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Job Description</h5>
                        <div class="job-description">
                            {!! nl2br(e($openjob->description)) !!}
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Requirements</h5>
                        <div class="requirements">
                            {!! nl2br(e($openjob->requirements)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Jobs -->
            @if($relatedJobs->count())
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Related Jobs</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($relatedJobs as $job)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 related-job-card">
                                <div class="card-body">
                                    <h6>{{ $job->title }}</h6>
                                    <p class="small text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}<br>
                                        <i class="fas fa-money-bill-wave me-1"></i>{{ $job->salary_range }}
                                    </p>
                                    <a href="{{ route('jobs.show',$job) }}" class="btn btn-sm btn-outline-primary">
                                        View Job
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- ================= RIGHT SIDEBAR ================= -->
        <div class="col-lg-4">

            <!-- Company Info -->
            <div class="card mb-4 sidebar-card">
                <div class="card-header">
                    Company Information
                </div>
                <div class="card-body">
                    <h6>{{ $openjob->employer->company_name ?? 'N/A' }}</h6>
                    @if($openjob->employer->industry)
                        <p><i class="fas fa-industry me-2"></i>{{ $openjob->employer->industry }}</p>
                    @endif
                    @if($openjob->employer->website)
                        <p><i class="fas fa-globe me-2"></i>
                            <a href="{{ $openjob->employer->website }}" target="_blank">Website</a>
                        </p>
                    @endif
                </div>
            </div>

            @auth
                @if(auth()->user()->isJobSeeker())
                    <!-- Apply Section -->
                    <div class="card sidebar-card">
                        <div class="card-header">Apply for this Job</div>
                        <div class="card-body">
                            @if($hasApplied)
                                <div class="alert alert-info">You already applied.</div>
                                <a href="{{ route('applications.index') }}" class="btn btn-primary w-100">View Applications</a>
                            @else
                                <button class="btn btn-primary w-100 apply-btn" data-bs-toggle="modal" data-bs-target="#applyModal">
                                    <i class="fas fa-paper-plane me-2"></i>Apply Now
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            @endauth


            <!-- Quick Stats -->
            <div class="card mt-4 text-center">
                <div class="card-body quick-stats">
                    <div class="row">
                        <div class="col-6">
                            <h5>{{ $openjob->views }}</h5>
                            <small>Views</small>
                        </div>
                        <div class="col-6">
                            <h5>{{ $openjob->applications()->count() }}</h5>
                            <small>Applications</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Apply Modal -->
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel">Apply for "{{ $openjob->title }}"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('jobs.apply', $openjob) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    
                    <!-- Cover Letter -->
                    <div class="mb-3">
                        <label for="cover_letter" class="form-label">
                            Cover Letter <span class="text-danger">*</span>
                            <small class="text-muted">(Minimum 100 characters)</small>
                        </label>
                        <textarea 
                            name="cover_letter" 
                            id="cover_letter" 
                            class="form-control @error('cover_letter') is-invalid @enderror" 
                            rows="8" 
                            placeholder="Tell us why you are a good fit for this position..."
                            required
                            minlength="100"
                            maxlength="1000">{{ old('cover_letter') }}</textarea>
                        @error('cover_letter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Current count: <span id="charCount">0</span>/1000
                        </div>
                    </div>

                    <!-- Resume Upload -->
                    <div class="mb-3">
                        <label for="resume" class="form-label">Resume</label>
                        <div class="input-group">
                            <input 
                                type="file" 
                                class="form-control @error('resume') is-invalid @enderror" 
                                id="resume" 
                                name="resume"
                                accept=".pdf,.doc,.docx">
                            @error('resume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">
                            Accepted formats: PDF, DOC, DOCX (Max: 2MB)
                            @if(auth()->user()->resume_path)
                                <br>
                                <small class="text-info">
                                    <i class="fas fa-info-circle"></i> 
                                    You already have a resume uploaded. If you don't upload a new one, your existing resume will be used.
                                </small>
                            @endif
                        </div>
                    </div>

                    <!-- Job Details Review -->
                    <div class="card border-info mb-3">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-file-alt me-2"></i>Job Summary
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Job Title:</strong> {{ $openjob->title }}</p>
                                    <p><strong>Company:</strong> {{ $openjob->employer->company_name }}</p>
                                    <p><strong>Location:</strong> {{ $openjob->location }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $openjob->job_type)) }}</p>
                                    <p><strong>Salary:</strong> {{ $openjob->salary_range }}</p>
                                    <p><strong>Deadline:</strong> {{ $openjob->deadline->format('F d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms Agreement -->
                    <div class="form-check mb-3">
                        <input 
                            class="form-check-input @error('terms') is-invalid @enderror" 
                            type="checkbox" 
                            id="terms" 
                            name="terms" 
                            required>
                        <label class="form-check-label" for="terms">
                            I agree that the information I've provided is accurate and I understand that this application will be sent to the employer.
                        </label>
                        @error('terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Character counter for cover letter
    document.getElementById('cover_letter').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
    });

    // File size validation
    document.getElementById('resume').addEventListener('change', function() {
        const file = this.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        
        if (file) {
            // Check file size
            if (file.size > maxSize) {
                alert('File size must be less than 2MB');
                this.value = '';
                return;
            }
            
            // Check file type
            if (!allowedTypes.includes(file.type)) {
                alert('Only PDF, DOC, and DOCX files are allowed');
                this.value = '';
                return;
            }
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const coverLetter = document.getElementById('cover_letter');
        const terms = document.getElementById('terms');
        
        if (coverLetter.value.length < 100) {
            e.preventDefault();
            alert('Cover letter must be at least 100 characters long.');
            coverLetter.focus();
            return false;
        }
        
        if (!terms.checked) {
            e.preventDefault();
            alert('You must agree to the terms before submitting.');
            terms.focus();
            return false;
        }
    });
</script>
@endpush