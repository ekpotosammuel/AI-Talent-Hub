<?php

namespace App\Http\Controllers\Web\Employer;

use App\Enums\ApplicationStage;
use App\Enums\EngagementType;
use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('employer.roles.index', [
            'roles' => MockData::roles(),
            'employer' => MockData::employer(),
        ]);
    }

    public function create(): View
    {
        return view('employer.roles.create', [
            'engagements' => EngagementType::cases(),
            'feeds' => config('talent.job_feeds.providers'),
            'employer' => MockData::employer(),
        ]);
    }

    public function show(string $role = 'ROLE-221'): View
    {
        $roles = MockData::roles();

        return view('employer.roles.show', [
            'role' => $roles->firstWhere('id', $role) ?? $roles->first(),
            'pipeline' => MockData::pipeline(),
            'stages' => ApplicationStage::pipeline(),
            'interview' => MockData::aiInterview(),
        ]);
    }
}
