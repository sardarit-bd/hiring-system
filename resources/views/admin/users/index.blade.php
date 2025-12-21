@extends('layouts.admin')

@section('title', 'Manage Users - ' . config('app.name'))

@section('page-title', 'Manage Users')

@section('breadcrumbs')
    <!-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li> -->
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary me-2">All Users ({{ $users->total() }})</h6>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="fas fa-filter me-1 text-light"></i>Filters
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">User</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Joined</th>
                                    <th class="text-center" style="width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                    @if($user->company_name)
                                                        <br><small class="text-muted">{{ $user->company_name }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'employer' ? 'primary' : 'success') }}">
                                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" 
                                                    data-bs-target="#userModal{{ $user->id }}" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            @if($user->id !== auth()->id())
                                                <!-- Super admin check: যদি current user super admin হয়, অথবা target user admin না হয় -->
                                                @if(auth()->user()->isSuperAdmin() || !$user->isAdmin())
                                                    <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="btn-group" role="group">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }}" 
                                                                title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}"
                                                                onclick="return confirm('Are you sure you want to {{ $user->is_active ? 'deactivate' : 'activate' }} this user?')">
                                                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="btn-group" role="group">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" 
                                                                onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                                                                title="Delete User">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <!-- Regular admin অন্য admin কে manage করতে পারবে না -->
                                                    <button class="btn btn-secondary" disabled title="Cannot manage admin users">
                                                        <i class="fas fa-user-shield"></i>
                                                    </button>
                                                @endif
                                            @else
                                                <button class="btn btn-secondary" disabled title="Cannot modify your own account">
                                                    <i class="fas fa-user-lock"></i>
                                                </button>
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
                        {{ $users->withQueryString()->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h4>No users found</h4>
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
                <h5 class="modal-title">Filter Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="GET" action="{{ route('admin.users') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="employer" {{ request('role') == 'employer' ? 'selected' : '' }}>Employer</option>
                            <option value="job_seeker" {{ request('role') == 'job_seeker' ? 'selected' : '' }}>Job Seeker</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email..." value="{{ request('search') }}">
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

<!-- User Details Modals (Placed at the end of body to avoid blink issue) -->
@foreach($users as $user)
<div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header  px-4">
                <h5 class="modal-title">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row p-3">
                    <div class="col-md-6">
                        <h4 class="mb-3 text-primary">Basic Information</h6>
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</p>
                        <p><strong>Address:</strong> {{ $user->address ?? 'Not provided' }}</p>
                        <p><strong>Registered:</strong> {{ $user->created_at->format('F d, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h4 class="mb-3 text-primary">Role Information</h6>
                        <p><strong>Role:</strong> {{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                        <p><strong>Status:</strong> 
                            @if($user->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>
                        
                        @if($user->isEmployer())
                            <hr>
                            <h4 class="mb-3 text-primary">Company Information</h4>
                            <p><strong>Company:</strong> {{ $user->company_name }}</p>
                            <p><strong>Industry:</strong> {{ $user->industry ?? 'Not specified' }}</p>
                            <p><strong>Website:</strong> 
                                @if($user->website)
                                    <a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a>
                                @else
                                    Not provided
                                @endif
                            </p>
                            <p><strong>Jobs Posted:</strong> {{ $user->openjobs()->count() }}</p>
                        @endif
                        
                        @if($user->isJobSeeker())
                            <hr>
                            <h6>Job Seeker Information</h6>
                            <p><strong>Skills:</strong> 
                                @if($user->skills && is_array(json_decode($user->skills, true)))
                                    {{ implode(', ', json_decode($user->skills, true)) }}
                                @else
                                    Not specified
                                @endif
                            </p>
                            <p><strong>Applications:</strong> {{ $user->applications()->count() }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
@endforeach
@endsection

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
    }
</style>
@endpush