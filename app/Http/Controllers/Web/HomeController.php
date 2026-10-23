<?php

namespace App\Http\Controllers\Web;

use App\Enums\AccountType;
use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'sides' => AccountType::cases(),
            'featuredJob' => MockData::jobs()->first(),
            'verification' => MockData::verificationRecord(),
            'countries' => MockData::eorCountries(),
            'feeds' => config('talent.job_feeds.providers'),
            'plans' => MockData::plans(),
        ]);
    }
}
