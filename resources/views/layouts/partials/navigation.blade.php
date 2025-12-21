<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container-fluid px-4 px-lg-5">
        <!-- Brand/Logo Section -->
        <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('home') }}">
            @php
                $site_logo = get_setting('site_logo');
                $site_name = get_setting('site_name', 'Job Portal');
            @endphp
            
            @if($site_logo)
                <div class="brand-logo-container me-2 p-1 bg-light rounded-3 transition-all">
                    <img src="{{ asset('storage/' . $site_logo) }}" 
                         alt="{{ $site_name }}" 
                         class="brand-logo img-fluid" 
                         style="max-height: 40px;">
                </div>
            @else
                <div class="brand-icon-container me-3 bg-primary rounded-3 p-2 d-flex align-items-center justify-content-center transition-all">
                    <i class="fas fa-briefcase text-white fs-5"></i>
                </div>
            @endif
            
            <div class="brand-text d-flex flex-column">
                <span class="fw-bold text-primary fs-4 lh-1">{{ $site_name }}</span>
                <!-- <small class="text-muted fw-normal" style="font-size: 0.75rem; margin-top: -3px;">
                    Find Your Dream Job
                </small> -->
            </div>
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 p-2 transition-all" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Main Navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <!-- Home -->
        <li class="nav-item mx-1">
            <a class="nav-link d-flex align-items-center py-2 px-3 rounded-3 transition-all {{ request()->routeIs('home') ? 'active text-white bg-primary' : 'text-dark' }}" 
               href="{{ route('home') }}">
                <!-- <i class="fas fa-home me-2 fs-6"></i> -->
                <span class="fw-medium">Home</span>
            </a>
        </li>

        <!-- Find Jobs -->
        <li class="nav-item mx-1">
            <a class="nav-link d-flex align-items-center py-2 px-3 rounded-3 transition-all {{ request()->routeIs('jobs.*') ? 'active text-white bg-primary' : 'text-dark' }}" 
               href="{{ route('jobs.index') }}">
                <!-- <i class="fas fa-briefcase me-2 fs-6"></i> -->
                <span class="fw-medium">Jobs</span>
                <!-- @if(isset($activeJobsCount))
                    <span class="badge bg-danger ms-2 transition-all" style="font-size: 0.65rem; padding: 2px 6px;">
                        {{ $activeJobsCount }}
                    </span>
                @endif -->
            </a>
        </li>

        <!-- About -->
        <li class="nav-item mx-1">
            <a class="nav-link d-flex align-items-center py-2 px-3 rounded-3 transition-all {{ request()->routeIs('about') ? 'active text-white bg-primary' : 'text-dark' }}" 
               href="{{ route('about') }}">
                <!-- <i class="fas fa-info-circle me-2 fs-6"></i> -->
                <span class="fw-medium">About</span>
            </a>
        </li>

        <!-- Contact -->
        <li class="nav-item mx-1">
            <a class="nav-link d-flex align-items-center py-2 px-3 rounded-3 transition-all {{ request()->routeIs('contact') ? 'active text-white bg-primary' : 'text-dark' }}" 
               href="{{ route('contact') }}">
                <!-- <i class="fas fa-envelope me-2 fs-6"></i> -->
                <span class="fw-medium">Contact</span>
            </a>
        </li>

        <!-- Legal Dropdown -->
        <li class="nav-item dropdown mx-1">
            <a class="nav-link d-flex align-items-center py-2 px-3 rounded-3 transition-all text-dark" href="#" role="button" data-bs-toggle="dropdown">
                <!-- <i class="fas fa-gavel me-2 fs-6"></i> -->
                <span class="fw-medium">Others</span>
                <i class="fas fa-chevron-down ms-1 fs-6"></i>
            </a>
            <ul class="dropdown-menu shadow border-0 p-2 rounded-3">
                <li>
                    <a class="dropdown-item py-2 px-3 rounded-3 transition-all" href="{{ route('terms') }}">
                        <span>Terms & Conditions</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item py-2 px-3 rounded-3 transition-all" href="{{ route('privacy') }}">
                        <span>Privacy Policy</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
            
            <!-- Right Side Actions -->
            <div class="d-flex align-items-center gap-2">
                @auth
                    <!-- Post Job Button for Employers -->
                    @if(auth()->user()->hasRole('employer'))
                        <a href="{{ route('jobs.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 py-2 d-flex align-items-center transition-all">
                            <i class="fas fa-plus me-2"></i>
                            <span class="fw-medium">Post Job</span>
                        </a>
                    @endif
                    
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary border-0 dropdown-toggle d-flex align-items-center transition-all" 
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-container me-2">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                         class="rounded-circle transition-all" 
                                         style="width: 36px; height: 36px; object-fit: cover; border: 2px solid #0d6efd;">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center transition-all" 
                                         style="width: 36px; height: 36px; border: 2px solid #0d6efd;">
                                        <i class="fas fa-user text-white" style="font-size: 1rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <span class="fw-medium text-dark">{{ Str::limit(Auth::user()->name, 12) }}</span>
                            <!-- <i class="fas fa-chevron-down ms-2 text-muted transition-all"></i> -->
                        </button>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 transition-all" style="min-width: 220px;">
                            <!-- Role Badge -->
                            <!-- <li class="px-3 py-2">
                                <small class="badge bg-primary text-white text-uppercase fw-medium transition-all">
                                    <i class="fas fa-user-tag me-1"></i>
                                    {{ auth()->user()->role }}
                                </small>
                            </li>
                            <li><hr class="dropdown-divider my-2"></li> -->
                            
                            <!-- Dashboard Links -->
                            @if(auth()->user()->hasRole('admin'))
                                <li>
                                    <a class="dropdown-item py-2 px-3 rounded-3 transition-all" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-user-tag text-primary me-2"></i>
                                        <span>Admin Panel</span>
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item py-2 px-3 rounded-3 transition-all" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt text-primary me-2"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                            @endif
                            
                            <li>
                                <a class="dropdown-item py-2 px-3 rounded-3 transition-all" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-cog text-primary me-2"></i>
                                    <span>Account Settings</span>
                                </a>
                            </li>
                            
                            @if(auth()->user()->hasRole('job_seeker'))
                                <li>
                                    <a class="dropdown-item py-2 px-3 rounded-3 transition-all" href="{{ route('job-seeker.profile.edit') }}">
                                        <i class="fas fa-id-card text-primary me-2"></i>
                                        <span>My Profile</span>
                                    </a>
                                </li>
                            @endif
                            
                            <li><hr class="dropdown-divider my-2"></li>
                            
                            <!-- Logout -->
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 px-3 rounded-3 text-danger border-0 w-100 text-start transition-all">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    
                @else
                    <!-- Auth Buttons -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 py-2 transition-all">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            <span class="fw-medium">Login</span>
                        </a>
                        
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-4 py-2 transition-all">
                            <i class="fas fa-user-plus me-2"></i>
                            <span class="fw-medium">Register</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    /* Custom Styles for Solid Navbar */
    .navbar {
        background: white !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    /* Transition Classes */
    .transition-all {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    /* Nav Link Styles */
    .nav-link {
        font-weight: 500;
        border: 1px solid transparent;
        position: relative;
        overflow: hidden;
    }
    
    /* Hover Effect - Light Blue Background */
    .nav-link:hover:not(.active) {
        background-color: rgba(100, 181, 246, 0.08) !important; /* Very light blue */
        color: #2196f3 !important; /* Light blue text */
        border-color: rgba(100, 181, 246, 0.2);
        transform: translateY(-1px);
    }
    
    /* Active State - Smooth Animation */
    .nav-link.active {
        background: linear-gradient(135deg, #1976d2 0%, #0d47a1 100%) !important; /* Softer blue gradient */
        box-shadow: 0 4px 15px rgba(25, 118, 210, 0.2);
        border: none;
        animation: activePulse 0.6s ease-out;
    }
    
    /* Active State Animation */
    @keyframes activePulse {
        0% {
            transform: scale(0.95);
            opacity: 0.7;
        }
        50% {
            transform: scale(1.02);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    /* Brand Logo Container */
    .brand-logo-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    /* .brand-logo-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    } */
    
    /* Brand Icon Container */
    .brand-icon-container {
        width: 44px;
        height: 44px;
        box-shadow: 0 4px 6px rgba(25, 118, 210, 0.1);
    }
    
    .brand-icon-container:hover {
        transform: rotate(-5deg) scale(1.05);
        box-shadow: 0 8px 16px rgba(25, 118, 210, 0.2);
    }
    
    /* Avatar Container */
    .avatar-container {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .avatar-container:hover {
        transform: scale(1.1) rotate(5deg);
    }
    
    /* Dropdown Menu */
    .dropdown-menu {
        border-radius: 12px;
        margin-top: 10px;
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transition: opacity 0.3s ease, transform 0.3s ease !important;
    }
    
    .dropdown-menu.show {
        animation: dropdownFade 0.3s ease-out;
    }
    
    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Dropdown Items */
    .dropdown-item {
        border-radius: 8px;
        margin: 2px 0;
    }
    
    .dropdown-item:hover {
        background-color: rgba(100, 181, 246, 0.1) !important; /* Light blue hover */
        transform: translateX(4px);
        color: #1976d2 !important;
    }
    
    /* Primary Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(33, 150, 243, 0.3);
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        color: white;
    }
    
    .btn-primary:active {
        transform: translateY(-1px);
    }
    
    /* Outline Button Hover */
    .btn-outline-primary {
        border: 2px solid #2196f3;
        color: #2196f3;
    }
    
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
        color: white;
        border-color: #1976d2;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(33, 150, 243, 0.2);
    }
    
    /* Badge */
    .badge {
        transition: all 0.3s ease;
    }
    
    .badge:hover {
        transform: scale(1.1);
    }
    
    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .navbar-nav {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin: 0.25rem 0;
        }
        
        .nav-link {
            padding: 0.75rem 1rem !important;
        }
        
        .d-flex.gap-2 {
            flex-direction: column;
            width: 100%;
            gap: 1rem !important;
            padding: 1rem 0;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
    
    /* Nav Link Underline Effect */
    .nav-link:not(.active):after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 5px;
        left: 50%;
        background-color: #2196f3;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    
    .nav-link:not(.active):hover:after {
        width: 60%;
    }
</style>

<script>
    // Smooth active state transitions
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');
        
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                navLinks.forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link with delay for animation
                setTimeout(() => {
                    this.classList.add('active');
                }, 50);
            });
        });
        
        // Smooth dropdown animation
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach(dropdown => {
            dropdown.addEventListener('show.bs.dropdown', function () {
                const menu = this.querySelector('.dropdown-menu');
                menu.style.opacity = '0';
                menu.style.transform = 'translateY(-10px)';
            });
            
            dropdown.addEventListener('shown.bs.dropdown', function () {
                const menu = this.querySelector('.dropdown-menu');
                menu.style.opacity = '1';
                menu.style.transform = 'translateY(0)';
            });
        });
    });
</script>