@extends('layouts.admin')

@section('title', 'Admin Dashboard - ' . config('app.name'))

@section('page-title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
@php
    // Set default values if variables are not passed
    $monthlyStats = $monthlyStats ?? [
        'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        'user_counts' => array_fill(0, 12, 0),
        'application_counts' => array_fill(0, 12, 0),
    ];
    
    $jobStatusData = $jobStatusData ?? [0, 0, 0, 0];
    
    $userRoleData = $userRoleData ?? [0, 0, 0];
@endphp

<div class="row">
    <!-- Stats Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="stat-title">Total Users</div>
                        <div class="stat-value">{{ $stats['total_users'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="stat-title">Total Jobs</div>
                        <div class="stat-value">{{ $stats['total_jobs'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="stat-title">Total Applications</div>
                        <div class="stat-value">{{ $stats['total_applications'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="stat-title">Pending Jobs</div>
                        <div class="stat-value">{{ $stats['pending_jobs'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Monthly User Registration Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Monthly User Registration</h6>
            </div>
            <div class="card-body">
                <canvas id="userRegistrationChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Job Applications Trend Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Job Applications Trend</h6>
            </div>
            <div class="card-body">
                <canvas id="applicationsTrendChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Job Status Distribution Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm border-0" style="height: 300px;">
            <div class="card-header">
                <h6 class="m-0  text-primary">Job Status Distribution</h6>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center p-2" style="height: 250px;">
                <canvas id="jobStatusChart" height="200" style="max-width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <!-- User Role Distribution Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm border-0" style="height: 300px;">
            <div class="card-header">
                <h6 class="m-0  text-primary">User Role Distribution</h6>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center p-2" style="height: 250px;">
                <canvas id="userRoleChart" height="200" style="max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <!-- Recent Jobs -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Recent Job Postings</h6>
                <a href="{{ route('admin.jobs') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Title</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">Status</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentJobs as $job)
                                <tr>
                                    <td class="text-center">
                                        <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                            {{ Str::limit($job->title, 30) }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $job->employer->company_name ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        @if($job->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($job->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <!-- <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($job->status === 'pending')
                                                <form action="{{ route('jobs.approve', $job) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('jobs.reject', $job) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Quick Stats</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-building text-primary me-2"></i>
                            <span>Employers</span>
                        </div>
                        <span class="badge bg-primary rounded-pill">{{ $stats['active_employers'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-user-tie text-success me-2"></i>
                            <span>Job Seekers</span>
                        </div>
                        <span class="badge bg-success rounded-pill">{{ $stats['active_job_seekers'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-user-check text-info me-2"></i>
                            <span>Hired Candidates</span>
                        </div>
                        <span class="badge bg-info rounded-pill">{{ $stats['total_hires'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-chart-line text-warning me-2"></i>
                            <span>Active Jobs</span>
                        </div>
                        <span class="badge bg-warning rounded-pill">{{ \App\Models\OpenJob::where('is_active', true)->where('deadline', '>=', now())->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-primary w-100">
                            <i class="fas fa-users me-2"></i>Manage Users
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.jobs') }}" class="btn btn-success w-100">
                            <i class="fas fa-briefcase me-2"></i>Manage Jobs
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.reports') }}" class="btn btn-info w-100">
                            <i class="fas fa-chart-bar me-2"></i>View Reports
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-warning w-100">
                            <i class="fas fa-cog me-2"></i>Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .stat-card {
        border-left: 4px solid;
        transition: transform 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-card.primary {
        border-left-color: #4e73df;
    }
    .stat-card.success {
        border-left-color: #1cc88a;
    }
    .stat-card.info {
        border-left-color: #36b9cc;
    }
    .stat-card.warning {
        border-left-color: #f6c23e;
    }
    .stat-title {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .stat-value {
        font-size: 1.8rem;
        font-weight: bold;
        color: #2e3a59;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Registration Chart
    const userRegistrationCtx = document.getElementById('userRegistrationChart').getContext('2d');
    const userRegistrationChart = new Chart(userRegistrationCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyStats['months']),
            datasets: [{
                label: 'New Users',
                data: @json($monthlyStats['user_counts']),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Applications Trend Chart
    const applicationsTrendCtx = document.getElementById('applicationsTrendChart').getContext('2d');
    const applicationsTrendChart = new Chart(applicationsTrendCtx, {
        type: 'bar',
        data: {
            labels: @json($monthlyStats['months']),
            datasets: [{
                label: 'Applications',
                data: @json($monthlyStats['application_counts']),
                backgroundColor: '#1cc88a',
                borderColor: '#1cc88a',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Job Status Chart
    const jobStatusCtx = document.getElementById('jobStatusChart').getContext('2d');
    const jobStatusChart = new Chart(jobStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Approved', 'Pending', 'Rejected', 'Expired'],
            datasets: [{
                data: @json($jobStatusData),
                backgroundColor: [
                    '#1cc88a',
                    '#f6c23e',
                    '#e74a3b',
                    '#6c757d'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // User Role Chart
    const userRoleCtx = document.getElementById('userRoleChart').getContext('2d');
    const userRoleChart = new Chart(userRoleCtx, {
        type: 'pie',
        data: {
            labels: ['Admin', 'Employer', 'Job Seeker'],
            datasets: [{
                data: @json($userRoleData),
                backgroundColor: [
                    '#e74a3b',
                    '#4e73df',
                    '#1cc88a'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush