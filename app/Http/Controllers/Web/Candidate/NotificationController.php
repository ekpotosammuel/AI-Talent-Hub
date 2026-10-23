<?php

namespace App\Http\Controllers\Web\Candidate;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __invoke(): View
    {
        return view('notifications', [
            'side' => 'candidate',
            'notifications' => MockData::notifications(),
        ]);
    }
}
