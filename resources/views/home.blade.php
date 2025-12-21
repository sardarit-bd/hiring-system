@extends('layouts.app')

@section('title', 'CareerHub - Find Your Dream Job')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
    :root {
        --primary: #0a66c2;
        --primary-dark: #004182;
        --primary-light: #378fe9;
        --primary-lighter: #e8f2ff;
        --secondary: #5e5adb;
        --accent: #ff6b35;
        --dark: #1d1f23;
        --light: white;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --success: #10b981;
        --warning: #f59e0b;
        --transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-slow: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-extra-slow: all 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        overflow-x: hidden;
    }

    /* Hero Carousel Section */
    .hero-carousel-section {
        position: relative;
        height: 100vh;
        min-height: 700px;
        max-height: 900px;
        overflow: hidden;
    }

    .hero-swiper {
        width: 100%;
        height: 100%;
    }

    .hero-slide {
        position: relative;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, 
            rgba(10, 102, 194, 0.3) 0%,   /* alpha 0.5 */
            rgba(94, 90, 219, 0.5) 100%);

        z-index: 1;
    }

    .hero-slide-content {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
        max-width: 1200px;
        padding: 0 20px;
        opacity: 0;
        transform: translateY(50px);
        transition: var(--transition-slow);
    }

    .swiper-slide-active .hero-slide-content {
        opacity: 1;
        transform: translateY(0);
    }

    .hero-title {
        font-size: 4.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        background: linear-gradient(45deg, #ffffff 30%, var(--primary-lighter) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .hero-subtitle {
        font-size: 1.5rem;
        opacity: 0.95;
        margin-bottom: 2.5rem;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-top: 50px;
        flex-wrap: wrap;
    }

    .hero-stat {
        text-align: center;
        animation-delay: calc(var(--delay) * 100ms);
    }

    .hero-stat-number {
        font-size: 3rem;
        font-weight: 800;
        display: block;
        margin-bottom: 5px;
        color: white;
        line-height: 1;
    }

    .hero-stat-label {
        font-size: 1rem;
        opacity: 0.9;
        color: white;
    }

    /* Hero Navigation */
    .hero-navigation {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        display: flex;
        gap: 15px;
    }

    .hero-pagination {
        display: flex;
        gap: 12px;
    }

    .hero-pagination-bullet {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        cursor: pointer;
        transition: var(--transition);
    }

    .hero-pagination-bullet-active {
        background: white;
        transform: scale(1.3);
    }

    .hero-nav-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .hero-nav-btn:hover {
        background: white;
        color: var(--primary);
        transform: scale(1.1);
    }

    /* Search Container */
    .search-container-wrapper {
        position: relative;
        margin-top: -100px;
        z-index: 20;
        padding: 0 20px;
        background: white;
    }

    .search-container {
        background: white;
        border-radius: 5px;
        padding: 40px;
        box-shadow: 
            0 30px 80px rgba(0, 0, 0, 0.15),
            0 10px 40px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: 0 auto;
        transform: translateY(0);
        transition: var(--transition-slow);
    }

    .search-container:hover {
        transform: translateY(-10px);
        box-shadow: 
            0 40px 100px rgba(0, 0, 0, 0.2),
            0 15px 50px rgba(0, 0, 0, 0.15);
    }

    .search-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 30px;
        text-align: center;
    }

    .search-form-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        margin-bottom: 30px;
        align-items: end;
    }

    @media (max-width: 1200px) {
        .search-form-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .search-form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .search-form-grid {
            grid-template-columns: 1fr;
        }
    }

    .search-input-group {
        position: relative;
    }

    .search-input-group i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-600);
        z-index: 2;
    }

    .search-input {
        width: 100%;
        padding: 18px 20px 18px 50px;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        font-size: 1rem;
        transition: var(--transition);
        background: var(--light);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(10, 102, 194, 0.1);
        background: white;
        transform: translateY(-2px);
    }

    .search-btn {
        height: 54px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border: none;
        border-radius: 12px;
        padding:  32px;
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: var(--transition-slow);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        white-space: nowrap;
    }

    .search-btn:hover {
        transform: translateY(-3px);
        box-shadow: 
            0 15px 30px rgba(10, 102, 194, 0.3),
            0 8px 20px rgba(10, 102, 194, 0.2);
    }

    /* Featured Jobs Section */
    .featured-jobs-section {
        padding: 120px 0;
        background: white;
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .section-title {
        font-size: 3rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 5px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        border-radius: 3px;
    }

    .section-subtitle {
        color: var(--gray-600);
        font-size: 1.2rem;
        line-height: 1.6;
    }

    /* Jobs Grid */
    .jobs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        /* max-width: 1200px; */
        margin: 0 auto 10px;
        padding: 0 10px;
    }

    @media (max-width: 768px) {
        .jobs-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Rectangular Job Card Design */
    .job-card {
        background: white;
        border-radius: 5px;
        padding: 25px;
        border: 1px solid var(--gray-200);
        transition: var(--transition-slow);
        position: relative;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .job-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(10, 102, 194, 0.15);
        border-color: var(--primary-light);
    }

    .job-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        /* margin-bottom: 20px;
        padding-bottom: 20px; */
        /* border-bottom: 1px solid var(--gray-200); */
    }

    .job-company-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .company-avatar {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: var(--primary-lighter);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--primary);
        font-weight: 700;
        flex-shrink: 0;
    }

    .job-company-name {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 5px;
        font-size: 1rem;
    }

    .job-posted {
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .job-type-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        background: var(--primary-lighter);
        color: var(--primary);
        white-space: nowrap;
    }

    .job-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .job-location {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--gray-600);
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .job-salary {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--success);
        margin-bottom: 20px;
        padding: 10px 0;
        border-top: 1px solid var(--gray-200);
        border-bottom: 1px solid var(--gray-200);
    }

    .job-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .skill-tag {
        padding: 6px 12px;
        background: var(--gray-100);
        border-radius: 6px;
        font-size: 0.875rem;
        color: var(--gray-700);
        transition: var(--transition);
    }

    .job-card:hover .skill-tag {
        background: var(--primary-lighter);
        color: var(--primary);
    }

    .job-actions {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }

    .btn-apply {
        flex: 1;
        padding: 12px 20px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .btn-apply:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-save {
        width: 46px;
        height: 46px;
        border-radius: 8px;
        border: 2px solid var(--gray-300);
        background: transparent;
        color: var(--gray-600);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .btn-save:hover {
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-2px);
    }

    .view-all-container {
        text-align: center;
        margin-top: 40px;
    }

    .btn-view-all {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 10px 40px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-view-all:hover {
        background: var(--primary-dark);
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(10, 102, 194, 0.2);
        gap: 15px;
    }

    /* Categories Section */
    .categories-section {
        padding: 120px 0 40px 0;
        background: var(--light);
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 10px;
        /* max-width: 1200px; */
        margin: 0 auto;
        padding: 0 20px;
    }

    .category-card {
        background: white;
        border-radius: 5px;
        padding: 10px 5px;
        text-align: center;
        transition: var(--transition-slow);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        opacity: 0;
        transition: var(--transition-slow);
        z-index: 1;
    }

    .category-card:hover {
        transform: translateY(-15px);
        border-color: transparent;
        box-shadow: 0 30px 80px rgba(10, 102, 194, 0.15);
    }

    .category-card:hover::before {
        opacity: 1;
    }

    .category-icon {
        position: relative;
        z-index: 2;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary-lighter);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 2rem;
        color: var(--primary);
        transition: var(--transition-slow);
    }

    .category-card:hover .category-icon {
        background: white;
        transform: scale(1.1) rotate(10deg);
    }

    .category-card h3 {
        position: relative;
        z-index: 2;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0; 
        color: var(--dark);
        transition: var(--transition);
    }

    .category-card:hover h3 {
        color: white;
    }

    .category-count {
        position: relative;
        z-index: 2;
        font-size: 1rem;
        color: var(--gray-600);
        transition: var(--transition);
    }

    .category-card:hover .category-count {
        color: rgba(255, 255, 255, 0.9);
    }

    /* Stats Section */
    .stats-section {
        padding: 100px 0;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .stats-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.05;
        background-image: 
            radial-gradient(circle at 20% 80%, rgba(255,255,255,1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255,255,255,1) 0%, transparent 50%);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }

    .stat-card {
        text-align: center;
        padding: 40px 20px;
    }

    .stat-number {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 10px;
        line-height: 1;
    }

    .stat-label {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 20px;
    }

    .stat-description {
        font-size: 1rem;
        opacity: 0.8;
        line-height: 1.5;
    }

    /* Testimonials */
    .testimonials-section {
        padding: 120px 0;
        background: white;
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .testimonial-card {
        background: var(--light);
        border-radius: 20px;
        padding: 40px;
        transition: var(--transition-slow);
        border: 1px solid var(--gray-200);
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.08);
    }

    .testimonial-content {
        position: relative;
        margin-bottom: 30px;
    }

    .quote-icon {
        position: absolute;
        top: -20px;
        left: -10px;
        font-size: 4rem;
        color: var(--primary);
        opacity: 0.1;
    }

    .testimonial-text {
        font-size: 1.1rem;
        line-height: 1.7;
        color: var(--gray-700);
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .author-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .author-info h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
    }

    .author-title {
        color: var(--gray-600);
        font-size: 0.95rem;
    }

    /* CTA Section */
    .cta-section {
        padding: 120px 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e8f2ff 100%);
        position: relative;
        overflow: hidden;
    }

    .cta-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        text-align: center;
    }

    .cta-title {
        font-size: 3rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .cta-subtitle {
        font-size: 1.25rem;
        color: var(--gray-600);
        max-width: 700px;
        margin: 0 auto 50px;
        line-height: 1.6;
    }

    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .cta-btn {
        padding: 18px 45px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition-slow);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-width: 220px;
    }

    .cta-btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border: none;
    }

    .cta-btn-secondary {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .cta-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 60px rgba(10, 102, 194, 0.2);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .hero-title {
            font-size: 3.5rem;
        }
        
        .section-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 992px) {
        .hero-title {
            font-size: 2.8rem;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
        }
        
        .search-container {
            padding: 40px 30px;
        }
        
        .section-title {
            font-size: 2.2rem;
        }
        
        .cta-title {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .hero-carousel-section {
            height: 80vh;
            min-height: 600px;
        }
        
        .hero-title {
            font-size: 2.2rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            padding: 0 15px;
        }
        
        .hero-stats {
            gap: 20px;
        }
        
        .hero-stat-number {
            font-size: 2rem;
        }
        
        .search-container-wrapper {
            margin-top: -60px;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .cta-title {
            font-size: 2rem;
        }
        
        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .cta-btn {
            width: 100%;
            max-width: 300px;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.8rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .search-container {
            padding: 30px 20px;
        }
        
        .section-title {
            font-size: 1.8rem;
        }
        
        .job-title {
            font-size: 1.3rem;
        }
        
        .cta-title {
            font-size: 1.8rem;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .animate-on-scroll.animated {
        opacity: 1;
        transform: translateY(0);
    }

    /* No jobs message */
    .no-jobs-message {
        text-align: center;
        padding: 60px 20px;
        background: var(--light);
        border-radius: 20px;
        margin: 0 auto;
        max-width: 600px;
    }

    .no-jobs-icon {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 20px;
    }

    .no-jobs-title {
        font-size: 1.8rem;
        color: var(--gray-700);
        margin-bottom: 10px;
    }

    .no-jobs-text {
        color: var(--gray-600);
        font-size: 1.1rem;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')

<!-- Hero Carousel Section -->
<section class="hero-carousel-section">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1497215728101-856f4ea42174?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')">
                <div class="hero-slide-content">
                    <h1 class="hero-title">Find Your Dream Job That Matches Your Passion</h1>
                    <!-- <p class="hero-subtitle">Connect with thousands of employers and discover opportunities that match your skills and career goals. Your dream career starts here.</p> -->
                    
                    <div class="hero-stats">
                        <div class="hero-stat" style="--delay: 1">
                            <span class="hero-stat-number">{{ $activeJobsCount }}</span>
                            <span class="hero-stat-label">Active Jobs</span>
                        </div>
                        <div class="hero-stat" style="--delay: 2">
                            <span class="hero-stat-number">5K+</span>
                            <span class="hero-stat-label">Companies</span>
                        </div>
                        <div class="hero-stat" style="--delay: 3">
                            <span class="hero-stat-number">85%</span>
                            <span class="hero-stat-label">Success Rate</span>
                        </div>
                        <div class="hero-stat" style="--delay: 4">
                            <span class="hero-stat-number">2.5K+</span>
                            <span class="hero-stat-label">Hired This Month</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')">
                <div class="hero-slide-content">
                    <h1 class="hero-title">Connect With Top Companies Worldwide</h1>
                    <!-- <p class="hero-subtitle">Access exclusive job opportunities from Fortune 500 companies and innovative startups looking for talent like you.</p> -->
                    
                    <div class="hero-stats">
                        <div class="hero-stat" style="--delay: 1">
                            <span class="hero-stat-number">50+</span>
                            <span class="hero-stat-label">Countries</span>
                        </div>
                        <div class="hero-stat" style="--delay: 2">
                            <span class="hero-stat-number">500+</span>
                            <span class="hero-stat-label">Industries</span>
                        </div>
                        <div class="hero-stat" style="--delay: 3">
                            <span class="hero-stat-number">24/7</span>
                            <span class="hero-stat-label">Support</span>
                        </div>
                        <div class="hero-stat" style="--delay: 4">
                            <span class="hero-stat-number">98%</span>
                            <span class="hero-stat-label">Satisfaction</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')">
                <div class="hero-slide-content">
                    <h1 class="hero-title">Build Your Career With Confidence</h1>
                    <!-- <p class="hero-subtitle">Get personalized career guidance, skill assessments, and expert advice to accelerate your professional growth.</p> -->
                    
                    <div class="hero-stats">
                        <div class="hero-stat" style="--delay: 1">
                            <span class="hero-stat-number">15K+</span>
                            <span class="hero-stat-label">Career Guides</span>
                        </div>
                        <div class="hero-stat" style="--delay: 2">
                            <span class="hero-stat-number">200+</span>
                            <span class="hero-stat-label">Experts</span>
                        </div>
                        <div class="hero-stat" style="--delay: 3">
                            <span class="hero-stat-number">30%</span>
                            <span class="hero-stat-label">Faster Hiring</span>
                        </div>
                        <div class="hero-stat" style="--delay: 4">
                            <span class="hero-stat-number">4.9/5</span>
                            <span class="hero-stat-label">Rating</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <div class="hero-navigation">
            <div class="hero-nav-btn hero-prev">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="hero-pagination"></div>
            <div class="hero-nav-btn hero-next">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
    </div>
</section>

<!-- Search Container -->
<div class="search-container-wrapper">
    <div class="search-container">
        <form action="{{ route('jobs.index') }}" method="GET" class="search-form">
            <div class="search-form-grid">
                <div class="search-input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" 
                           name="search" 
                           class="search-input" 
                           placeholder="Job title, keywords, or company"
                           value="{{ request('search') }}">
                </div>
                
                <div class="search-input-group">
                    <i class="fas fa-map-marker-alt"></i>
                    <input type="text" 
                           name="location" 
                           class="search-input" 
                           placeholder="City, state, or remote"
                           value="{{ request('location') }}">
                </div>
                
                <div class="search-input-group">
                    <i class="fas fa-briefcase"></i>
                    <select name="job_type" class="search-input">
                        <option value="">Job Type</option>
                        <option value="full_time">Full Time</option>
                        <option value="part_time">Part Time</option>
                        <option value="contract">Contract</option>
                        <option value="remote">Remote</option>
                        <option value="internship">Internship</option>
                    </select>
                </div>
                
                <div class="search-input-group">
                    <i class="fas fa-filter"></i>
                    <select name="category" class="search-input">
                        <option value="">All Categories</option>
                        @if(isset($categories) && $categories instanceof \Illuminate\Support\Collection)
                            @foreach($categories as $category)
                                @if(is_object($category))
                                    <option value="{{ $category->slug ?? '' }}">{{ $category->name ?? 'Unknown' }}</option>
                                @elseif(is_array($category))
                                    <option value="{{ $category['slug'] ?? '' }}">{{ $category['name'] ?? 'Unknown' }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <!-- Search button inside grid -->
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Search Jobs
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container-fluid">
        <div class="section-header">
            <h2 class="section-title">Job Categories</h2>
        </div>
        
        @if(!empty($categories) && count($categories) > 0)
            <div class="categories-grid">
                @foreach($categories as $categoryName)
                    <div class="category-card animate-on-scroll">
                        <h3>{{ $categoryName }}</h3>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-jobs-message animate-on-scroll">
                <div class="no-jobs-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="no-jobs-title">No Categories Available</h3>
                <p class="no-jobs-text">
                    Currently there are no job categories available. Check back later for updates.
                </p>
            </div>
        @endif
    </div>
</section>

<!-- Featured Jobs Section -->
<section class="featured-jobs-section">
    <div class="container-fluid">
        <div class="section-header">
            <h2 class="section-title">Find Your Dream Jobs Here</h2>
            <!-- <p class="section-subtitle">Discover exciting opportunities from top companies looking for talent like you</p> -->
        </div>
        
        @if(isset($featuredJobs) && $featuredJobs->count() > 0)
            <div class="jobs-grid">
                @foreach($featuredJobs as $job)
                    @php
                        // Get company name safely
                        $companyName = $job->employer && $job->employer->company_name ? $job->employer->company_name : 'Unknown Company';
                        // Get first two letters for avatar
                        $companyInitials = strtoupper(substr($companyName, 0, 2));
                        // Format salary
                        $salary = $job->salary_range ?: 'Negotiable';
                        // Format skills
                        $skills = $job->required_skills ? explode(',', $job->required_skills) : [];
                        // Format posted date
                        $postedDate = $job->created_at->diffForHumans();
                        // Get job type
                        $jobType = $job->job_type ?? 'Full Time';
                        // Get location
                        $location = $job->location ?? 'Location Not Specified';
                    @endphp
                    
                    <div class="job-card animate-on-scroll">
                        <div class="job-card-header">
                            <div class="job-company-info">
                                <div class="company-avatar">
                                    {{ $companyInitials }}
                                </div>
                                <div>
                                    <div class="job-company-name">{{ $companyName }}</div>
                                    <div class="job-posted"><a style="text-decoration: none;" href="{{ route('jobs.show', $job->id) }}"><i class="fas fa-briefcase"></i> {{ $job->title }}</a></div>
                                </div>
                            </div>
                            <div class="job-type-badge">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $location }}</span>
                                @if($job->is_remote)
                                    <span class="remote-badge">• Remote</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- <h3 class="job-title">{{ $job->title }}</h3> -->
                        
                        <!-- <div class="job-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $location }}</span>
                            @if($job->is_remote)
                                <span class="remote-badge">• Remote</span>
                            @endif
                        </div> -->
                        
                        <!-- <div class="job-salary">{{ $salary }}</div>
                        
                        @if(count($skills) > 0)
                            <div class="job-skills">
                                @foreach(array_slice($skills, 0, 3) as $skill)
                                    <span class="skill-tag">{{ trim($skill) }}</span>
                                @endforeach
                                @if(count($skills) > 3)
                                    <span class="skill-tag">+{{ count($skills) - 3 }} more</span>
                                @endif
                            </div>
                        @else
                            <div class="job-skills">
                                <span class="skill-tag">Skills not specified</span>
                            </div>
                        @endif -->
                        
                        <!-- <div class="job-actions">
                            <a href="{{ route('jobs.show', $job->id) }}" class="btn-apply">
                                <i class="fas fa-paper-plane"></i> Apply Now
                            </a>
                            <button class="btn-save" data-job-id="{{ $job->id }}">
                                <i class="far fa-bookmark"></i>
                            </button>
                        </div> -->
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-jobs-message animate-on-scroll">
                <div class="no-jobs-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3 class="no-jobs-title">No Featured Jobs Available</h3>
                <!-- <p class="no-jobs-text">
                    Currently there are no featured jobs available. Check back later or browse all jobs to find opportunities.
                </p> -->
                <div style="margin-top: 30px;">
                    <a href="{{ route('jobs.index') }}" class="btn-view-all">
                        Browse All Jobs <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endif
        
        @if(isset($featuredJobs) && $featuredJobs->count() > 0)
            <div class="view-all-container">
                <a href="{{ route('jobs.index') }}" class="btn-view-all">
                    View All Jobs <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>
</section>


<!-- Stats Section -->
<section class="stats-section">
    <div class="stats-bg-pattern"></div>
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card animate-on-scroll">
                <div class="stat-number">
                    @php
                        use App\Models\OpenJob;
                        
                        $actualCount = $activeJobsCount ?? OpenJob::where('status', 'approved')
                            ->where('is_active', 1)
                            ->whereDate('deadline', '>=', now()->format('Y-m-d'))
                            ->count();
                    @endphp
                    {{ number_format($actualCount) }}+
                </div>
                <div class="stat-label">Active Jobs</div>
                <div class="stat-description">Current job openings from top companies worldwide</div>
            </div>
            
            <div class="stat-card animate-on-scroll">
                <div class="stat-number">5,000+</div>
                <div class="stat-label">Partner Companies</div>
                <div class="stat-description">Trusted employers actively hiring through our platform</div>
            </div>
            
            <div class="stat-card animate-on-scroll">
                <div class="stat-number">50,000+</div>
                <div class="stat-label">Successful Hires</div>
                <div class="stat-description">Professionals who found their dream jobs through our platform</div>
            </div>
            
            <div class="stat-card animate-on-scroll">
                <div class="stat-number">85%</div>
                <div class="stat-label">Success Rate</div>
                <div class="stat-description">Job seekers who find employment within 3 months</div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<div class="swiper testimonials-slider p-5">
    <div class="swiper-wrapper">

        <!-- Slide 1 -->
        <div class="swiper-slide">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="quote-icon">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <p class="testimonial-text">
                        "CareerHub completely changed my career trajectory..."
                    </p>
                </div>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786" class="author-avatar">
                    <div class="author-info">
                        <h4>Sarah Johnson</h4>
                        <div class="author-title">Senior Software Engineer</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="quote-icon">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <p class="testimonial-text">
                        "As a hiring manager, I've found CareerHub invaluable..."
                    </p>
                </div>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d" class="author-avatar">
                    <div class="author-info">
                        <h4>Michael Chen</h4>
                        <div class="author-title">Marketing Director</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="swiper-slide">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="quote-icon">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <p class="testimonial-text">
                        "The personalized job recommendations helped me..."
                    </p>
                </div>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f" class="author-avatar">
                    <div class="author-info">
                        <h4>Jessica Williams</h4>
                        <div class="author-title">Product Designer</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="swiper-slide">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="quote-icon">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <p class="testimonial-text">
                        "The personalized job recommendations helped me..."
                    </p>
                </div>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f" class="author-avatar">
                    <div class="author-info">
                        <h4>Jessica Williams</h4>
                        <div class="author-title">Product Designer</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Pagination dots -->
    <div class="swiper-pagination"></div>
</div>


<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-container">
        <h2 class="cta-title animate-on-scroll">Ready to Transform Your Career?</h2>
        <p class="cta-subtitle animate-on-scroll">Join thousands of professionals who have found their dream jobs through CareerHub. Start your journey today!</p>
        
        <div class="cta-buttons">
            @auth
                <a href="{{ route('jobs.index') }}" class="cta-btn cta-btn-primary animate-on-scroll">
                    <i class="fas fa-search"></i> Browse Jobs
                </a>
                @if(auth()->user()->role === 'employer')
                    <a href="{{ route('jobs.create') }}" class="cta-btn cta-btn-secondary animate-on-scroll">
                        <i class="fas fa-briefcase"></i> Post a Job
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}?role=job_seeker" class="cta-btn cta-btn-primary animate-on-scroll">
                    <i class="fas fa-user-plus"></i> Create Free Account
                </a>
                <a href="{{ route('jobs.index') }}" class="cta-btn cta-btn-secondary animate-on-scroll">
                    <i class="fas fa-search"></i> Browse Jobs
                </a>
                <a href="{{ route('register') }}?role=employer" class="cta-btn cta-btn-secondary animate-on-scroll">
                    <i class="fas fa-briefcase"></i> Post a Job
                </a>
            @endauth
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
new Swiper(".testimonials-slider", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        768: {
            slidesPerView: 2,
        },
        1200: {
            slidesPerView: 3,
        }
    }
});
</script>

<script>
    // Initialize Hero Swiper with smooth transitions
    document.addEventListener('DOMContentLoaded', function() {
        // Hero Carousel
        const heroSwiper = new Swiper('.hero-swiper', {
            direction: 'horizontal',
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 8000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.hero-pagination',
                clickable: true,
                bulletClass: 'hero-pagination-bullet',
                bulletActiveClass: 'hero-pagination-bullet-active',
            },
            navigation: {
                nextEl: '.hero-next',
                prevEl: '.hero-prev',
            },
            on: {
                init: function() {
                    // Initialize animation for active slide
                    const activeSlide = this.slides[this.activeIndex];
                    const content = activeSlide.querySelector('.hero-slide-content');
                    setTimeout(() => {
                        content.style.opacity = '1';
                        content.style.transform = 'translateY(0)';
                    }, 100);
                },
                slideChange: function() {
                    // Animate out previous slide
                    const prevSlide = this.slides[this.previousIndex];
                    const prevContent = prevSlide.querySelector('.hero-slide-content');
                    prevContent.style.opacity = '0';
                    prevContent.style.transform = 'translateY(50px)';
                    
                    // Animate in current slide
                    const activeSlide = this.slides[this.activeIndex];
                    const content = activeSlide.querySelector('.hero-slide-content');
                    setTimeout(() => {
                        content.style.opacity = '1';
                        content.style.transform = 'translateY(0)';
                    }, 300);
                }
            }
        });

        // Scroll animation for elements
        const animateElements = document.querySelectorAll('.animate-on-scroll');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        animateElements.forEach(el => observer.observe(el));

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const target = document.querySelector(targetId);
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Job card hover effects
        document.querySelectorAll('.job-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Category card hover effects
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Testimonial card hover effects
        document.querySelectorAll('.testimonial-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Button hover effects
        document.querySelectorAll('.cta-btn, .btn-apply, .btn-view-all').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Search form submission animation
        const searchForm = document.querySelector('.search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                const searchBtn = this.querySelector('.search-btn');
                const originalText = searchBtn.innerHTML;
                searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
                searchBtn.disabled = true;
                
                setTimeout(() => {
                    searchBtn.innerHTML = originalText;
                    searchBtn.disabled = false;
                }, 1500);
            });
        }

        // Initialize animations for elements already in view
        animateElements.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                el.classList.add('animated');
            }
        });

        // Save job button functionality
        document.querySelectorAll('.btn-save').forEach(btn => {
            btn.addEventListener('click', function() {
                const jobId = this.getAttribute('data-job-id');
                const icon = this.querySelector('i');
                
                // Send AJAX request to save job
                fetch(`/jobs/${jobId}/save`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.saved) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        icon.style.color = 'var(--primary)';
                        this.style.borderColor = 'var(--primary)';
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        icon.style.color = '';
                        this.style.borderColor = 'var(--gray-300)';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show error message
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
                    this.style.color = 'var(--warning)';
                    
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                    }, 1000);
                });
            });
        });

        // Counter animation for stats
        const statNumbers = document.querySelectorAll('.stat-number');
        const statObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const stat = entry.target;
                    const target = parseInt(stat.textContent.replace(/[^0-9]/g, ''));
                    let current = 0;
                    const increment = target / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        stat.textContent = Math.floor(current).toLocaleString() + '+';
                    }, 30);
                    statObserver.unobserve(stat);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(stat => statObserver.observe(stat));
    });
</script>
@endpush