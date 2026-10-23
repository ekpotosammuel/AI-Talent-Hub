<?php

namespace App\Http\Controllers\Web\Employer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __invoke(): View
    {
        return view('employer.settings', [
            'employer' => MockData::employer(),
            'plans' => MockData::plans(),
            'roles' => MockData::roles(),
        ]);
    }
}
