<?php

namespace App\Http\Controllers\Web\Employer;

use App\Enums\ApplicationStage;
use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class PipelineController extends Controller
{
    public function __invoke(): View
    {
        return view('employer.pipeline', [
            'role' => MockData::roles()->first(),
            'roles' => MockData::roles(),
            'pipeline' => MockData::pipeline(),
            'stages' => ApplicationStage::pipeline(),
        ]);
    }
}
