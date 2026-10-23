<?php

namespace App\Http\Controllers\Web\Employer;

use App\Enums\VerificationCheck;
use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public function index(): View
    {
        return view('employer.verification.index', [
            'checks' => VerificationCheck::cases(),
            'record' => MockData::verificationRecord(),
            'queue' => MockData::adminOverview()['queue'],
            'pipeline' => MockData::pipeline(),
        ]);
    }

    public function show(string $reference = 'VER-2026-10-0391'): View
    {
        return view('employer.verification.show', [
            'record' => MockData::verificationRecord(),
            'reference' => $reference,
        ]);
    }
}
