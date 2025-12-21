<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin - ' . config('app.name'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            /* Bluish-White Color Scheme */
            --sidebar-bg: #ffffff;
            --sidebar-color: #4a5568;
            --sidebar-active: #2b6cb0;
            --sidebar-hover: #edf2f7;
            --sidebar-border: #e2e8f0;
            
            --header-bg: #ffffff;
            --header-color: #2d3748;
            --header-border: #e2e8f0;
            
            --main-bg: #f7fafc;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            
            /* Primary Colors - Blue Tones */
            --primary: #2b6cb0;
            --primary-light: #4299e1;
            --primary-dark: #2c5282;
            
            /* Status Colors */
            --success: #38a169;
            --info: #3182ce;
            --warning: #d69e2e;
            --danger: #e53e3e;
            
            /* Neutral Colors */
            --secondary: #718096;
            --light: #edf2f7;
            --dark: #2d3748;
            --white: #ffffff;
            
            /* Layout */
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --header-height: 75px;
            --border-radius: 12px;
            --border-radius-sm: 8px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --box-shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--main-bg);
            color: var(--dark);
            overflow-x: hidden;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            z-index: 1000;
            transition: var(--transition);
            box-shadow: var(--box-shadow-sm);
            overflow-y: auto;
            padding-bottom: 20px;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }

        /* Brand Section */
        .sidebar-brand {
            padding: 18px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--sidebar-border);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            margin-bottom: 15px;
        }

        .sidebar-logo {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary);
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(43, 108, 176, 0.15);
        }

        .brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--white);
            letter-spacing: 0.5px;
        }

        .brand-subtitle {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 400;
            margin-top: 2px;
        }

        /* Navigation */
        .sidebar-nav {
            padding: 0 20px;
        }

        .nav-title {
            color: var(--secondary);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 20px 0 10px;
            font-weight: 600;
            margin-top: 10px;
            border-top: 1px solid var(--border-color);
        }

        .nav-title:first-child {
            border-top: none;
            margin-top: 0;
        }

        .nav-item {
            list-style: none;
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--sidebar-color);
            text-decoration: none;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
            position: relative;
            font-weight: 500;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: var(--primary);
            transform: translateX(5px);
        }

        .nav-link:hover .nav-icon {
            color: var(--primary);
        }

        .nav-link.active {
            background: rgba(43, 108, 176, 0.1);
            color: var(--primary);
            font-weight: 600;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -0px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 40%;
            background: var(--primary);
            border-radius: 0 4px 4px 0;
        }

        .nav-icon {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            margin-right: 12px;
            color: var(--secondary);
            transition: var(--transition);
        }

        .nav-link.active .nav-icon {
            color: var(--primary);
        }

        .nav-text {
            flex-grow: 1;
        }

        .badge-nav {
            background: lightcoral;
            color: var(--white);
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 600;
            min-width: 24px;
            text-align: center;
        }

        .badge-nav.warning {
            background: var(--warning);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: var(--transition);
            min-height: 100vh;
            background: var(--main-bg);
        }

        /* ===== HEADER ===== */
        .header {
            position: sticky;
            top: 0;
            z-index: 999;
            background: var(--header-bg);
            height: var(--header-height);
            border-bottom: 1px solid var(--header-border);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .toggle-btn {
            background: var(--light);
            border: none;
            color: var(--primary);
            font-size: 1.3rem;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .toggle-btn:hover {
            background: var(--primary);
            color: var(--white);
            transform: rotate(90deg);
        }

        .header-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0;
        }

        /* Header Right */
        .header-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 10px;
        }

        .quick-btn {
            width: 40px;
            height: 40px;
            border-radius: var(--border-radius-sm);
            background: var(--light);
            border: 1px solid var(--border-color);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition);
        }

        .quick-btn:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(43, 108, 176, 0.2);
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
            background: var(--light);
            border: 1px solid transparent;
        }

        .user-trigger:hover {
            background: var(--white);
            border-color: var(--border-color);
            box-shadow: var(--box-shadow-sm);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.2rem;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(43, 108, 176, 0.2);
        }

        .user-info {
            line-height: 1.3;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--secondary);
            font-weight: 500;
        }

        .user-caret {
            color: var(--secondary);
            font-size: 0.9rem;
            transition: var(--transition);
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            box-shadow: var(--box-shadow);
            padding: 10px;
            min-width: 220px;
            margin-top: 10px;
        }

        .dropdown-item {
            padding: 10px 15px;
            border-radius: var(--border-radius-sm);
            color: var(--dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: var(--light);
            color: var(--primary);
        }

        .dropdown-item i {
            width: 20px;
            color: var(--secondary);
        }

        .dropdown-divider {
            margin: 8px 0;
            border-color: var(--border-color);
        }

        /* ===== CONTENT AREA ===== */
        .content-wrapper {
            padding: 30px;
            min-height: calc(100vh - var(--header-height));
        }

        /* Page Header */
        .page-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title i {
            color: var(--primary);
            font-size: 1.6rem;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item {
            color: var(--secondary);
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .breadcrumb-item a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: var(--dark);
            font-weight: 500;
        }

        /* ===== CARDS ===== */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-sm);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--box-shadow);
            transform: translateY(-3px);
        }

        .card-header {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 20px 25px;
            font-weight: 600;
            color: var(--primary-dark);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header i {
            color: var(--primary);
            margin-right: 10px;
        }

        .card-body {
            padding: 25px;
        }

        /* ===== STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 25px;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .stat-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(43, 108, 176, 0.1);
        }

        .stat-icon-container {
            position: absolute;
            top: 25px;
            right: 25px;
            width: 60px;
            height: 60px;
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--white);
            z-index: 1;
        }

        .stat-card.primary .stat-icon-container {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        }

        .stat-card.success .stat-icon-container {
            background: linear-gradient(135deg, var(--success) 0%, #48bb78 100%);
        }

        .stat-card.info .stat-icon-container {
            background: linear-gradient(135deg, var(--info) 0%, #63b3ed 100%);
        }

        .stat-card.warning .stat-icon-container {
            background: linear-gradient(135deg, var(--warning) 0%, #ecc94b 100%);
        }

        .stat-card.danger .stat-icon-container {
            background: linear-gradient(135deg, var(--danger) 0%, #fc8181 100%);
        }

        .stat-content {
            position: relative;
            z-index: 2;
        }

        .stat-title {
            font-size: 0.9rem;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
            line-height: 1;
        }

        .stat-subtitle {
            font-size: 0.85rem;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat-change {
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .stat-change.positive {
            background: rgba(56, 161, 105, 0.1);
            color: var(--success);
        }

        .stat-change.negative {
            background: rgba(229, 62, 62, 0.1);
            color: var(--danger);
        }

        /* ===== TABLES ===== */
        .table-container {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .table {
            margin-bottom: 0;
            border-color: var(--border-color);
        }

        .table thead th {
            background: var(--light);
            border: none;
            padding: 18px 20px;
            font-weight: 600;
            color: var(--dark);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            border-color: var(--border-color);
            color: var(--dark);
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background: var(--light);
        }

        /* ===== BUTTONS ===== */
        .btn {
            border-radius: var(--border-radius-sm);
            padding: 10px 22px;
            font-weight: 500;
            transition: var(--transition);
            border: 1px solid transparent;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(43, 108, 176, 0.3);
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 0.85rem;
        }

        /* ===== BADGES ===== */
        .badge {
            padding: 6px 12px;
            font-weight: 500;
            border-radius: 20px;
            font-size: 0.8rem;
            border: 1px solid transparent;
        }

        .badge-primary {
            background: rgba(43, 108, 176, 0.1);
            color: var(--primary);
            border-color: rgba(43, 108, 176, 0.2);
        }

        .badge-success {
            background: rgba(56, 161, 105, 0.1);
            color: var(--success);
            border-color: rgba(56, 161, 105, 0.2);
        }

        .badge-info {
            background: rgba(49, 130, 206, 0.1);
            color: var(--info);
            border-color: rgba(49, 130, 206, 0.2);
        }

        .badge-warning {
            background: rgba(214, 158, 46, 0.1);
            color: var(--warning);
            border-color: rgba(214, 158, 46, 0.2);
        }

        .badge-danger {
            background: rgba(229, 62, 62, 0.1);
            color: var(--danger);
            border-color: rgba(229, 62, 62, 0.2);
        }

        /* ===== ALERTS ===== */
        .alert {
            border: none;
            border-radius: var(--border-radius-sm);
            padding: 16px 20px;
            margin-bottom: 20px;
            font-weight: 500;
            border-left: 4px solid transparent;
        }

        .alert i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .alert-success {
            background: rgba(56, 161, 105, 0.1);
            color: var(--success);
            border-left-color: var(--success);
        }

        .alert-danger {
            background: rgba(229, 62, 62, 0.1);
            color: var(--danger);
            border-left-color: var(--danger);
        }

        .alert-info {
            background: rgba(49, 130, 206, 0.1);
            color: var(--info);
            border-left-color: var(--info);
        }

        .alert-warning {
            background: rgba(214, 158, 46, 0.1);
            color: var(--warning);
            border-left-color: var(--warning);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--header-bg);
            border-top: 1px solid var(--header-border);
            padding: 20px 30px;
            transition: var(--transition);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--secondary);
            font-size: 0.9rem;
        }

        .footer-links a {
            color: var(--primary);
            text-decoration: none;
            margin-left: 20px;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* ===== SIDEBAR COLLAPSED ===== */
        .sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed);
        }

        .sidebar-collapsed .brand-text,
        .sidebar-collapsed .brand-subtitle,
        .sidebar-collapsed .nav-text,
        .sidebar-collapsed .nav-title,
        .sidebar-collapsed .badge-nav {
            display: none !important;
        }

        .sidebar-collapsed .sidebar-brand {
            justify-content: center;
            padding: 20px 10px;
        }

        .sidebar-collapsed .sidebar-logo {
            margin-right: 0;
        }

        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding: 15px;
        }

        .sidebar-collapsed .nav-icon {
            margin-right: 0;
            font-size: 1.4rem;
        }

        .sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed);
        }

        .sidebar-collapsed .footer {
            margin-left: var(--sidebar-collapsed);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 5px 0 25px rgba(0, 0, 0, 0.1);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .footer {
                margin-left: 0 !important;
            }
            
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
                backdrop-filter: blur(2px);
            }
            
            .overlay.show {
                display: block;
            }

            .header-title {
                font-size: 1.4rem;
            }

            .user-info {
                display: none;
            }

            .user-caret {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 20px 15px;
            }

            .header {
                padding: 0 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .slide-in-left {
            animation: slideInLeft 0.4s ease-out;
        }

        /* ===== CUSTOM SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Overlay for Mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <!-- <div class="sidebar-logo">
                <i class="fas fa-briefcase"></i>
            </div> -->
            <div>
                <div class="brand-text">Admin Panel</div>
                <!-- <div class="brand-subtitle">Admin Panel</div> -->
            </div>
        </div>

        <!-- Navigation -->
        <ul class="sidebar-nav">
            <!-- Dashboard -->
            <!-- <li class="nav-title">Dashboard</li> -->
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <!-- <i class="nav-icon fas fa-pen-to-sqare-alt"></i> -->
                    <span class="nav-text">Overview</span>
                </a>
            </li>

            <!-- Management -->
            <!-- <li class="nav-title">Management</li> -->
            <li class="nav-item">
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <!-- <i class="nav-icon fas fa-users"></i> -->
                    <span class="nav-text">Users</span>
                    <span class="badge-nav">{{ \App\Models\User::count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.jobs') }}" class="nav-link {{ request()->routeIs('admin.jobs*') || request()->routeIs('jobs.approve') || request()->routeIs('jobs.reject') ? 'active' : '' }}">
                    <!-- <i class="nav-icon fas fa-briefcase"></i> -->
                    <span class="nav-text">Jobs</span>
                    <span class="badge-nav warning">{{ \App\Models\OpenJob::where('status', 'pending')->count() }}</span>
                </a>
            </li>

            <!-- Analytics -->
            <!-- <li class="nav-title">Analytics</li> -->
            <li class="nav-item">
                <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <!-- <i class="nav-icon fas fa-chart-line"></i> -->
                    <span class="nav-text">Reports</span>
                </a>
            </li>

            <!-- Configuration -->
            <!-- <li class="nav-title">Configuration</li> -->
            <li class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.index*') ? 'active' : '' }}">
                    <!-- <i class="nav-icon fas fa-cogs"></i> -->
                    <span class="nav-text">Settings</span>
                </a>
            </li>
            <!-- Contact Messages Link -->
            <li class="nav-item {{ request()->is('admin/contact*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.contact.index') }}">
                    <!-- <i class="fas fa-envelope me-2"></i> -->
                    <span class="nav-text">Contact Messages</span>
                    @php
                        $unreadCount = \App\Models\ContactMessage::unread()->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="badge-nav">{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <header class="header fade-in-up">
            <div class="header-left">
                <button class="toggle-btn" id="toggleBtn" title="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="header-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            
            <div class="header-right">
                <!-- Quick Actions -->
                <div class="quick-actions">
                    <a href="{{ route('dashboard') }}" class="quick-btn" title="User Dashboard">
                        <i class="fas fa-exchange-alt"></i>
                    </a>
                    <a href="{{ route('home') }}" class="quick-btn" title="View Website">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
                
                <!-- User Dropdown -->
                <div class="dropdown user-dropdown">
                    <div class="user-trigger" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                        </div>
                        <i class="fas fa-chevron-down user-caret"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-cog"></i> Account Settings
                            </a>
                        </li>
                        <!-- <li>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li> -->
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Breadcrumbs & Page Header -->
            <div class="page-header slide-in-left">
                <!-- <h1 class="page-title">
                    <i class="fas fa-@yield('page-icon', 'tachometer-alt')"></i>
                    @yield('page-title', 'Dashboard')
                </h1> -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        @yield('breadcrumbs')
                    </ol>
                </nav>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Content -->
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div>
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
                <div class="footer-links">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a href="{{ route('admin.settings.index') }}">Settings</a>
                    <a href="{{ route('home') }}">Visit Site</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Script -->
    <script>
        // Sidebar Toggle
        const toggleBtn = document.getElementById('toggleBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const overlay = document.getElementById('overlay');
        const body = document.body;

        // Toggle sidebar
        toggleBtn.addEventListener('click', function() {
            if (window.innerWidth <= 1200) {
                // Mobile view
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : 'auto';
            } else {
                // Desktop view
                body.classList.toggle('sidebar-collapsed');
                // Save preference
                const isCollapsed = body.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            }
        });

        // Close sidebar when clicking overlay (mobile)
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            body.style.overflow = 'auto';
        });

        // Auto-dismiss alerts
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Restore sidebar state
            const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (sidebarCollapsed && window.innerWidth > 1200) {
                body.classList.add('sidebar-collapsed');
            }

            // Active menu highlighting
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                if (link.href === window.location.href) {
                    link.classList.add('active');
                }
            });

            // Add animation to stat cards
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('fade-in-up');
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1200) {
                // Desktop - remove mobile overlay if present
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                body.style.overflow = 'auto';
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userDropdown = document.querySelector('.user-dropdown');
            if (!userDropdown.contains(event.target)) {
                const dropdown = bootstrap.Dropdown.getInstance(userDropdown.querySelector('[data-bs-toggle="dropdown"]'));
                if (dropdown) dropdown.hide();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>