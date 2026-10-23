<?php

namespace App\Http\Controllers\Web\Auth;

use App\Enums\AccountType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.register', [
            'selected' => AccountType::tryFrom((string) $request->query('account')) ?? AccountType::Candidate,
            'sides' => AccountType::cases(),
        ]);
    }
}
