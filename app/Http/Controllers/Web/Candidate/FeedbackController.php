<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function __invoke(): View
    {
        return view('candidate.feedback', [
            'feedback' => MockData::postInterviewFeedback(),
            'applications' => MockData::applications()->where('has_feedback', true),
        ]);
    }
}
