<?php

namespace App\Http\Controllers\Web;

use App\Enums\ReviewDocument;
use App\Enums\VerificationCheck;
use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function candidates(): View
    {
        return view('marketing.candidates', [
            'documents' => ReviewDocument::cases(),
            'tracks' => MockData::interviewTracks(),
            'job' => MockData::jobs()->first(),
            'cv' => MockData::cvReview(),
            'feedback' => MockData::postInterviewFeedback(),
        ]);
    }

    public function employers(): View
    {
        return view('marketing.employers', [
            'checks' => VerificationCheck::cases(),
            'interview' => MockData::aiInterview(),
            'roles' => MockData::roles(),
            'countries' => MockData::eorCountries(),
        ]);
    }

    public function verification(): View
    {
        return view('marketing.verification', [
            'checks' => VerificationCheck::cases(),
            'record' => MockData::verificationRecord(),
        ]);
    }

    public function employerOfRecord(): View
    {
        return view('marketing.eor', [
            'countries' => MockData::eorCountries(),
            'employees' => MockData::eorEmployees(),
        ]);
    }

    public function pricing(): View
    {
        return view('marketing.pricing', [
            'plans' => MockData::plans(),
        ]);
    }
}
