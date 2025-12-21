<?php

namespace App\Http\Controllers;

use App\Models\OpenJob;
use App\Models\JobApplication;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = OpenJob::where('status', 'approved')
            ->where('is_active', true)
            ->where('deadline', '>=', now())
            ->with('employer');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('location', 'LIKE', "%{$search}%")
                ->orWhere('category', 'LIKE', "%{$search}%");
            });
        }

        // Filters
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('location') && $request->location) {
            $query->where('location', $request->location);
        }

        if ($request->has('job_type') && $request->job_type) {
            $query->where('job_type', $request->job_type);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'salary_high':
                $query->orderByRaw('COALESCE(salary_max, salary_min, 0) DESC');
                break;
            case 'salary_low':
                $query->orderByRaw('COALESCE(salary_min, salary_max, 999999999) ASC');
                break;
            default:
                $query->latest();
        }

        $jobs = $query->paginate(15);
        
        // Get unique categories and locations
        $categories = Category::pluck('name', 'id');
            
        $locations = OpenJob::where('status', 'approved')
            ->select('location')
            ->distinct()
            ->pluck('location')
            ->filter()
            ->values();

        return view('jobs.index', compact('jobs', 'categories', 'locations'));
    }

    public function show(OpenJob $openjob)
    {
        // Increment views
        $openjob->increment('views');
        
        $openjob->load('employer');
        
        $hasApplied = false;
        if (Auth::check() && Auth::user()->isJobSeeker()) {
            $hasApplied = Auth::user()->hasApplied($openjob->id);
        }

        $relatedJobs = OpenJob::where('status', 'approved')
            ->where('is_active', true)
            ->where('deadline', '>=', now())
            ->where('category', $openjob->category)
            ->where('id', '!=', $openjob->id)
            ->take(5)
            ->get();

        return view('jobs.show', compact('openjob', 'hasApplied', 'relatedJobs'));
    }

    public function create()
    {
        // Check if user is employer
        if (!Auth::user()->isEmployer()) {
            abort(403, 'Only employers can post jobs.');
        }

        $categories = Category::pluck('name', 'id');
        
        return view('jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Check if user is employer
        if (!Auth::user()->isEmployer()) {
            abort(403, 'Only employers can post jobs.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:100',
            'job_type' => 'required|in:full_time,part_time,contract,internship,remote',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_type' => 'required|in:monthly,yearly,hourly',
            'deadline' => 'required|date|after:today',
            'vacancy' => 'required|integer|min:1',
        ]);

        // Validate salary range
        if ($request->salary_min && $request->salary_max && $request->salary_min > $request->salary_max) {
            return back()->withErrors(['salary_min' => 'Minimum salary cannot be greater than maximum salary.'])->withInput();
        }

        $validated['employer_id'] = Auth::id();
        $validated['status'] = 'pending';
        $validated['is_active'] = true;

        OpenJob::create($validated);

        return redirect()->route('jobs.my-jobs')
            ->with('success', 'Job posted successfully! Waiting for admin approval.');
    }

    public function edit(OpenJob $openjob)
    {
        // Check ownership
        if ($openjob->employer_id !== Auth::id()) {
            abort(403);
        }

        // Get categories for dropdown
        $categories = Category::pluck('name', 'id');
        
        // Get user profile if exists (for job seekers viewing the page)
        $profile = null;
        $user = Auth::user();
        
        if ($user && method_exists($user, 'jobSeekerProfile')) {
            $profile = $user->jobSeekerProfile;
        }

        return view('jobs.edit', [
            'openjob' => $openjob,  
            'categories' => $categories,
            'profile' => $profile,
            'user' => $user,
        ]);
    }

    public function update(Request $request, OpenJob $openjob)
    {
        // Check ownership
        if ($openjob->employer_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:100',
            'job_type' => 'required|in:full_time,part_time,contract,internship,remote',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'salary_type' => 'required|in:monthly,yearly,hourly',
            'deadline' => 'required|date',
            'vacancy' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        // Validate salary range
        if ($request->salary_min && $request->salary_max && $request->salary_min > $request->salary_max) {
            return back()->withErrors(['salary_min' => 'Minimum salary cannot be greater than maximum salary.'])->withInput();
        }

        $openjob->update($validated);

        return redirect()->route('jobs.my-jobs')
            ->with('success', 'Job updated successfully!');
    }

    public function destroy(OpenJob $openjob)
    {
        // Check ownership
        if ($openjob->employer_id !== Auth::id()) {
            abort(403);
        }

        $openjob->delete();

        return redirect()->route('jobs.my-jobs')
            ->with('success', 'Job deleted successfully!');
    }

    public function myJobs()
    {
        // Check if user is employer
        if (!Auth::user()->isEmployer()) {
            abort(403, 'Only employers can view their jobs.');
        }

        $jobs = OpenJob::where('employer_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('jobs.my-jobs', compact('jobs'));
    }

    public function approve(OpenJob $openjob)
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only admins can approve jobs.');
        }

        $openjob->update(['status' => 'approved']);

        return back()->with('success', 'Job approved successfully!');
    }

    public function reject(OpenJob $openjob)
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only admins can reject jobs.');
        }

        $openjob->update(['status' => 'rejected']);

        return back()->with('success', 'Job rejected!');
    }

    public function apply(Request $request, OpenJob $openjob)
{
    // Check if user is job seeker
    if (!Auth::user()->isJobSeeker()) {
        abort(403, 'Only job seekers can apply for jobs.');
    }

    $request->validate([
        'cover_letter' => 'required|string|min:100|max:1000',
        'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    // Check if already applied
    if (Auth::user()->hasApplied($openjob->id)) {
        return back()->with('error', 'You have already applied for this job!');
    }

    // Check if job is active and approved
    if (!$openjob->is_active || $openjob->status !== 'approved' || $openjob->deadline < now()) {
        return back()->with('error', 'This job is no longer accepting applications.');
    }

    $applicationData = [
        'job_id' => $openjob->id,
        'job_seeker_id' => Auth::id(),
        'cover_letter' => $request->cover_letter,
        'applied_at' => now(),
    ];

    // Handle resume upload with applicant's name
    if ($request->hasFile('resume')) {
        $file = $request->file('resume');
        $user = Auth::user();
        
        // Clean applicant name (remove special characters and spaces)
        $applicantName = preg_replace('/[^A-Za-z0-9]/', '_', $user->name);
        
        // Clean job title
        $jobTitle = preg_replace('/[^A-Za-z0-9]/', '_', $openjob->title);
        
        // Get file extension
        $extension = $file->getClientOriginalExtension();
        
        // Create filename: ApplicantName_JobTitle_Timestamp.ext
        $filename = $applicantName . '.' . $extension;
        
        // Make sure filename is not too long
        if (strlen($filename) > 150) {
            // Shorten job title if needed
            $jobTitle = substr($jobTitle, 0, 50);
            $filename = $applicantName . '.' . $extension;
        }
        
        // Store file with custom name
        $path = $file->storeAs('resumes', $filename, 'public');
        $applicationData['resume_path'] = $path;
    } else {
        // Use existing resume from profile
        $applicationData['resume_path'] = Auth::user()->resume_path;
    }

    JobApplication::create($applicationData);

    return back()->with('success', 'Application submitted successfully!');
}
    

    public function category($slug)
    {
        $jobs = OpenJob::with(['employer', 'category'])
            ->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->where('status', 'approved')
            ->where('is_active', 1)
            ->whereDate('deadline', '>=', now())
            ->latest()
            ->paginate(10);

        $category = Category::where('slug', $slug)->firstOrFail();

        return view('jobs.category', compact('jobs', 'category'));
    }

}