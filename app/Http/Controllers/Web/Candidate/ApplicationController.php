<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Enums\ApplicationStage;
use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function __invoke(): View
    {
        $applications = MockData::applications();

        return view('candidate.applications', [
            'applications' => $applications,
            'stages' => ApplicationStage::cases(),
            'active' => $applications->reject(fn (array $a): bool => $a['stage']->isFinal())->count(),
        ]);
    }
}
