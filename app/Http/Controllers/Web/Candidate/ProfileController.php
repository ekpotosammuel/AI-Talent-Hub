<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __invoke(): View
    {
        return view('candidate.profile', [
            'candidate' => MockData::candidate(),
        ]);
    }
}
