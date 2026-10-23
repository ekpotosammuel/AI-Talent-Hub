<?php

namespace App\Support;

use App\Enums\ApplicationStage;
use App\Enums\EngagementType;
use App\Enums\InterviewStatus;
use App\Enums\VerificationCheck;
use App\Enums\VerificationStatus;
use Illuminate\Support\Collection;

/**
 * Sample content for the interface mockups.
 *
 * Every screen in this build is a mockup: there is no database, no AI provider
 * and no verification integration behind it. This class is the single place
 * that sample content lives, so a screen never invents its own numbers and the
 * same candidate, role or check reads identically wherever it appears.
 */
class MockData
{
    /**
     * The signed-in candidate the candidate-side mockups are drawn for.
     *
     * @return array<string, mixed>
     */
    public static function candidate(): array
    {
        return [
            'name' => 'Amara Okonkwo',
            'initials' => 'AO',
            'headline' => 'Senior Backend Engineer · Payments',
            'email' => 'amara.okonkwo@example.com',
            'location' => 'Lagos, Nigeria',
            'timezone' => 'WAT (UTC+1)',
            'open_to' => ['Remote (EMEA overlap)', 'Hybrid — Lagos', 'Relocation — UK, NL'],
            'years_experience' => 7,
            'target_role' => 'Senior Backend Engineer',
            'target_salary' => '$95,000 – $120,000',
            'readiness' => 78,
            'readiness_band' => 'Nearly ready',
            'profile_strength' => 84,
            'skills' => ['Go', 'PostgreSQL', 'Kubernetes', 'gRPC', 'Terraform', 'Kafka', 'Payments', 'PCI-DSS'],
            'verification' => VerificationStatus::InProgress,
        ];
    }

    /**
     * The signed-in employer the employer-side mockups are drawn for.
     *
     * @return array<string, mixed>
     */
    public static function employer(): array
    {
        return [
            'name' => 'Dayo Adeleke',
            'initials' => 'DA',
            'title' => 'Head of Talent',
            'company' => 'Northwind Pay',
            'company_initials' => 'NP',
            'industry' => 'Fintech · Series B',
            'headquarters' => 'London, United Kingdom',
            'headcount' => 184,
            'hiring_countries' => ['United Kingdom', 'Nigeria', 'Kenya', 'Portugal', 'Germany'],
            'seats_used' => 7,
            'seats_total' => 10,
        ];
    }

    /**
     * Candidate readiness tasks, newest blocker first.
     *
     * @return list<array{title: string, detail: string, status: string, route: ?string, cta: ?string}>
     */
    public static function readinessTasks(): array
    {
        return [
            [
                'title' => 'Finish right-to-work verification',
                'detail' => 'Upload your passport page so employers see a cleared check.',
                'status' => 'blocked',
                'route' => 'candidate.verification',
                'cta' => 'Upload document',
            ],
            [
                'title' => 'Rewrite your CV summary',
                'detail' => 'Three of five reviewers would skip it. The fix is two sentences.',
                'status' => 'todo',
                'route' => 'candidate.review.cv',
                'cta' => 'Open CV review',
            ],
            [
                'title' => 'Practise system design out loud',
                'detail' => 'Your last mock interview lost points on trade-off narration.',
                'status' => 'todo',
                'route' => 'candidate.interview-prep.index',
                'cta' => 'Start a drill',
            ],
            [
                'title' => 'LinkedIn headline rewritten',
                'detail' => 'Search impressions up 4.2× in the week after the change.',
                'status' => 'done',
                'route' => 'candidate.review.linkedin',
                'cta' => null,
            ],
            [
                'title' => 'Government ID verified',
                'detail' => 'Cleared in 4 minutes via Persona.',
                'status' => 'done',
                'route' => null,
                'cta' => null,
            ],
        ];
    }

    /**
     * Roles ingested from the global job feeds, best match first.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public static function jobs(): Collection
    {
        return collect([
            [
                'id' => 'JOB-4821',
                'title' => 'Senior Backend Engineer, Payments',
                'company' => 'Northwind Pay',
                'company_initials' => 'NP',
                'location' => 'Remote — EMEA',
                'arrangement' => 'Remote',
                'salary' => '$110,000 – $135,000',
                'engagement' => EngagementType::EmployerOfRecord,
                'source' => 'greenhouse',
                'posted' => '2 hours ago',
                'match' => 94,
                'applicants' => 28,
                'verified_employer' => true,
                'eor_available' => true,
                'skills' => ['Go', 'PostgreSQL', 'Kafka', 'PCI-DSS'],
                'why' => [
                    ['label' => 'Payments domain', 'weight' => 'Strong', 'note' => '7 years, two card schemes shipped'],
                    ['label' => 'Go + Postgres', 'weight' => 'Strong', 'note' => 'Named in 9 of your 11 shipped projects'],
                    ['label' => 'Kafka at scale', 'weight' => 'Partial', 'note' => 'Consumer side only; role wants stream design'],
                    ['label' => 'EMEA overlap', 'weight' => 'Strong', 'note' => 'WAT gives 6 hours with London'],
                ],
                'gaps' => ['No Kubernetes operator experience listed', 'Role prefers prior on-call lead rotation'],
            ],
            [
                'id' => 'JOB-4790',
                'title' => 'Staff Engineer — Platform',
                'company' => 'Lumen Health',
                'company_initials' => 'LH',
                'location' => 'Berlin, Germany · Hybrid',
                'arrangement' => 'Hybrid',
                'salary' => '€105,000 – €125,000',
                'engagement' => EngagementType::DirectHire,
                'source' => 'lever',
                'posted' => '6 hours ago',
                'match' => 88,
                'applicants' => 64,
                'verified_employer' => true,
                'eor_available' => false,
                'skills' => ['Go', 'Kubernetes', 'Terraform', 'gRPC'],
                'why' => [
                    ['label' => 'Platform depth', 'weight' => 'Strong', 'note' => 'Ran the internal service template at Paystack'],
                    ['label' => 'Terraform', 'weight' => 'Strong', 'note' => 'Listed on your CV and verified by a reference'],
                    ['label' => 'Healthcare domain', 'weight' => 'Missing', 'note' => 'No regulated-health experience'],
                    ['label' => 'Relocation', 'weight' => 'Partial', 'note' => 'You are open to NL and UK, not DE'],
                ],
                'gaps' => ['Visa sponsorship needed for Germany', 'No HL7/FHIR exposure'],
            ],
            [
                'id' => 'JOB-4766',
                'title' => 'Backend Engineer (Go)',
                'company' => 'Kestrel Logistics',
                'company_initials' => 'KL',
                'location' => 'Remote — Global',
                'arrangement' => 'Remote',
                'salary' => '$90,000 – $110,000',
                'engagement' => EngagementType::EmployerOfRecord,
                'source' => 'ashby',
                'posted' => '1 day ago',
                'match' => 85,
                'applicants' => 112,
                'verified_employer' => true,
                'eor_available' => true,
                'skills' => ['Go', 'gRPC', 'PostgreSQL'],
                'why' => [
                    ['label' => 'Go service design', 'weight' => 'Strong', 'note' => 'Matches the role’s core requirement'],
                    ['label' => 'Seniority', 'weight' => 'Partial', 'note' => 'Role is scoped one level below your target'],
                ],
                'gaps' => ['Compensation band sits under your stated floor'],
            ],
            [
                'id' => 'JOB-4751',
                'title' => 'Engineering Lead — Core Banking',
                'company' => 'Adunni Bank',
                'company_initials' => 'AB',
                'location' => 'Lagos, Nigeria · On-site',
                'arrangement' => 'On-site',
                'salary' => '₦32,000,000 – ₦40,000,000',
                'engagement' => EngagementType::DirectHire,
                'source' => 'workable',
                'posted' => '2 days ago',
                'match' => 81,
                'applicants' => 19,
                'verified_employer' => false,
                'eor_available' => false,
                'skills' => ['Java', 'PostgreSQL', 'Payments', 'Team leadership'],
                'why' => [
                    ['label' => 'Payments domain', 'weight' => 'Strong', 'note' => 'Direct overlap with core banking rails'],
                    ['label' => 'People leadership', 'weight' => 'Partial', 'note' => 'Tech lead, not line manager'],
                    ['label' => 'Primary language', 'weight' => 'Missing', 'note' => 'Role is Java; you are Go-first'],
                ],
                'gaps' => ['Employer has not completed company verification'],
            ],
            [
                'id' => 'JOB-4733',
                'title' => 'Senior Platform Engineer',
                'company' => 'Verity Insure',
                'company_initials' => 'VI',
                'location' => 'Amsterdam, Netherlands · Hybrid',
                'arrangement' => 'Hybrid',
                'salary' => '€95,000 – €115,000',
                'engagement' => EngagementType::Contract,
                'source' => 'linkedin',
                'posted' => '3 days ago',
                'match' => 76,
                'applicants' => 87,
                'verified_employer' => true,
                'eor_available' => true,
                'skills' => ['Kubernetes', 'Go', 'Observability'],
                'why' => [
                    ['label' => 'Relocation fit', 'weight' => 'Strong', 'note' => 'NL is on your open-to list'],
                    ['label' => 'Kubernetes', 'weight' => 'Partial', 'note' => 'Operator work is the role’s first quarter'],
                ],
                'gaps' => ['12-month contract, not permanent', 'Dutch 30% ruling eligibility unconfirmed'],
            ],
        ]);
    }

    /**
     * The candidate's own applications, most recently active first.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public static function applications(): Collection
    {
        return collect([
            [
                'id' => 'APP-9001',
                'role' => 'Senior Backend Engineer, Payments',
                'company' => 'Northwind Pay',
                'company_initials' => 'NP',
                'stage' => ApplicationStage::TeamInterview,
                'match' => 94,
                'applied' => '11 days ago',
                'last_activity' => 'Panel scheduled for Thu 14:00 WAT',
                'next_step' => 'System design panel · 60 min',
                'has_feedback' => true,
            ],
            [
                'id' => 'APP-8974',
                'role' => 'Staff Engineer — Platform',
                'company' => 'Lumen Health',
                'company_initials' => 'LH',
                'stage' => ApplicationStage::AiInterview,
                'match' => 88,
                'applied' => '6 days ago',
                'last_activity' => 'AI interview invite expires in 2 days',
                'next_step' => 'Complete the 25-minute AI interview',
                'has_feedback' => false,
            ],
            [
                'id' => 'APP-8940',
                'role' => 'Backend Engineer (Go)',
                'company' => 'Kestrel Logistics',
                'company_initials' => 'KL',
                'stage' => ApplicationStage::Screening,
                'match' => 85,
                'applied' => '2 weeks ago',
                'last_activity' => 'Recruiter opened your CV twice',
                'next_step' => 'Waiting on the recruiter',
                'has_feedback' => false,
            ],
            [
                'id' => 'APP-8902',
                'role' => 'Senior Platform Engineer',
                'company' => 'Verity Insure',
                'company_initials' => 'VI',
                'stage' => ApplicationStage::Offer,
                'match' => 76,
                'applied' => '3 weeks ago',
                'last_activity' => 'Offer sent — expires Friday',
                'next_step' => 'Review the offer and EOR contract',
                'has_feedback' => true,
            ],
            [
                'id' => 'APP-8855',
                'role' => 'Engineering Lead — Core Banking',
                'company' => 'Adunni Bank',
                'company_initials' => 'AB',
                'stage' => ApplicationStage::Rejected,
                'match' => 81,
                'applied' => '5 weeks ago',
                'last_activity' => 'Closed after the technical screen',
                'next_step' => 'Feedback report available',
                'has_feedback' => true,
            ],
        ]);
    }

    /**
     * AI review of the candidate's CV.
     *
     * @return array<string, mixed>
     */
    public static function cvReview(): array
    {
        return [
            'file' => 'amara-okonkwo-cv.pdf',
            'pages' => 2,
            'uploaded' => 'Reviewed 3 hours ago against JOB-4821',
            'overall' => 72,
            'previous' => 58,
            'ats_parse' => 91,
            'recruiter_scan' => 64,
            'role_fit' => 88,
            'verdict' => 'Strong evidence, buried. The work is there — a recruiter will not find it in six seconds.',
            'sections' => [
                ['name' => 'Professional summary', 'score' => 41, 'note' => 'Generic. Names no domain, no scale, no outcome.'],
                ['name' => 'Experience', 'score' => 83, 'note' => 'Good verbs, but only 4 of 14 bullets carry a number.'],
                ['name' => 'Skills', 'score' => 78, 'note' => 'Flat list of 24 items. Reads as keyword stuffing.'],
                ['name' => 'Education', 'score' => 95, 'note' => 'Clear and correctly ordered.'],
                ['name' => 'Formatting', 'score' => 88, 'note' => 'Parses cleanly. Two-column header risks older parsers.'],
            ],
            'issues' => [
                [
                    'severity' => 'high',
                    'title' => 'Your summary could belong to anyone',
                    'where' => 'Page 1 · Summary',
                    'quote' => 'Experienced software engineer with a passion for building scalable solutions and a track record of delivering results.',
                    'fix' => 'Backend engineer, 7 years in card payments. Took Paystack’s settlement service from 40k to 1.2M transactions a day and cut reconciliation breaks by 82%.',
                    'why' => 'Recruiters read the summary first and nothing else if it says nothing. Yours is the weakest line on a strong CV.',
                ],
                [
                    'severity' => 'high',
                    'title' => 'Ten of fourteen bullets have no measurable outcome',
                    'where' => 'Page 1 · Experience — Paystack',
                    'quote' => 'Worked on improving the performance of the payments API.',
                    'fix' => 'Cut p99 latency on the payments API from 840ms to 190ms by moving idempotency keys to Redis, holding 99.98% availability through Black Friday.',
                    'why' => 'The role scores on measurable impact. Numbers you already have are missing from the page.',
                ],
                [
                    'severity' => 'medium',
                    'title' => 'Four role keywords are absent',
                    'where' => 'Whole document',
                    'quote' => 'Missing: PCI-DSS, idempotency, double-entry ledger, chargeback',
                    'fix' => 'Each one describes work you have actually done. Put them in the bullet that proves them, not in the skills list.',
                    'why' => 'The employer’s ATS filters on these four terms before a human sees the file.',
                ],
                [
                    'severity' => 'medium',
                    'title' => 'Skills list is 24 items long',
                    'where' => 'Page 2 · Skills',
                    'quote' => 'Go, Python, Java, JavaScript, PostgreSQL, MySQL, MongoDB, Redis, Kafka, RabbitMQ, Docker, Kubernetes…',
                    'fix' => 'Cut to the 10 you would defend in an interview, grouped under Languages, Data and Infrastructure.',
                    'why' => 'A long flat list signals padding and dilutes the terms that matter.',
                ],
                [
                    'severity' => 'low',
                    'title' => 'Two-column header may break older parsers',
                    'where' => 'Page 1 · Header',
                    'quote' => 'Contact block set beside the name in a table',
                    'fix' => 'Put name, then one line of contact details, left aligned.',
                    'why' => 'Workday and Taleo occasionally drop the second column entirely.',
                ],
            ],
            'keywords' => [
                ['term' => 'Go', 'present' => true, 'count' => 6],
                ['term' => 'PostgreSQL', 'present' => true, 'count' => 4],
                ['term' => 'Kafka', 'present' => true, 'count' => 2],
                ['term' => 'PCI-DSS', 'present' => false, 'count' => 0],
                ['term' => 'idempotency', 'present' => false, 'count' => 0],
                ['term' => 'double-entry ledger', 'present' => false, 'count' => 0],
                ['term' => 'chargeback', 'present' => false, 'count' => 0],
                ['term' => 'on-call', 'present' => true, 'count' => 1],
            ],
        ];
    }

    /**
     * AI review of the candidate's cover letter.
     *
     * @return array<string, mixed>
     */
    public static function coverLetterReview(): array
    {
        return [
            'file' => 'northwind-pay-cover-letter.docx',
            'target' => 'Northwind Pay · Senior Backend Engineer, Payments',
            'uploaded' => 'Reviewed 20 minutes ago',
            'overall' => 64,
            'previous' => 64,
            'word_count' => 412,
            'read_time' => '1 min 40 sec',
            'verdict' => 'Competent and forgettable. It never says why Northwind specifically, and the ask at the end is missing.',
            'dimensions' => [
                ['name' => 'Specific to this employer', 'score' => 38],
                ['name' => 'Evidence of impact', 'score' => 71],
                ['name' => 'Structure and length', 'score' => 86],
                ['name' => 'Tone and readability', 'score' => 79],
                ['name' => 'Clear closing ask', 'score' => 30],
            ],
            'paragraphs' => [
                [
                    'label' => 'Opening',
                    'verdict' => 'rewrite',
                    'text' => 'I am writing to express my strong interest in the Senior Backend Engineer position at your company. With my extensive background in software engineering, I believe I would be a great fit for your team.',
                    'comment' => 'Says nothing a thousand other letters do not. Open on the one thing that makes you the obvious reader of this job ad.',
                    'suggestion' => 'Northwind settles into 14 African markets and your careers page says the ledger is the hard part. I spent four years on exactly that problem at Paystack, including the migration that took settlement from T+2 to same-day.',
                ],
                [
                    'label' => 'Evidence',
                    'verdict' => 'keep',
                    'text' => 'At Paystack I led the redesign of the settlement service, moving it from a nightly batch to an event-driven pipeline. The change reduced reconciliation breaks by 82% and let finance close the books in hours rather than days.',
                    'comment' => 'This is the strongest paragraph in the letter. Leave it alone.',
                    'suggestion' => null,
                ],
                [
                    'label' => 'Motivation',
                    'verdict' => 'tighten',
                    'text' => 'I am passionate about fintech and I am excited by the opportunity to work on products that have a real impact on people across the continent. Your mission resonates deeply with me.',
                    'comment' => 'Three sentences of enthusiasm with no content. One concrete sentence about their product does more.',
                    'suggestion' => 'Your payout API is the one I reach for when testing a new market, and the idempotency semantics are the reason. I would like to work on that.',
                ],
                [
                    'label' => 'Closing',
                    'verdict' => 'rewrite',
                    'text' => 'Thank you for considering my application. I look forward to hearing from you.',
                    'comment' => 'No ask, no availability, no next step. Close by making the easy reply obvious.',
                    'suggestion' => 'I can walk through the settlement migration in 30 minutes, and I am free most afternoons WAT this fortnight. My right-to-work check for the UK is already cleared on AI Talent Hub.',
                ],
            ],
        ];
    }

    /**
     * AI review of the candidate's LinkedIn profile.
     *
     * @return array<string, mixed>
     */
    public static function linkedinReview(): array
    {
        return [
            'url' => 'linkedin.com/in/amara-okonkwo',
            'uploaded' => 'Re-scanned yesterday',
            'overall' => 81,
            'previous' => 52,
            'verdict' => 'The headline rewrite worked. Recruiter search impressions are up 4.2×. The experience section is now the weak point.',
            'metrics' => [
                ['label' => 'Search appearances', 'value' => '1,284', 'change' => '+4.2×', 'direction' => 'up', 'hint' => 'last 7 days vs. the week before'],
                ['label' => 'Recruiter views', 'value' => '46', 'change' => '+28', 'direction' => 'up', 'hint' => 'InMail-capable accounts'],
                ['label' => 'Profile completeness', 'value' => '92%', 'change' => '+14', 'direction' => 'up', 'hint' => 'LinkedIn’s own measure'],
                ['label' => 'Keyword coverage', 'value' => '7 of 10', 'change' => '+3', 'direction' => 'up', 'hint' => 'terms from your target roles'],
            ],
            'checks' => [
                ['area' => 'Headline', 'status' => 'pass', 'note' => '"Backend engineer · Card payments & ledgers · Go, Postgres" — searchable and specific.'],
                ['area' => 'Profile photo', 'status' => 'pass', 'note' => 'Clear, recent, face fills the frame.'],
                ['area' => 'About section', 'status' => 'pass', 'note' => 'Opens with the settlement number. Good.'],
                ['area' => 'Experience bullets', 'status' => 'warn', 'note' => 'Four roles have a title and dates but no description at all.'],
                ['area' => 'Skills order', 'status' => 'warn', 'note' => 'Top three are Microsoft Office, Teamwork, Communication. Reorder to Go, PostgreSQL, Kafka.'],
                ['area' => 'Featured section', 'status' => 'fail', 'note' => 'Empty. Pin the ledger talk and the open-source idempotency library.'],
                ['area' => 'Recommendations', 'status' => 'fail', 'note' => 'None. Two former managers already gave you platform references here.'],
                ['area' => 'Open to work', 'status' => 'pass', 'note' => 'Set to recruiters only — right call while employed.'],
            ],
        ];
    }

    /**
     * Interview preparation tracks available to the candidate.
     *
     * @return list<array<string, mixed>>
     */
    public static function interviewTracks(): array
    {
        return [
            [
                'slug' => 'system-design',
                'name' => 'System design',
                'detail' => 'Scope, trade-offs, failure modes, and narrating your reasoning out loud.',
                'questions' => 24,
                'drills_done' => 6,
                'last_score' => 68,
                'weakest' => 'Trade-off narration',
                'accent' => 'brand',
            ],
            [
                'slug' => 'coding',
                'name' => 'Live coding',
                'detail' => 'Working under observation, talking while typing, handling the stuck moment.',
                'questions' => 40,
                'drills_done' => 11,
                'last_score' => 84,
                'weakest' => 'Edge-case enumeration',
                'accent' => 'signal',
            ],
            [
                'slug' => 'behavioural',
                'name' => 'Behavioural',
                'detail' => 'STAR answers with real numbers, conflict stories, and failure without deflection.',
                'questions' => 32,
                'drills_done' => 3,
                'last_score' => 59,
                'weakest' => 'Conflict with a manager',
                'accent' => 'warn',
            ],
            [
                'slug' => 'domain',
                'name' => 'Payments domain',
                'detail' => 'Ledgers, idempotency, settlement windows, chargeback flows, PCI scope.',
                'questions' => 18,
                'drills_done' => 9,
                'last_score' => 91,
                'weakest' => 'Scheme interchange rules',
                'accent' => 'pass',
            ],
        ];
    }

    /**
     * A mock interview in progress, used for the practice-session screen.
     *
     * @return array<string, mixed>
     */
    public static function mockInterview(): array
    {
        return [
            'track' => 'System design',
            'role_context' => 'Pitched at Senior Backend Engineer, Payments — JOB-4821',
            'question_number' => 4,
            'question_total' => 6,
            'elapsed' => '18:42',
            'limit' => '45:00',
            'question' => 'Northwind settles into 14 countries with different cut-off times. Design the settlement service. Where does money get stuck, and how would you know?',
            'follow_ups' => [
                'What happens when a scheme file arrives four hours late?',
                'How do you keep the ledger balanced across a partial failure?',
                'Which metric tells you money is stuck before finance does?',
            ],
            'transcript' => [
                ['speaker' => 'interviewer', 'text' => 'Take a minute to scope it. What are you optimising for?'],
                ['speaker' => 'candidate', 'text' => 'Correctness first — the ledger has to balance even if settlement is late. Timeliness second. So I would separate the money movement from the reporting path and make the ledger the source of truth.'],
                ['speaker' => 'interviewer', 'text' => 'Good. Draw the write path.'],
                ['speaker' => 'candidate', 'text' => 'Every scheme file lands in object storage, a parser emits one event per transaction with an idempotency key built from scheme reference plus settlement date…'],
            ],
            'live_signals' => [
                ['label' => 'Structure', 'score' => 82, 'note' => 'Scoped before designing. Good.'],
                ['label' => 'Trade-off narration', 'score' => 54, 'note' => 'You chose, but did not say what you gave up.'],
                ['label' => 'Pace', 'score' => 76, 'note' => '142 words a minute — slightly fast.'],
                ['label' => 'Filler words', 'score' => 61, 'note' => '14 instances of "sort of" in 18 minutes.'],
            ],
        ];
    }

    /**
     * Post-interview feedback report shared with the candidate.
     *
     * @return array<string, mixed>
     */
    public static function postInterviewFeedback(): array
    {
        return [
            'role' => 'Engineering Lead — Core Banking',
            'company' => 'Adunni Bank',
            'company_initials' => 'AB',
            'interview' => 'Technical screen · 60 min · 5 weeks ago',
            'outcome' => 'Not moving forward',
            'outcome_tone' => 'stop',
            'overall' => 62,
            'bar' => 75,
            'summary' => 'The panel rated your payments knowledge above their bar and your people-leadership evidence below it. Two of three interviewers wrote the same sentence: strong engineer, unproven as a line manager.',
            'dimensions' => [
                ['name' => 'Payments domain knowledge', 'score' => 92, 'bar' => 70, 'verdict' => 'above'],
                ['name' => 'System design', 'score' => 78, 'bar' => 75, 'verdict' => 'above'],
                ['name' => 'Code quality', 'score' => 74, 'bar' => 70, 'verdict' => 'above'],
                ['name' => 'People leadership', 'score' => 41, 'bar' => 75, 'verdict' => 'below'],
                ['name' => 'Stakeholder communication', 'score' => 58, 'bar' => 70, 'verdict' => 'below'],
            ],
            'quotes' => [
                ['source' => 'Interviewer 1 · Engineering Manager', 'text' => 'Best explanation of interchange I have heard in this loop. Would hire onto my team as an IC today.'],
                ['source' => 'Interviewer 2 · Director', 'text' => 'Could not give a concrete example of managing an underperformer. Answered with process, not with a person.'],
                ['source' => 'Interviewer 3 · Staff Engineer', 'text' => 'Design was solid. Spent 40 minutes on the happy path and ran out of time on failure modes.'],
            ],
            'actions' => [
                ['title' => 'Build two real management stories', 'detail' => 'You have mentored four engineers. Write both as STAR with names, timelines and outcomes, then drill them.', 'route' => 'candidate.interview-prep.index'],
                ['title' => 'Budget failure modes into system design', 'detail' => 'Two of your three design interviews ran out of time before failure handling. Set a 20-minute mark.', 'route' => 'candidate.interview-prep.index'],
                ['title' => 'Target senior IC roles for now', 'detail' => '9 of your 11 current matches are IC roles where your scores sit well above bar.', 'route' => 'candidate.jobs.index'],
            ],
        ];
    }

    /**
     * Verification checks on the candidate's record.
     *
     * @return list<array{check: VerificationCheck, status: VerificationStatus, detail: string, completed: ?string}>
     */
    public static function candidateVerification(): array
    {
        return [
            ['check' => VerificationCheck::Identity, 'status' => VerificationStatus::Verified, 'detail' => 'Nigerian passport · liveness matched', 'completed' => '12 Oct 2026'],
            ['check' => VerificationCheck::Education, 'status' => VerificationStatus::Verified, 'detail' => 'BSc Computer Science, University of Lagos, 2019', 'completed' => '12 Oct 2026'],
            ['check' => VerificationCheck::Employment, 'status' => VerificationStatus::Verified, 'detail' => '3 of 3 employers confirmed titles and dates', 'completed' => '14 Oct 2026'],
            ['check' => VerificationCheck::Reference, 'status' => VerificationStatus::Verified, 'detail' => '2 structured reference calls completed', 'completed' => '15 Oct 2026'],
            ['check' => VerificationCheck::Sanctions, 'status' => VerificationStatus::Verified, 'detail' => 'No watchlist, PEP or adverse media hits', 'completed' => '12 Oct 2026'],
            ['check' => VerificationCheck::Certification, 'status' => VerificationStatus::InProgress, 'detail' => 'CKA credential ID sent to the Linux Foundation', 'completed' => null],
            ['check' => VerificationCheck::RightToWork, 'status' => VerificationStatus::Pending, 'detail' => 'Awaiting your passport page for UK right to work', 'completed' => null],
        ];
    }

    /**
     * Open roles on the employer's account.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public static function roles(): Collection
    {
        return collect([
            [
                'id' => 'ROLE-221',
                'title' => 'Senior Backend Engineer, Payments',
                'location' => 'Remote — EMEA',
                'engagement' => EngagementType::EmployerOfRecord,
                'salary' => '$110,000 – $135,000',
                'status' => 'Live',
                'opened' => '18 days ago',
                'hiring_manager' => 'Priya Raman',
                'pipeline' => 42,
                'matched' => 16,
                'in_interview' => 7,
                'offers' => 1,
                'verified_share' => 86,
                'days_to_offer' => 19,
                'feeds' => ['greenhouse', 'linkedin', 'ashby'],
            ],
            [
                'id' => 'ROLE-218',
                'title' => 'Compliance Analyst',
                'location' => 'London, UK · Hybrid',
                'engagement' => EngagementType::DirectHire,
                'salary' => '£58,000 – £68,000',
                'status' => 'Live',
                'opened' => '9 days ago',
                'hiring_manager' => 'Tom Byrne',
                'pipeline' => 27,
                'matched' => 9,
                'in_interview' => 4,
                'offers' => 0,
                'verified_share' => 74,
                'days_to_offer' => 24,
                'feeds' => ['greenhouse', 'workable'],
            ],
            [
                'id' => 'ROLE-214',
                'title' => 'Data Engineer',
                'location' => 'Nairobi, Kenya · Remote',
                'engagement' => EngagementType::EmployerOfRecord,
                'salary' => '$72,000 – $88,000',
                'status' => 'Live',
                'opened' => '31 days ago',
                'hiring_manager' => 'Priya Raman',
                'pipeline' => 55,
                'matched' => 21,
                'in_interview' => 3,
                'offers' => 2,
                'verified_share' => 91,
                'days_to_offer' => 17,
                'feeds' => ['lever', 'linkedin'],
            ],
            [
                'id' => 'ROLE-203',
                'title' => 'Product Designer',
                'location' => 'Lisbon, Portugal · Hybrid',
                'engagement' => EngagementType::Contract,
                'salary' => '€62,000 – €74,000',
                'status' => 'Paused',
                'opened' => '47 days ago',
                'hiring_manager' => 'Ana Costa',
                'pipeline' => 38,
                'matched' => 12,
                'in_interview' => 0,
                'offers' => 0,
                'verified_share' => 63,
                'days_to_offer' => 0,
                'feeds' => ['ashby'],
            ],
        ]);
    }

    /**
     * Candidates in the pipeline for ROLE-221, keyed by stage.
     *
     * @return array<string, list<array<string, mixed>>>
     */
    public static function pipeline(): array
    {
        $people = [
            ApplicationStage::Applied->value => [
                ['name' => 'Chidi Nwosu', 'initials' => 'CN', 'location' => 'Abuja, NG', 'match' => 91, 'verified' => 7, 'checks' => 7, 'ai_score' => null, 'note' => 'Applied 2 hours ago via Greenhouse'],
                ['name' => 'Sofia Almeida', 'initials' => 'SA', 'location' => 'Porto, PT', 'match' => 87, 'verified' => 5, 'checks' => 7, 'ai_score' => null, 'note' => 'Sourced from the global feed'],
                ['name' => 'Marcus Feld', 'initials' => 'MF', 'location' => 'Berlin, DE', 'match' => 79, 'verified' => 3, 'checks' => 7, 'ai_score' => null, 'note' => 'Needs visa sponsorship'],
            ],
            ApplicationStage::Screening->value => [
                ['name' => 'Amara Okonkwo', 'initials' => 'AO', 'location' => 'Lagos, NG', 'match' => 94, 'verified' => 5, 'checks' => 7, 'ai_score' => null, 'note' => 'Recruiter screen booked Thu'],
                ['name' => 'Ling Wei', 'initials' => 'LW', 'location' => 'Singapore', 'match' => 83, 'verified' => 6, 'checks' => 7, 'ai_score' => null, 'note' => 'No EMEA overlap — flagged'],
            ],
            ApplicationStage::AiInterview->value => [
                ['name' => 'Tunde Bello', 'initials' => 'TB', 'location' => 'Lagos, NG', 'match' => 89, 'verified' => 7, 'checks' => 7, 'ai_score' => 86, 'note' => 'Completed in 23 min · scored'],
                ['name' => 'Hana Yusuf', 'initials' => 'HY', 'location' => 'Nairobi, KE', 'match' => 85, 'verified' => 7, 'checks' => 7, 'ai_score' => 71, 'note' => 'Weak on failure modes'],
                ['name' => 'Oliver Grant', 'initials' => 'OG', 'location' => 'Manchester, UK', 'match' => 80, 'verified' => 4, 'checks' => 7, 'ai_score' => null, 'note' => 'Invite expires tomorrow'],
            ],
            ApplicationStage::TeamInterview->value => [
                ['name' => 'Fatima Adeyemi', 'initials' => 'FA', 'location' => 'Lagos, NG', 'match' => 92, 'verified' => 7, 'checks' => 7, 'ai_score' => 90, 'note' => 'System design panel Fri'],
                ['name' => 'Daniel Okoye', 'initials' => 'DO', 'location' => 'Accra, GH', 'match' => 86, 'verified' => 6, 'checks' => 7, 'ai_score' => 82, 'note' => 'Awaiting scorecards from 2 of 3'],
            ],
            ApplicationStage::Offer->value => [
                ['name' => 'Zainab Idris', 'initials' => 'ZI', 'location' => 'Kano, NG', 'match' => 90, 'verified' => 7, 'checks' => 7, 'ai_score' => 88, 'note' => 'EOR contract sent · Nigeria'],
            ],
            ApplicationStage::Hired->value => [
                ['name' => 'Kwame Mensah', 'initials' => 'KM', 'location' => 'Accra, GH', 'match' => 93, 'verified' => 7, 'checks' => 7, 'ai_score' => 94, 'note' => 'Starts 3 Nov · EOR Ghana'],
            ],
        ];

        return $people;
    }

    /**
     * Employer-side verification record for one candidate.
     *
     * @return array<string, mixed>
     */
    public static function verificationRecord(): array
    {
        return [
            'candidate' => 'Amara Okonkwo',
            'initials' => 'AO',
            'role' => 'Senior Backend Engineer, Payments',
            'country' => 'Nigeria',
            'hiring_country' => 'United Kingdom',
            'requested' => '15 Oct 2026',
            'reference' => 'VER-2026-10-0391',
            'cleared' => 5,
            'total' => 7,
            'checks' => [
                [
                    'check' => VerificationCheck::Identity,
                    'status' => VerificationStatus::Verified,
                    'source' => 'Persona',
                    'evidence' => 'Nigerian passport A0xxxxxx · liveness match 99.2%',
                    'completed' => '12 Oct 2026 · 4 min',
                ],
                [
                    'check' => VerificationCheck::Education,
                    'status' => VerificationStatus::Verified,
                    'source' => 'National Student Clearinghouse',
                    'evidence' => 'BSc Computer Science, University of Lagos, conferred Jul 2019',
                    'completed' => '12 Oct 2026 · 1 day',
                ],
                [
                    'check' => VerificationCheck::Employment,
                    'status' => VerificationStatus::Verified,
                    'source' => 'Truework',
                    'evidence' => '3 of 3 confirmed — Paystack, Flutterwave, Andela. No date gaps.',
                    'completed' => '14 Oct 2026 · 2 days',
                ],
                [
                    'check' => VerificationCheck::Reference,
                    'status' => VerificationStatus::Verified,
                    'source' => 'Structured call · in-house',
                    'evidence' => '2 completed with named line managers. Both would rehire.',
                    'completed' => '15 Oct 2026 · 3 days',
                ],
                [
                    'check' => VerificationCheck::Sanctions,
                    'status' => VerificationStatus::Verified,
                    'source' => 'ComplyAdvantage',
                    'evidence' => 'No sanctions, PEP or adverse media hits across 112 lists',
                    'completed' => '12 Oct 2026 · 2 min',
                ],
                [
                    'check' => VerificationCheck::Certification,
                    'status' => VerificationStatus::InProgress,
                    'source' => 'Linux Foundation',
                    'evidence' => 'CKA credential ID submitted — awaiting issuer response',
                    'completed' => null,
                ],
                [
                    'check' => VerificationCheck::RightToWork,
                    'status' => VerificationStatus::Pending,
                    'source' => 'Checkr',
                    'evidence' => 'UK right to work needs the candidate’s passport page',
                    'completed' => null,
                ],
            ],
            'timeline' => [
                ['at' => '15 Oct · 16:20', 'text' => 'Second reference call completed and written up.'],
                ['at' => '14 Oct · 11:05', 'text' => 'Andela confirmed title and dates. Employment check cleared.'],
                ['at' => '13 Oct · 09:41', 'text' => 'Certification request sent to the Linux Foundation.'],
                ['at' => '12 Oct · 14:02', 'text' => 'Identity, education and sanctions cleared.'],
                ['at' => '12 Oct · 13:58', 'text' => 'Candidate consented to all seven checks.'],
            ],
        ];
    }

    /**
     * Configuration and results for the automated interview stage.
     *
     * @return array<string, mixed>
     */
    public static function aiInterview(): array
    {
        return [
            'role' => 'Senior Backend Engineer, Payments',
            'status' => InterviewStatus::Completed,
            'format' => 'Async · voice and screen share',
            'duration' => '25 min',
            'question_count' => 6,
            'invited' => 14,
            'completed' => 9,
            'median_score' => 78,
            'competencies' => [
                ['name' => 'Payments domain', 'weight' => 30],
                ['name' => 'System design', 'weight' => 30],
                ['name' => 'Code reasoning', 'weight' => 25],
                ['name' => 'Communication', 'weight' => 15],
            ],
            'questions' => [
                'Walk through what happens between a card authorisation and money landing in a merchant account.',
                'Design a settlement service for 14 countries with different cut-off times.',
                'A reconciliation job double-credits 2,400 merchants. Walk through your first hour.',
                'Explain idempotency to a product manager, then to an engineer.',
                'Review this 40-line Go handler and name the two bugs.',
                'Tell me about a system you decided not to build.',
            ],
            'guardrails' => [
                'Scores are advisory. No candidate is rejected by the model alone.',
                'Every answer is kept as audio, transcript and score for 24 months.',
                'Candidates may request a human screen instead, at any point, without penalty.',
                'The model never sees name, photo, age, gender or nationality.',
            ],
            'scorecard' => [
                'candidate' => 'Tunde Bello',
                'initials' => 'TB',
                'overall' => 86,
                'completed_in' => '23 min 11 sec',
                'reviewed_by' => 'Pending human review',
                'dimensions' => [
                    ['name' => 'Payments domain', 'score' => 94, 'note' => 'Named scheme cut-offs and interchange without prompting.'],
                    ['name' => 'System design', 'score' => 83, 'note' => 'Clear write path. Thin on partial-failure recovery.'],
                    ['name' => 'Code reasoning', 'score' => 88, 'note' => 'Found both bugs, including the subtle context leak.'],
                    ['name' => 'Communication', 'score' => 74, 'note' => 'Fast pace; interrupted the question twice.'],
                ],
                'highlights' => [
                    ['at' => '04:12', 'text' => 'Correctly separated authorisation from capture before being asked.'],
                    ['at' => '11:38', 'text' => 'Chose an append-only ledger and said exactly what it costs in query complexity.'],
                    ['at' => '19:02', 'text' => 'Spotted the shared context cancellation bug in 40 seconds.'],
                ],
                'concerns' => [
                    ['at' => '14:55', 'text' => 'Asked about partial settlement failure, moved to monitoring instead of recovery.'],
                ],
            ],
        ];
    }

    /**
     * Employees the platform legally employs on the employer's behalf.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public static function eorEmployees(): Collection
    {
        return collect([
            [
                'name' => 'Kwame Mensah',
                'initials' => 'KM',
                'role' => 'Senior Backend Engineer',
                'country' => 'Ghana',
                'flag' => '🇬🇭',
                'start' => '3 Nov 2026',
                'gross' => '$96,000',
                'employer_cost' => '$112,320',
                'status' => 'Onboarding',
                'contract' => 'Signed',
                'payroll' => 'First cycle 30 Nov',
                'outstanding' => ['Local bank details', 'Ghana Card copy'],
            ],
            [
                'name' => 'Zainab Idris',
                'initials' => 'ZI',
                'role' => 'Backend Engineer',
                'country' => 'Nigeria',
                'flag' => '🇳🇬',
                'start' => '17 Nov 2026',
                'gross' => '$78,000',
                'employer_cost' => '$89,700',
                'status' => 'Contract out',
                'contract' => 'Awaiting signature',
                'payroll' => 'Not started',
                'outstanding' => ['Employment contract', 'Pension election'],
            ],
            [
                'name' => 'Ana Luísa Costa',
                'initials' => 'AC',
                'role' => 'Product Designer',
                'country' => 'Portugal',
                'flag' => '🇵🇹',
                'start' => '1 Jun 2026',
                'gross' => '€68,000',
                'employer_cost' => '€84,320',
                'status' => 'Active',
                'contract' => 'Signed',
                'payroll' => 'Paid 25 Oct',
                'outstanding' => [],
            ],
            [
                'name' => 'Peter Mwangi',
                'initials' => 'PM',
                'role' => 'Data Engineer',
                'country' => 'Kenya',
                'flag' => '🇰🇪',
                'start' => '14 Apr 2026',
                'gross' => '$74,000',
                'employer_cost' => '$85,100',
                'status' => 'Active',
                'contract' => 'Signed',
                'payroll' => 'Paid 25 Oct',
                'outstanding' => ['NSSF tier-2 election'],
            ],
            [
                'name' => 'Grace Oyelaran',
                'initials' => 'GO',
                'role' => 'Compliance Analyst',
                'country' => 'Nigeria',
                'flag' => '🇳🇬',
                'start' => '2 Feb 2026',
                'gross' => '$64,000',
                'employer_cost' => '$73,600',
                'status' => 'Active',
                'contract' => 'Signed',
                'payroll' => 'Paid 25 Oct',
                'outstanding' => [],
            ],
        ]);
    }

    /**
     * Total countries the platform can act as employer of record in. The table
     * below is the sample shown in the mockups, not the whole list.
     */
    public static function eorCountryCount(): int
    {
        return 42;
    }

    /**
     * Countries the platform can act as employer of record in.
     *
     * @return list<array<string, mixed>>
     */
    public static function eorCountries(): array
    {
        return [
            ['country' => 'Nigeria', 'flag' => '🇳🇬', 'entity' => 'Own entity', 'onboarding' => '5 days', 'cost_uplift' => '15%', 'notice' => '1 month', 'leave' => '20 days', 'note' => 'PAYE and pension filed monthly.'],
            ['country' => 'Ghana', 'flag' => '🇬🇭', 'entity' => 'Own entity', 'onboarding' => '7 days', 'cost_uplift' => '17%', 'notice' => '1 month', 'leave' => '15 days', 'note' => 'SSNIT tier 1–3 handled.'],
            ['country' => 'Kenya', 'flag' => '🇰🇪', 'entity' => 'Own entity', 'onboarding' => '6 days', 'cost_uplift' => '15%', 'notice' => '1 month', 'leave' => '21 days', 'note' => 'NSSF and NHIF deductions applied.'],
            ['country' => 'Portugal', 'flag' => '🇵🇹', 'entity' => 'Own entity', 'onboarding' => '10 days', 'cost_uplift' => '24%', 'notice' => '2 months', 'leave' => '22 days', 'note' => 'Includes 14 monthly salaries.'],
            ['country' => 'United Kingdom', 'flag' => '🇬🇧', 'entity' => 'Own entity', 'onboarding' => '4 days', 'cost_uplift' => '18%', 'notice' => '1 month', 'leave' => '28 days', 'note' => 'Auto-enrolment pension from day one.'],
            ['country' => 'Germany', 'flag' => '🇩🇪', 'entity' => 'Partner', 'onboarding' => '14 days', 'cost_uplift' => '22%', 'notice' => '4 weeks', 'leave' => '24 days', 'note' => 'Works council consultation may apply.'],
            ['country' => 'India', 'flag' => '🇮🇳', 'entity' => 'Partner', 'onboarding' => '9 days', 'cost_uplift' => '16%', 'notice' => '1 month', 'leave' => '18 days', 'note' => 'EPF and gratuity accrual included.'],
            ['country' => 'Brazil', 'flag' => '🇧🇷', 'entity' => 'Partner', 'onboarding' => '15 days', 'cost_uplift' => '38%', 'notice' => '30 days', 'leave' => '30 days', 'note' => '13th salary and FGTS accrued monthly.'],
        ];
    }

    /**
     * Placed talent the employer manages on an ongoing basis.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public static function talentRoster(): Collection
    {
        return collect([
            [
                'name' => 'Ana Luísa Costa',
                'initials' => 'AC',
                'role' => 'Product Designer',
                'country' => 'Portugal',
                'flag' => '🇵🇹',
                'tenure' => '4 months',
                'engagement' => EngagementType::EmployerOfRecord,
                'performance' => 'Exceeding',
                'check_in' => 'Reviewed 18 Oct',
                'risk' => 'low',
                'next' => '6-month review · 1 Dec',
            ],
            [
                'name' => 'Peter Mwangi',
                'initials' => 'PM',
                'role' => 'Data Engineer',
                'country' => 'Kenya',
                'flag' => '🇰🇪',
                'tenure' => '6 months',
                'engagement' => EngagementType::EmployerOfRecord,
                'performance' => 'On track',
                'check_in' => 'Reviewed 11 Oct',
                'risk' => 'low',
                'next' => 'Probation close-out · 14 Oct ✓',
            ],
            [
                'name' => 'Grace Oyelaran',
                'initials' => 'GO',
                'role' => 'Compliance Analyst',
                'country' => 'Nigeria',
                'flag' => '🇳🇬',
                'tenure' => '9 months',
                'engagement' => EngagementType::EmployerOfRecord,
                'performance' => 'Needs support',
                'check_in' => 'Overdue by 23 days',
                'risk' => 'high',
                'next' => 'Manager check-in not booked',
            ],
            [
                'name' => 'Rahul Verma',
                'initials' => 'RV',
                'role' => 'QA Engineer',
                'country' => 'India',
                'flag' => '🇮🇳',
                'tenure' => '14 months',
                'engagement' => EngagementType::Contract,
                'performance' => 'On track',
                'check_in' => 'Reviewed 2 Oct',
                'risk' => 'medium',
                'next' => 'Contract renewal due 31 Dec',
            ],
        ]);
    }

    /**
     * Notifications for whichever side is signed in.
     *
     * @return list<array{title: string, body: string, at: string, unread: bool, tone: string}>
     */
    public static function notifications(): array
    {
        return [
            ['title' => 'Panel confirmed — Northwind Pay', 'body' => 'System design panel, Thursday 14:00 WAT. Three interviewers.', 'at' => '18 min ago', 'unread' => true, 'tone' => 'brand'],
            ['title' => 'Right-to-work check is waiting on you', 'body' => 'Upload your passport page to finish UK right to work.', 'at' => '2 hours ago', 'unread' => true, 'tone' => 'warn'],
            ['title' => 'New match · 94%', 'body' => 'Senior Backend Engineer, Payments at Northwind Pay.', 'at' => '5 hours ago', 'unread' => true, 'tone' => 'signal'],
            ['title' => 'CV review finished', 'body' => 'Score moved from 58 to 72. Five issues, two marked high.', 'at' => 'Yesterday', 'unread' => false, 'tone' => 'brand'],
            ['title' => 'Feedback released — Adunni Bank', 'body' => 'The panel shared a full scorecard with three actions.', 'at' => '4 weeks ago', 'unread' => false, 'tone' => 'stop'],
        ];
    }

    /**
     * Platform-wide figures for the admin console.
     *
     * @return array<string, mixed>
     */
    public static function adminOverview(): array
    {
        return [
            'stats' => [
                ['label' => 'Candidates', 'value' => '48,219', 'change' => '+1,804 this week'],
                ['label' => 'Employers', 'value' => '1,276', 'change' => '+38 this week'],
                ['label' => 'Roles live', 'value' => '9,431', 'change' => 'Across 5 feed sources'],
                ['label' => 'Checks run', 'value' => '112,604', 'change' => '94.2% cleared first time'],
            ],
            'queue' => [
                ['reference' => 'VER-2026-10-0391', 'candidate' => 'Amara Okonkwo', 'check' => VerificationCheck::RightToWork, 'waiting' => '2 days', 'status' => VerificationStatus::Pending],
                ['reference' => 'VER-2026-10-0388', 'candidate' => 'Oliver Grant', 'check' => VerificationCheck::Employment, 'waiting' => '3 days', 'status' => VerificationStatus::InProgress],
                ['reference' => 'VER-2026-10-0376', 'candidate' => 'Marcus Feld', 'check' => VerificationCheck::Education, 'waiting' => '5 days', 'status' => VerificationStatus::Failed],
                ['reference' => 'VER-2026-10-0361', 'candidate' => 'Ling Wei', 'check' => VerificationCheck::Sanctions, 'waiting' => '6 days', 'status' => VerificationStatus::InProgress],
            ],
            'feeds' => [
                ['provider' => 'greenhouse', 'roles' => 3812, 'synced' => '4 min ago', 'health' => 'ok'],
                ['provider' => 'lever', 'roles' => 2140, 'synced' => '7 min ago', 'health' => 'ok'],
                ['provider' => 'ashby', 'roles' => 1655, 'synced' => '11 min ago', 'health' => 'ok'],
                ['provider' => 'workable', 'roles' => 1189, 'synced' => '26 min ago', 'health' => 'slow'],
                ['provider' => 'linkedin', 'roles' => 635, 'synced' => '2 hours ago', 'health' => 'error'],
            ],
            'users' => [
                ['name' => 'Amara Okonkwo', 'email' => 'amara.okonkwo@example.com', 'role' => 'candidate', 'joined' => '12 Oct 2026', 'active' => true],
                ['name' => 'Dayo Adeleke', 'email' => 'dayo@northwindpay.example', 'role' => 'employer', 'joined' => '3 Mar 2026', 'active' => true],
                ['name' => 'Priya Raman', 'email' => 'priya@northwindpay.example', 'role' => 'employer', 'joined' => '3 Mar 2026', 'active' => true],
                ['name' => 'Marcus Feld', 'email' => 'marcus.feld@example.com', 'role' => 'candidate', 'joined' => '28 Sep 2026', 'active' => false],
                ['name' => 'Ops · Verification', 'email' => 'ops@aitalenthub.example', 'role' => 'admin', 'joined' => '1 Jan 2026', 'active' => true],
            ],
        ];
    }

    /**
     * Subscription plans shown on the pricing mockup.
     *
     * @return list<array<string, mixed>>
     */
    public static function plans(): array
    {
        return [
            [
                'name' => 'Candidate',
                'price' => 'Free',
                'cadence' => 'always',
                'pitch' => 'Everything you need to get hired. Employers pay for the hiring side.',
                'features' => [
                    'Matched roles from every connected feed',
                    'Three AI document reviews a month',
                    'Unlimited interview drills',
                    'Verification record you own and reuse',
                    'Written feedback after every interview',
                ],
                'cta' => 'Create a candidate account',
                'route' => 'register',
                'params' => ['account' => 'candidate'],
                'featured' => false,
            ],
            [
                'name' => 'Hiring',
                'price' => '$690',
                'cadence' => 'per role, per month',
                'pitch' => 'Verified pipelines and automated first-round interviews for one open role.',
                'features' => [
                    'Unlimited matched candidates per role',
                    'Seven verification checks per candidate',
                    'AI interview stage with human-reviewed scorecards',
                    'Structured feedback sent on your behalf',
                    'Five seats included',
                ],
                'cta' => 'Start hiring',
                'route' => 'register',
                'params' => ['account' => 'employer'],
                'featured' => true,
            ],
            [
                'name' => 'Employer of record',
                'price' => '8%',
                'cadence' => 'of gross salary, monthly',
                'pitch' => 'We become the legal employer in 42 countries so you can hire without an entity.',
                'features' => [
                    'Everything in Hiring',
                    'Compliant contracts in local law',
                    'Payroll, tax and statutory benefits',
                    'Onboarding in 4–15 days by country',
                    'Ongoing talent management reviews',
                ],
                'cta' => 'Talk to us',
                'route' => 'employers',
                'params' => [],
                'featured' => false,
            ],
        ];
    }

    /**
     * Mobile screens rendered in the device gallery.
     *
     * @return list<array{slug: string, name: string, side: string, note: string}>
     */
    public static function mobileScreens(): array
    {
        return [
            ['slug' => 'candidate-home', 'name' => 'Candidate home', 'side' => 'Candidate', 'note' => 'Readiness score and the next blocking task.'],
            ['slug' => 'match-feed', 'name' => 'Match feed', 'side' => 'Candidate', 'note' => 'One role at a time, with the match reasons.'],
            ['slug' => 'cv-review', 'name' => 'CV review', 'side' => 'Candidate', 'note' => 'Issue list with the rewrite inline.'],
            ['slug' => 'interview-drill', 'name' => 'Interview drill', 'side' => 'Candidate', 'note' => 'Voice drill with live delivery signals.'],
            ['slug' => 'employer-pipeline', 'name' => 'Pipeline', 'side' => 'Employer', 'note' => 'Stage columns, swipe between them.'],
            ['slug' => 'verification', 'name' => 'Verification', 'side' => 'Employer', 'note' => 'Seven checks and their data sources.'],
        ];
    }
}
