<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'company_name',
        'website',
        'industry',
        'resume_path',
        'skills',
        'experience',
        'education',
        'is_active',
        'profile_picture',
        'profile_picture',
        'is_super_admin' ,
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'skills' => 'array',
        'is_active' => 'boolean',
        'is_super_admin' => 'boolean'
    ];

    // Relationships
    public function openjobs()
    {
        return $this->hasMany(OpenJob::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_seeker_id');
    }

    // Scopes
    public function scopeEmployers($query)
    {
        return $query->where('role', 'employer');
    }

    public function scopeJobSeekers($query)
    {
        return $query->where('role', 'job_seeker');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helpers
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEmployer()
    {
        return $this->role === 'employer';
    }

    public function isJobSeeker()
    {
        return $this->role === 'job_seeker';
    }

    public function hasApplied($jobId)
    {
        return $this->applications()->where('job_id', $jobId)->exists();
    }
    // Add these relationships
    public function jobSeekerProfile()
    {
        return $this->hasOne(JobSeekerProfile::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class)->orderBy('sort_order', 'desc');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class)->orderBy('sort_order', 'desc');
    }

    public function projects()
    {
        return $this->hasMany(Project::class)->orderBy('sort_order', 'desc');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class)->orderBy('sort_order', 'desc');
    }

    // Helper methods
    public function getSkillsArray()
    {
        if (!$this->skills) {
            return [];
        }
        
        try {
            $skills = json_decode($this->skills, true);
            return is_array($skills) ? $skills : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getFormattedSkills()
    {
        $skills = $this->getSkillsArray();
        return implode(', ', $skills);
    }

    // Check if user has complete profile
    public function hasCompleteProfile()
    {
        if (!$this->jobSeekerProfile) {
            return false;
        }
        
        return $this->jobSeekerProfile->profile_completion >= 70;
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return Storage::url($this->profile_picture);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4e73df&color=fff&size=200&bold=true';
    }

    public function isSuperAdmin()
    {
        return $this->is_super_admin === true;
    }
}