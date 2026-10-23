<?php

namespace App\Http\Controllers\Web\Employer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class AiInterviewController extends Controller
{
    public function index(): View
    {
        return view('employer.interviews.index', [
            'interview' => MockData::aiInterview(),
            'pipeline' => MockData::pipeline(),
            'roles' => MockData::roles(),
        ]);
    }

    public function create(): View
    {
        return view('employer.interviews.create', [
            'interview' => MockData::aiInterview(),
            'roles' => MockData::roles(),
            'maxQuestions' => (int) config('talent.ai.max_interview_questions'),
            'model' => config('talent.ai.model'),
        ]);
    }

    public function show(): View
    {
        return view('employer.interviews.show', [
            'interview' => MockData::aiInterview(),
        ]);
    }
}
