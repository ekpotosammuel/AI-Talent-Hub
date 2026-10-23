<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class MobileController extends Controller
{
    public function __invoke(): View
    {
        return view('mobile', [
            'screens' => MockData::mobileScreens(),
            'job' => MockData::jobs()->first(),
            'candidate' => MockData::candidate(),
            'cv' => MockData::cvReview(),
            'interview' => MockData::mockInterview(),
            'pipeline' => MockData::pipeline(),
            'verification' => MockData::verificationRecord(),
            'tasks' => MockData::readinessTasks(),
        ]);
    }
}
