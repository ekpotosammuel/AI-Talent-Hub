<?php

namespace App\Http\Controllers\Web\Employer;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __invoke(): View
    {
        return view('notifications', [
            'side' => 'employer',
            'notifications' => MockData::notifications(),
        ]);
    }
}
