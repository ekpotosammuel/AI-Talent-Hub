<?php

namespace App\Http\Controllers\Web\Employer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $roles = MockData::roles();

        return view('employer.dashboard', [
            'employer' => MockData::employer(),
            'roles' => $roles,
            'pipelineTotal' => $roles->sum('pipeline'),
            'interviewTotal' => $roles->sum('in_interview'),
            'offerTotal' => $roles->sum('offers'),
            'interview' => MockData::aiInterview(),
            'verification' => MockData::verificationRecord(),
            'employees' => MockData::eorEmployees(),
            'roster' => MockData::talentRoster(),
        ]);
    }
}
