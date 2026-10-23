<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.onboarding', [
            'step' => max(1, min(4, (int) $request->query('step', 2))),
            'candidate' => MockData::candidate(),
        ]);
    }
}
