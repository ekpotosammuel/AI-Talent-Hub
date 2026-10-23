<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Enums\VerificationStatus;
use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public function __invoke(): View
    {
        $checks = MockData::candidateVerification();

        return view('candidate.verification', [
            'candidate' => MockData::candidate(),
            'checks' => $checks,
            'cleared' => collect($checks)->where('status', VerificationStatus::Verified)->count(),
        ]);
    }
}
