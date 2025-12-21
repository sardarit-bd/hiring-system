@extends('layouts.admin')

@section('title', 'Settings - ' . config('app.name'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">Settings</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Site Settings</h4>
                </div>
                <div class="card-body">
                    <!-- @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif -->

                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- General Settings -->
                        <div class="mb-5">
                            <h5 class="mb-3 border-bottom pb-2">General Settings</h5>
                            <div class="row">
                                @foreach($settings['general'] ?? [] as $setting)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $setting->description }}</label>
                                        
                                        @if($setting->type === 'textarea')
                                            <textarea name="{{ $setting->key }}" 
                                                class="form-control" rows="4">{{ old($setting->key, $setting->value) }}</textarea>
                                        @elseif($setting->type === 'image')
                                            <div class="mb-2">
                                                @if($setting->value)
                                                    <img src="{{ Storage::url($setting->value) }}" 
                                                        alt="{{ $setting->description }}" 
                                                        class="img-thumbnail" style="max-height: 100px;">
                                                    <br>
                                                    <small>Current {{ $setting->description }}</small>
                                                @endif
                                            </div>
                                            <input type="file" name="{{ $setting->key }}" 
                                                class="form-control">
                                        @else
                                            <input type="text" name="{{ $setting->key }}" 
                                                value="{{ old($setting->key, $setting->value) }}"
                                                class="form-control">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-5">
                            <h5 class="mb-3 border-bottom pb-2">Contact Information</h5>
                            <div class="row">
                                @foreach($settings['contact'] ?? [] as $setting)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $setting->description }}</label>
                                        
                                        @if($setting->type === 'textarea')
                                            <textarea name="{{ $setting->key }}" 
                                                class="form-control" rows="3">{{ old($setting->key, $setting->value) }}</textarea>
                                        @else
                                            <input type="text" name="{{ $setting->key }}" 
                                                value="{{ old($setting->key, $setting->value) }}"
                                                class="form-control">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Legal Pages -->
                        <div class="mb-5">
                            <h5 class="mb-3 border-bottom pb-2">Legal Pages</h5>
                            <div class="row">
                                @foreach($settings['legal'] ?? [] as $setting)
                                    <div class="col-12 mb-3">
                                        <label class="form-label">{{ $setting->description }}</label>
                                        <textarea name="{{ $setting->key }}" 
                                            class="form-control" rows="8">{{ old($setting->key, $setting->value) }}</textarea>
                                        <small class="form-text text-muted">HTML allowed</small>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="mb-5">
                            <h5 class="mb-3 border-bottom pb-2">Social Media Links</h5>
                            <div class="row">
                                @foreach($settings['social'] ?? [] as $setting)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $setting->description }}</label>
                                        <input type="url" name="{{ $setting->key }}" 
                                            value="{{ old($setting->key, $setting->value) }}"
                                            class="form-control">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="mb-5">
                            <h5 class="mb-3 border-bottom pb-2">SEO Settings</h5>
                            <div class="row">
                                @foreach($settings['seo'] ?? [] as $setting)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $setting->description }}</label>
                                        
                                        @if($setting->type === 'textarea')
                                            <textarea name="{{ $setting->key }}" 
                                                class="form-control" rows="3">{{ old($setting->key, $setting->value) }}</textarea>
                                        @else
                                            <input type="text" name="{{ $setting->key }}" 
                                                value="{{ old($setting->key, $setting->value) }}"
                                                class="form-control">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <!-- <button type="cencel"
                                class="btn btn-secondary">
                                <i class="fas fa-sync-alt"></i> Clear
                            </button> -->
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function clearCache() {
    if(confirm('Are you sure you want to clear cache?')) {
        fetch('{{ route("admin.settings.clear-cache") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Cache cleared successfully!');
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error clearing cache');
        });
    }
}
</script>
@endsection