<?php

use App\Http\Controllers\Web\Admin;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\OnboardingController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Candidate;
use App\Http\Controllers\Web\Employer;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\MarketingController;
use App\Http\Controllers\Web\MobileController;
use App\Http\Controllers\Web\MockupIndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Interface mockups
|--------------------------------------------------------------------------
|
| Every route here renders a mockup screen from App\Support\MockData. There is
| no authentication, persistence or third-party integration behind them, so the
| candidate, employer and admin shells are all reachable without signing in.
|
*/

// Public marketing
Route::get('/', HomeController::class)->name('home');
Route::get('for-candidates', [MarketingController::class, 'candidates'])->name('candidates');
Route::get('for-employers', [MarketingController::class, 'employers'])->name('employers');
Route::get('verification', [MarketingController::class, 'verification'])->name('verification');
Route::get('employer-of-record', [MarketingController::class, 'employerOfRecord'])->name('eor');
Route::get('pricing', [MarketingController::class, 'pricing'])->name('pricing');

// Mockup index and mobile gallery
Route::get('screens', MockupIndexController::class)->name('mockups');
Route::get('mobile', MobileController::class)->name('mobile');

// Account creation
Route::get('login', [LoginController::class, 'create'])->name('login');
Route::get('register', [RegisterController::class, 'create'])->name('register');
Route::get('onboarding', [OnboardingController::class, 'create'])->name('onboarding');

// Candidate side
Route::prefix('candidate')->name('candidate.')->group(function () {
    Route::get('dashboard', Candidate\DashboardController::class)->name('dashboard');
    Route::get('matches', [Candidate\JobController::class, 'index'])->name('jobs.index');
    Route::get('matches/{job?}', [Candidate\JobController::class, 'show'])->name('jobs.show');
    Route::get('applications', Candidate\ApplicationController::class)->name('applications');

    Route::get('review/cv', [Candidate\DocumentReviewController::class, 'cv'])->name('review.cv');
    Route::get('review/cover-letter', [Candidate\DocumentReviewController::class, 'coverLetter'])->name('review.cover-letter');
    Route::get('review/linkedin', [Candidate\DocumentReviewController::class, 'linkedin'])->name('review.linkedin');

    Route::get('interview-prep', [Candidate\InterviewPrepController::class, 'index'])->name('interview-prep.index');
    Route::get('interview-prep/session', [Candidate\InterviewPrepController::class, 'session'])->name('interview-prep.session');
    Route::get('feedback', Candidate\FeedbackController::class)->name('feedback');

    Route::get('verification', Candidate\VerificationController::class)->name('verification');
    Route::get('profile', Candidate\ProfileController::class)->name('profile');
    Route::get('notifications', Candidate\NotificationController::class)->name('notifications');
});

// Employer side
Route::prefix('employer')->name('employer.')->group(function () {
    Route::get('dashboard', Employer\DashboardController::class)->name('dashboard');

    Route::get('roles', [Employer\RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/new', [Employer\RoleController::class, 'create'])->name('roles.create');
    Route::get('roles/{role?}', [Employer\RoleController::class, 'show'])->name('roles.show');

    Route::get('pipeline', Employer\PipelineController::class)->name('pipeline');
    Route::get('candidates/{candidate?}', Employer\CandidateController::class)->name('candidates.show');

    Route::get('interviews', [Employer\AiInterviewController::class, 'index'])->name('interviews.index');
    Route::get('interviews/setup', [Employer\AiInterviewController::class, 'create'])->name('interviews.create');
    Route::get('interviews/scorecard', [Employer\AiInterviewController::class, 'show'])->name('interviews.show');

    Route::get('verification', [Employer\VerificationController::class, 'index'])->name('verification.index');
    Route::get('verification/{reference?}', [Employer\VerificationController::class, 'show'])->name('verification.show');

    Route::get('employer-of-record', [Employer\EorController::class, 'index'])->name('eor.index');
    Route::get('employer-of-record/countries', [Employer\EorController::class, 'countries'])->name('eor.countries');
    Route::get('employer-of-record/onboard', [Employer\EorController::class, 'onboard'])->name('eor.onboard');

    Route::get('talent', Employer\TalentController::class)->name('talent');
    Route::get('settings', Employer\SettingsController::class)->name('settings');
    Route::get('notifications', Employer\NotificationController::class)->name('notifications');
});

// Admin console
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');
    Route::get('verifications', Admin\VerificationQueueController::class)->name('verifications');
    Route::get('feeds', Admin\JobFeedController::class)->name('feeds');
    Route::get('users', Admin\UserController::class)->name('users');
});
