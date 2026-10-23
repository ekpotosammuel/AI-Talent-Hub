<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class VerificationQueueController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.verifications', [
            'queue' => MockData::adminOverview()['queue'],
            'record' => MockData::verificationRecord(),
        ]);
    }
}
