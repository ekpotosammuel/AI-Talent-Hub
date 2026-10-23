<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class InterviewPrepController extends Controller
{
    public function index(): View
    {
        return view('candidate.interview-prep.index', [
            'tracks' => MockData::interviewTracks(),
            'feedback' => MockData::postInterviewFeedback(),
            'applications' => MockData::applications()->take(2),
        ]);
    }

    public function session(): View
    {
        return view('candidate.interview-prep.session', [
            'interview' => MockData::mockInterview(),
        ]);
    }
}
