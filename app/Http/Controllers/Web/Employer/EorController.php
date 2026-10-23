<?php

namespace App\Http\Controllers\Web\Employer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class EorController extends Controller
{
    public function index(): View
    {
        $employees = MockData::eorEmployees();

        return view('employer.eor.index', [
            'employees' => $employees,
            'countries' => MockData::eorCountries(),
            'margin' => (float) config('talent.eor_margin_percent'),
            'active' => $employees->where('status', 'Active')->count(),
        ]);
    }

    public function countries(): View
    {
        return view('employer.eor.countries', [
            'countries' => MockData::eorCountries(),
            'margin' => (float) config('talent.eor_margin_percent'),
        ]);
    }

    public function onboard(): View
    {
        return view('employer.eor.onboard', [
            'employee' => MockData::eorEmployees()->first(),
            'countries' => MockData::eorCountries(),
        ]);
    }
}
