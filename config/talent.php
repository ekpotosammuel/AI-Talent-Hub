<?php

use App\Enums\VerificationCheck;

return [

    /*
    |--------------------------------------------------------------------------
    | Platform Commercials
    |--------------------------------------------------------------------------
    |
    | The placement fee is charged to the employer on a direct hire. The
    | employer-of-record margin is charged monthly on top of gross salary
    | when the platform is the legal employer in the talent's country.
    |
    */

    'currency' => env('TALENT_CURRENCY', 'USD'),

    'placement_fee_percent' => (float) env('TALENT_PLACEMENT_FEE_PERCENT', 12),

    'eor_margin_percent' => (float) env('TALENT_EOR_MARGIN_PERCENT', 8),

    /*
    |--------------------------------------------------------------------------
    | Matching
    |--------------------------------------------------------------------------
    |
    | Matches scoring below the threshold are hidden from the candidate feed
    | and never surfaced to an employer pipeline.
    |
    */

    'match_threshold' => (int) env('TALENT_MATCH_THRESHOLD', 70),

    /*
    |--------------------------------------------------------------------------
    | AI Review, Matching and Interviewing
    |--------------------------------------------------------------------------
    */

    'ai' => [
        'provider' => env('AI_REVIEW_PROVIDER', 'anthropic'),
        'model' => env('ANTHROPIC_MODEL', 'claude-opus-5'),
        'max_interview_questions' => (int) env('AI_INTERVIEW_MAX_QUESTIONS', 12),
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Job Feeds
    |--------------------------------------------------------------------------
    |
    | Applicant tracking systems the platform ingests roles from, newest
    | first, on the sync interval below.
    |
    */

    'job_feeds' => [
        'providers' => array_filter(explode(',', (string) env('JOB_FEED_PROVIDERS', 'greenhouse,lever,workable,ashby,linkedin'))),
        'sync_minutes' => (int) env('JOB_FEED_SYNC_MINUTES', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | Verification Data Sources
    |--------------------------------------------------------------------------
    |
    | The upstream data source consulted for each verification check.
    |
    */

    'verification_providers' => [
        VerificationCheck::Identity->value => env('VERIFICATION_IDENTITY_PROVIDER', 'persona'),
        VerificationCheck::RightToWork->value => env('VERIFICATION_RIGHT_TO_WORK_PROVIDER', 'checkr'),
        VerificationCheck::Education->value => env('VERIFICATION_EDUCATION_PROVIDER', 'clearinghouse'),
        VerificationCheck::Employment->value => env('VERIFICATION_EMPLOYMENT_PROVIDER', 'truework'),
        VerificationCheck::Sanctions->value => env('VERIFICATION_SANCTIONS_PROVIDER', 'comply-advantage'),
    ],

];
