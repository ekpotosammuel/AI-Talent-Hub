<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Enums\ReviewDocument;
use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('candidate.dashboard', [
            'candidate' => MockData::candidate(),
            'tasks' => MockData::readinessTasks(),
            'jobs' => MockData::jobs()->take(3),
            'applications' => MockData::applications()->take(4),
            'documents' => ReviewDocument::cases(),
            'reviews' => [
                ReviewDocument::Cv->value => MockData::cvReview()['overall'],
                ReviewDocument::CoverLetter->value => MockData::coverLetterReview()['overall'],
                ReviewDocument::LinkedinProfile->value => MockData::linkedinReview()['overall'],
            ],
            'tracks' => MockData::interviewTracks(),
        ]);
    }
}
