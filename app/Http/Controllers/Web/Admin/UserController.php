<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Support\MockData;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.users', [
            'users' => MockData::adminOverview()['users'],
        ]);
    }
}
