<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class JobFeedController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.feeds', [
            'feeds' => MockData::adminOverview()['feeds'],
            'syncMinutes' => (int) config('talent.job_feeds.sync_minutes'),
        ]);
    }
}
