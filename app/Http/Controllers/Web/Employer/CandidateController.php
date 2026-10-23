<?php

namespace App\Http\Controllers\Web\Employer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function __invoke(string $candidate = 'amara-okonkwo'): View
    {
        return view('employer.candidates.show', [
            'candidate' => MockData::candidate(),
            'record' => MockData::verificationRecord(),
            'interview' => MockData::aiInterview(),
            'job' => MockData::jobs()->first(),
            'cv' => MockData::cvReview(),
        ]);
    }
}
