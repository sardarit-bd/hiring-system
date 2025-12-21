@extends('layouts.admin')

@section('title', 'Contact Messages - ' . config('app.name'))

@section('page-title', 'Contact Messages')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Contact Messages</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Messages</h6>
        <div class="btn-group">
            <a href="{{ route('admin.contact.index', ['status' => 'unread']) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-envelope me-1"></i> Unread ({{ \App\Models\ContactMessage::unread()->count() }})
            </a>
            <a href="{{ route('admin.contact.index', ['status' => 'read']) }}" class="btn btn-info btn-sm">
                <i class="fas fa-envelope-open me-1"></i> Read ({{ \App\Models\ContactMessage::read()->count() }})
            </a>
            <a href="{{ route('admin.contact.index', ['status' => 'replied']) }}" class="btn btn-success btn-sm">
                <i class="fas fa-reply me-1"></i> Replied ({{ \App\Models\ContactMessage::replied()->count() }})
            </a>
            <a href="{{ route('admin.contact.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-list me-1"></i> All Messages
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Search and Filter Form -->
        <form action="{{ route('admin.contact.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <input type="text" name="search" class="form-control" placeholder="Search..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2 mb-2">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                        <option value="spam" {{ request('status') == 'spam' ? 'selected' : '' }}>Spam</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <input type="date" name="date_from" class="form-control" 
                           value="{{ request('date_from') }}" placeholder="From Date">
                </div>
                <div class="col-md-3 mb-2">
                    <input type="date" name="date_to" class="form-control" 
                           value="{{ request('date_to') }}" placeholder="To Date">
                </div>
                <div class="col-md-1 mb-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Messages Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr class="{{ $message->status === 'unread' ? 'table-warning' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $message->name }}</td>
                            <td>
                                <a href="mailto:{{ $message->email }}" class="text-decoration-none">
                                    {{ $message->email }}
                                </a>
                            </td>
                            <td>{{ Str::limit($message->subject, 30) }}</td>
                            <td>{{ Str::limit($message->message, 50) }}</td>
                            <td>{!! $message->status_badge !!}</td>
                            <td>{{ $message->created_at->diffForHumans() }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.contact.show', $message) }}" 
                                       class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($message->status !== 'replied')
                                        <a href="{{ route('admin.contact.show', $message) }}#reply-section" 
                                           class="btn btn-success" title="Reply">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('admin.contact.destroy', $message) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-envelope fa-2x text-muted mb-3"></i>
                                <p class="text-muted">No contact messages found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $messages->links() }}
        </div>

        <!-- Statistics -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ \App\Models\ContactMessage::count() }}</h5>
                        <p class="card-text">Total Messages</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-warning">{{ \App\Models\ContactMessage::unread()->count() }}</h5>
                        <p class="card-text">Unread Messages</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-success">{{ \App\Models\ContactMessage::replied()->count() }}</h5>
                        <p class="card-text">Replied Messages</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-danger">{{ \App\Models\ContactMessage::spam()->count() }}</h5>
                        <p class="card-text">Spam Messages</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection