<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MockupIndexController extends Controller
{
    /**
     * Every mockup screen in the build, grouped the way the product is split.
     */
    public function __invoke(): View
    {
        return view('mockups', [
            'groups' => [
                'Public site' => [
                    ['home', 'Landing page', 'The two-sided pitch, built around one real match.'],
                    ['candidates', 'For candidates', 'Readiness, matching and the four review products.'],
                    ['employers', 'For employers', 'Verified pipelines, AI interviews, EOR.'],
                    ['verification', 'Verification', 'The seven checks and their data sources.'],
                    ['eor', 'Employer of record', 'Country coverage, cost and onboarding time.'],
                    ['pricing', 'Pricing', 'Free for candidates, per-role for employers.'],
                ],
                'Accounts' => [
                    ['register', 'Register', 'Candidate or employer, chosen up front.'],
                    ['login', 'Log in', 'Shared sign-in for both sides.'],
                    ['onboarding', 'Onboarding', 'Four-step candidate setup wizard.'],
                ],
                'Candidate app' => [
                    ['candidate.dashboard', 'Dashboard', 'Readiness score and the next blocking task.'],
                    ['candidate.jobs.index', 'Match feed', 'Global feed roles, scored and explained.'],
                    ['candidate.jobs.show', 'Match detail', 'Why this role scored 94, and the gaps.'],
                    ['candidate.applications', 'Applications', 'Every application and its live stage.'],
                    ['candidate.review.cv', 'CV review', 'Scores, issues and the rewrite for each.'],
                    ['candidate.review.cover-letter', 'Cover letter review', 'Paragraph-by-paragraph verdicts.'],
                    ['candidate.review.linkedin', 'LinkedIn review', 'Visibility metrics and eight checks.'],
                    ['candidate.interview-prep.index', 'Interview prep', 'Four tracks and your weakest areas.'],
                    ['candidate.interview-prep.session', 'Mock interview', 'Live drill with delivery signals.'],
                    ['candidate.feedback', 'Interview feedback', 'Scorecard against the employer’s bar.'],
                    ['candidate.verification', 'My verification', 'The record you own and reuse.'],
                    ['candidate.profile', 'Profile', 'Targets, skills and work preferences.'],
                    ['candidate.notifications', 'Notifications', 'Matches, checks and panel invites.'],
                ],
                'Employer app' => [
                    ['employer.dashboard', 'Dashboard', 'Pipeline health across every open role.'],
                    ['employer.roles.index', 'Roles', 'Open roles with pipeline and verified share.'],
                    ['employer.roles.create', 'Post a role', 'Role, engagement type and feed targets.'],
                    ['employer.roles.show', 'Role detail', 'One role’s funnel and candidate list.'],
                    ['employer.pipeline', 'Pipeline board', 'Six stages, drag between them.'],
                    ['employer.candidates.show', 'Candidate profile', 'Verified record, scores, documents.'],
                    ['employer.interviews.index', 'AI interviews', 'Completion, scores and guardrails.'],
                    ['employer.interviews.create', 'Interview setup', 'Competency weights and questions.'],
                    ['employer.interviews.show', 'Scorecard', 'Dimension scores with timestamped evidence.'],
                    ['employer.verification.index', 'Verification', 'Every check across every candidate.'],
                    ['employer.verification.show', 'Verification record', 'Seven checks, sources and evidence.'],
                    ['employer.eor.index', 'Employer of record', 'People we legally employ for you.'],
                    ['employer.eor.countries', 'Country coverage', 'Cost uplift, notice and leave by country.'],
                    ['employer.eor.onboard', 'EOR onboarding', 'Contract, payroll and compliance steps.'],
                    ['employer.talent', 'Talent management', 'Reviews, risk and renewals after the hire.'],
                    ['employer.settings', 'Settings & billing', 'Seats, plan and hiring countries.'],
                    ['employer.notifications', 'Notifications', 'Stage changes and check results.'],
                ],
                'Admin console' => [
                    ['admin.dashboard', 'Overview', 'Platform figures and the verification queue.'],
                    ['admin.verifications', 'Verification queue', 'Checks waiting on an operator.'],
                    ['admin.feeds', 'Job feeds', 'Five ATS sources and their sync health.'],
                    ['admin.users', 'Users', 'Candidates, employers and operators.'],
                ],
                'Mobile apps' => [
                    ['mobile', 'Mobile screens', 'Six phone screens across both sides.'],
                ],
            ],
        ]);
    }
}
