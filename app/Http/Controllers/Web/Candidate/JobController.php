<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(): View
    {
        return view('candidate.jobs.index', [
            'jobs' => MockData::jobs(),
            'feeds' => config('talent.job_feeds.providers'),
            'threshold' => (int) config('talent.match_threshold'),
            'candidate' => MockData::candidate(),
        ]);
    }

    public function show(string $job = 'JOB-4821'): View
    {
        $jobs = MockData::jobs();

        return view('candidate.jobs.show', [
            'job' => $jobs->firstWhere('id', $job) ?? $jobs->first(),
            'candidate' => MockData::candidate(),
            'cv' => MockData::cvReview(),
        ]);
    }
}
