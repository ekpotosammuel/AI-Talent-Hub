<?php

namespace App\Http\Controllers\Web\Employer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class TalentController extends Controller
{
    public function __invoke(): View
    {
        $roster = MockData::talentRoster();

        return view('employer.talent', [
            'roster' => $roster,
            'atRisk' => $roster->where('risk', 'high')->count(),
        ]);
    }
}
