<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Enums\ReviewDocument;
use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class DocumentReviewController extends Controller
{
    public function cv(): View
    {
        return view('candidate.review.cv', [
            'document' => ReviewDocument::Cv,
            'documents' => ReviewDocument::cases(),
            'review' => MockData::cvReview(),
        ]);
    }

    public function coverLetter(): View
    {
        return view('candidate.review.cover-letter', [
            'document' => ReviewDocument::CoverLetter,
            'documents' => ReviewDocument::cases(),
            'review' => MockData::coverLetterReview(),
        ]);
    }

    public function linkedin(): View
    {
        return view('candidate.review.linkedin', [
            'document' => ReviewDocument::LinkedinProfile,
            'documents' => ReviewDocument::cases(),
            'review' => MockData::linkedinReview(),
        ]);
    }
}
