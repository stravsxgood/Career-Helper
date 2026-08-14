<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Career Helper') }} — Dashboard</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js & Livewire Styles -->
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: Inter, ui-sans-serif, system-ui, sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', Inter, ui-sans-serif, system-ui, sans-serif; }
        @keyframes subtleFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .subtle-float { animation: subtleFloat 6s ease-in-out infinite; }
    </style>
</head>

<body class="min-h-screen bg-[#F8FAFC] text-slate-950 antialiased selection:bg-blue-200 selection:text-slate-950 dark:bg-slate-950 dark:text-slate-100">

    <!-- Sidebar Navigation -->
    @include('layouts.app.sidebar')

    <main class="min-h-screen pb-28 lg:ml-72 lg:pb-8">
        <div class="w-full px-4 py-5 sm:px-6 lg:px-8 lg:py-8">

            <!-- Top Welcome Banner -->
            <header class="relative overflow-hidden rounded-4xl bg-slate-950 p-6 shadow-2xl shadow-slate-950/15 sm:p-8">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(66,133,244,0.25),transparent_35%),radial-gradient(circle_at_85%_15%,rgba(52,168,83,0.18),transparent_30%),radial-gradient(circle_at_75%_80%,rgba(251,188,5,0.15),transparent_28%)]"></div>
                <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3.5 py-1.5 text-xs font-bold text-slate-300 backdrop-blur-md">
                            <span class="h-2 w-2 rounded-full bg-[#34A853] shadow-[0_0_0_6px_rgba(52,168,83,0.15)]"></span>
                            Pipeline Status: {{ $metrics['total_applications'] }} Application{{ $metrics['total_applications'] === 1 ? '' : 's' }} Tracked
                        </div>
                        <h1 class="font-display mt-4 text-3xl font-black tracking-tight text-white sm:text-4xl lg:text-5xl">
                            Welcome back, {{ Auth::user()->name ?? Auth::user()->username }}!
                        </h1>
                        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-400 sm:text-base">
                            @if ($metrics['interview_count'] > 0)
                                You have {{ $metrics['interview_count'] }} interview stage(s) in progress. Focus on company research and interview prep today.
                            @elseif ($metrics['total_applications'] > 0)
                                Your career pipeline is moving. Focus today on roles with high fit scores and submit tailored applications.
                            @else
                                Start building your career momentum by recording your first job application and running an AI CV analysis.
                            @endif
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 lg:w-md shrink-0">
                        <!-- Next Action Card -->
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-md">
                            <p class="text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">Next Priority</p>
                            @if ($upcomingInterviews->isNotEmpty())
                                <p class="mt-1.5 text-sm font-bold text-white truncate" title="{{ $upcomingInterviews->first()->company_name }} ({{ $upcomingInterviews->first()->position }})">
                                    Follow up: {{ $upcomingInterviews->first()->company_name }}
                                </p>
                                <p class="mt-0.5 text-xs text-slate-400 truncate">{{ $upcomingInterviews->first()->position }}</p>
                            @elseif ($metrics['total_applications'] > 0)
                                <p class="mt-1.5 text-sm font-bold text-white">Send 2-3 tailored applications</p>
                                <p class="mt-0.5 text-xs text-slate-400">Maintain pipeline momentum</p>
                            @else
                                <a href="{{ route('recordjob.create') }}" class="mt-1.5 block text-sm font-bold text-blue-400 hover:text-blue-300">
                                    + Record first application &rarr;
                                </a>
                            @endif
                        </div>

                        <!-- AI Career Match Card -->
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-md">
                            <p class="text-[0.68rem] font-bold uppercase tracking-wider text-slate-400">AI Career Match</p>
                            @if ($latestAnalysis)
                                @php
                                    $role = data_get($latestAnalysis->output_json, 'recommended_roles.0.role', data_get($latestAnalysis->input_json, 'target_role', 'Career Analysis'));
                                    $score = data_get($latestAnalysis->output_json, 'cv_feedback.cv_score', data_get($latestAnalysis->output_json, 'recommended_roles.0.fit_score'));
                                @endphp
                                <a href="{{ route('result', $latestAnalysis->id) }}" class="mt-1.5 block text-sm font-bold text-white truncate hover:text-blue-300 transition" title="{{ $role }}">
                                    {{ $role }}
                                </a>
                                <p class="mt-0.5 text-xs text-emerald-400 font-semibold">
                                    {{ $score ? $score . '% Match Score' : 'Analysis Complete' }}
                                </p>
                            @else
                                <a href="{{ route('analysis') }}" class="mt-1.5 block text-sm font-bold text-emerald-400 hover:text-emerald-300">
                                    Run AI Career Analysis &rarr;
                                </a>
                                <p class="mt-0.5 text-xs text-slate-400">Get CV feedback & role matches</p>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- 4 Real-time Summary Metric Cards -->
            <section aria-label="Career metrics" class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <!-- 1. Applications Sent -->
                <article class="group overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/8 dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Applications Sent</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-950 dark:text-white">{{ number_format($metrics['total_applications']) }}</p>
                        </div>
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-blue-50 text-[#4285F4] ring-1 ring-blue-100 dark:bg-blue-950/40 dark:ring-blue-900/50 transition duration-300 group-hover:scale-105">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                            +{{ $metrics['this_week_applications'] }} this week
                        </span>
                        <a href="{{ route('recordjob.index') }}" class="text-xs font-semibold text-[#4285F4] hover:underline">View all</a>
                    </div>
                </article>

                <!-- 2. Interviews Scheduled -->
                <article class="group overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/8 dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Interviews</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-950 dark:text-white">{{ number_format($metrics['interview_count']) }}</p>
                        </div>
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-emerald-50 text-[#34A853] ring-1 ring-emerald-100 dark:bg-emerald-950/40 dark:ring-emerald-900/50 transition duration-300 group-hover:scale-105">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-[#188038] dark:bg-emerald-950/40 dark:text-emerald-300">
                            {{ $metrics['interview_rate'] }}% interview rate
                        </span>
                        <a href="{{ route('recordjob.index', ['status' => 'Interview']) }}" class="text-xs font-semibold text-[#34A853] hover:underline">Filter</a>
                    </div>
                </article>

                <!-- 3. Technical Testing & Assessments -->
                <article class="group overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/8 dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Testing & Review</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-950 dark:text-white">{{ number_format($metrics['testing_count']) }}</p>
                        </div>
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-yellow-50 text-[#B77900] ring-1 ring-yellow-100 dark:bg-yellow-950/40 dark:ring-yellow-900/50 transition duration-300 group-hover:scale-105">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="16 18 22 12 16 6" />
                                <polyline points="8 6 2 12 8 18" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1 rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-bold text-yellow-800 dark:bg-yellow-950/40 dark:text-yellow-300">
                            {{ $metrics['total_analyses'] }} AI Report{{ $metrics['total_analyses'] === 1 ? '' : 's' }}
                        </span>
                        <a href="{{ route('recordjob.index', ['status' => 'Testing']) }}" class="text-xs font-semibold text-[#B77900] hover:underline">Filter</a>
                    </div>
                </article>

                <!-- 4. Accepted Offers -->
                <article class="group overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/8 dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Accepted Offers</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-950 dark:text-white">{{ number_format($metrics['accepted_count']) }}</p>
                        </div>
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-red-50 text-[#EA4335] ring-1 ring-red-100 dark:bg-red-950/40 dark:ring-red-900/50 transition duration-300 group-hover:scale-105">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4 flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2.5 py-1 text-xs font-bold text-[#EA4335] dark:bg-red-950/40 dark:text-red-300">
                            {{ $metrics['acceptance_rate'] }}% acceptance rate
                        </span>
                        <a href="{{ route('recordjob.index', ['status' => 'Accepted']) }}" class="text-xs font-semibold text-[#EA4335] hover:underline">Filter</a>
                    </div>
                </article>
            </section>

            <!-- Visual Analytics Section (Charts) -->
            <section class="mt-6 grid gap-6 xl:grid-cols-[0.86fr_1.14fr]">

                <!-- Chart 1: Application Status Distribution -->
                <article class="rounded-4xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Application Status Distribution</p>
                            <h2 class="font-display mt-1 text-2xl font-black tracking-[-0.03em] text-slate-950 dark:text-white">Pipeline Health</h2>
                        </div>
                        <span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-extrabold text-[#4285F4] ring-1 ring-blue-100 dark:bg-blue-950/50 dark:text-blue-300">Live Data</span>
                    </div>

                    @if ($statusDistribution['total'] > 0)
                        <div class="mt-6 grid items-center gap-6 sm:grid-cols-[1fr_1fr]">
                            <div class="relative mx-auto h-56 w-full max-w-[18rem]">
                                <canvas id="applicationStatusChart"></canvas>
                            </div>
                            <div class="space-y-2.5">
                                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-3.5 py-2.5 dark:bg-slate-800/60">
                                    <span class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                        <span class="h-2.5 w-2.5 rounded-full bg-[#4285F4]"></span>Applied
                                    </span>
                                    <span class="text-xs font-black text-slate-950 dark:text-white">
                                        {{ $statusDistribution['counts']['Applied'] ?? 0 }} ({{ $statusDistribution['percentages']['Applied'] ?? 0 }}%)
                                    </span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-3.5 py-2.5 dark:bg-slate-800/60">
                                    <span class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                        <span class="h-2.5 w-2.5 rounded-full bg-[#FBBC05]"></span>Interview
                                    </span>
                                    <span class="text-xs font-black text-slate-950 dark:text-white">
                                        {{ $statusDistribution['counts']['Interview'] ?? 0 }} ({{ $statusDistribution['percentages']['Interview'] ?? 0 }}%)
                                    </span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-3.5 py-2.5 dark:bg-slate-800/60">
                                    <span class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                        <span class="h-2.5 w-2.5 rounded-full bg-[#A855F7]"></span>Testing
                                    </span>
                                    <span class="text-xs font-black text-slate-950 dark:text-white">
                                        {{ $statusDistribution['counts']['Testing'] ?? 0 }} ({{ $statusDistribution['percentages']['Testing'] ?? 0 }}%)
                                    </span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-3.5 py-2.5 dark:bg-slate-800/60">
                                    <span class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                        <span class="h-2.5 w-2.5 rounded-full bg-[#34A853]"></span>Accepted
                                    </span>
                                    <span class="text-xs font-black text-slate-950 dark:text-white">
                                        {{ $statusDistribution['counts']['Accepted'] ?? 0 }} ({{ $statusDistribution['percentages']['Accepted'] ?? 0 }}%)
                                    </span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-3.5 py-2.5 dark:bg-slate-800/60">
                                    <span class="flex items-center gap-2 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                        <span class="h-2.5 w-2.5 rounded-full bg-[#EA4335]"></span>Rejected
                                    </span>
                                    <span class="text-xs font-black text-slate-950 dark:text-white">
                                        {{ $statusDistribution['counts']['Rejected'] ?? 0 }} ({{ $statusDistribution['percentages']['Rejected'] ?? 0 }}%)
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-8 flex flex-col items-center justify-center py-10 text-center">
                            <div class="grid h-14 w-14 place-items-center rounded-2xl bg-blue-50 text-[#4285F4] dark:bg-slate-800">
                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 6v6l4 2" />
                                </svg>
                            </div>
                            <p class="mt-4 text-sm font-bold text-slate-900 dark:text-white">No application records yet</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Record your applications to see live visual status charts here.</p>
                            <a href="{{ route('recordjob.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#4285F4] px-4 py-2 text-xs font-bold text-white transition hover:bg-blue-600">
                                + Add Application
                            </a>
                        </div>
                    @endif
                </article>

                <!-- Chart 2: Monthly Trends Chart -->
                <article class="rounded-4xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Application & Interview Trends</p>
                            <h2 class="font-display mt-1 text-2xl font-black tracking-[-0.03em] text-slate-950 dark:text-white">Monthly Progression</h2>
                        </div>
                        <div class="flex gap-2">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-950 px-3 py-1.5 text-xs font-extrabold text-white dark:bg-white dark:text-slate-950">
                                <span class="h-2 w-2 rounded-full bg-[#4285F4]"></span> Applications
                            </span>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-extrabold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                <span class="h-2 w-2 rounded-full bg-[#34A853]"></span> Interviews
                            </span>
                        </div>
                    </div>
                    <div class="mt-6 h-72">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </article>
            </section>

            <!-- Detailed Lists Section -->
            <section class="mt-6 grid gap-6 xl:grid-cols-[1fr_1fr]">

                <!-- Left: Active Interviews & Assessment Pipeline -->
                <article class="rounded-4xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Active Stages</p>
                            <h2 class="font-display mt-1 text-2xl font-black tracking-[-0.03em] text-slate-950 dark:text-white">Upcoming Interviews & Testing</h2>
                        </div>
                        <a href="{{ route('recordjob.index', ['status' => 'Interview']) }}" class="rounded-2xl bg-slate-100 px-4 py-2 text-xs font-extrabold text-slate-700 transition hover:bg-slate-950 hover:text-white dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                            View all
                        </a>
                    </div>

                    <div class="mt-6 space-y-3">
                        @forelse ($upcomingInterviews as $interview)
                            @php
                                $isInterview = ($interview->status === 'Interview');
                                $dot = $isInterview ? 'bg-[#FBBC05] shadow-[0_0_0_7px_rgba(251,188,5,0.15)]' : 'bg-[#A855F7] shadow-[0_0_0_7px_rgba(168,85,247,0.15)]';
                            @endphp
                            <div class="group relative grid grid-cols-[4.75rem_1fr] gap-4 rounded-[1.55rem] border border-slate-200 bg-slate-50 p-3.5 transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:bg-white hover:shadow-xl hover:shadow-slate-950/8 dark:border-slate-800 dark:bg-slate-800/40 dark:hover:bg-slate-800">
                                <div class="rounded-2xl bg-white px-3 py-3.5 text-center shadow-sm transition duration-300 group-hover:bg-slate-950 dark:bg-slate-900 dark:group-hover:bg-white">
                                    <p class="text-sm font-black text-slate-950 transition duration-300 group-hover:text-white dark:text-white dark:group-hover:text-slate-950">
                                        {{ $interview->applied_at ? $interview->applied_at->format('d M') : 'Soon' }}
                                    </p>
                                    <p class="mt-0.5 text-[0.68rem] font-bold uppercase tracking-[0.18em] text-slate-400">
                                        {{ $interview->applied_at ? $interview->applied_at->format('Y') : 'Stage' }}
                                    </p>
                                </div>
                                <div class="flex min-w-0 items-center justify-between gap-4">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $dot }}"></span>
                                            <h3 class="truncate text-sm font-extrabold text-slate-950 dark:text-white">{{ $interview->company_name }}</h3>
                                        </div>
                                        <p class="mt-1 truncate text-xs font-semibold text-slate-500 dark:text-slate-400">
                                            {{ $interview->position }} &middot; {{ $interview->platform }}
                                        </p>
                                    </div>
                                    <span class="inline-flex shrink-0 rounded-full px-2.5 py-0.5 text-xs font-bold {{ $isInterview ? 'bg-amber-50 text-amber-700 border border-amber-200/60 dark:bg-amber-950/50 dark:text-amber-300' : 'bg-purple-50 text-purple-700 border border-purple-200/60 dark:bg-purple-950/50 dark:text-purple-300' }}">
                                        {{ $interview->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 p-8 text-center dark:border-slate-800">
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">No active interviews or assessments</p>
                                <p class="mt-1 text-xs text-slate-400">Applications marked as "Interview" or "Testing" will appear here.</p>
                                <a href="{{ route('recordjob.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#4285F4] px-4 py-2 text-xs font-bold text-white transition hover:bg-blue-600">
                                    + Add Application
                                </a>
                            </div>
                        @endforelse
                    </div>
                </article>

                <!-- Right: Recent Applications History -->
                <article class="rounded-4xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tracked History</p>
                            <h2 class="font-display mt-1 text-2xl font-black tracking-[-0.03em] text-slate-950 dark:text-white">Recent Applications</h2>
                        </div>
                        <a href="{{ route('recordjob.index') }}" class="rounded-2xl bg-slate-950 px-4 py-2 text-xs font-extrabold text-white transition duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-slate-950/[0.14] dark:bg-white dark:text-slate-950">
                            Open full list
                        </a>
                    </div>

                    <div class="mt-6 space-y-3">
                        @forelse ($recentApplications as $job)
                            @php
                                $badgeStyles = [
                                    'Applied'   => 'bg-blue-50 text-[#4285F4] border-blue-200/60 dark:bg-blue-950/40 dark:text-blue-300',
                                    'Interview' => 'bg-amber-50 text-amber-700 border-amber-200/60 dark:bg-amber-950/40 dark:text-amber-300',
                                    'Testing'   => 'bg-purple-50 text-purple-700 border-purple-200/60 dark:bg-purple-950/40 dark:text-purple-300',
                                    'Accepted'  => 'bg-emerald-50 text-[#34A853] border-emerald-200/60 dark:bg-emerald-950/40 dark:text-emerald-300',
                                    'Rejected'  => 'bg-red-50 text-[#EA4335] border-red-200/60 dark:bg-red-950/40 dark:text-red-300',
                                ];
                                $currentBadge = $badgeStyles[$job->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                            @endphp
                            <div class="group rounded-[1.55rem] border border-slate-200 bg-white p-4 transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/8 dark:border-slate-800 dark:bg-slate-900">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-base font-extrabold tracking-tight text-slate-950 dark:text-white">{{ $job->company_name }}</h3>
                                        <p class="mt-0.5 text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $job->position }}</p>
                                    </div>
                                    <span class="inline-flex shrink-0 rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $currentBadge }}">
                                        {{ $job->status }}
                                    </span>
                                </div>
                                <div class="mt-4 flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $job->platform }}</span>
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-[#34A853] ring-1 ring-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-300">{{ $job->formatted_salary }}</span>
                                    <span class="rounded-full bg-slate-50 px-3 py-1 text-xs font-medium text-slate-400 dark:bg-slate-800/60">
                                        {{ $job->applied_at ? $job->applied_at->format('d M Y') : 'No Date' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-200 p-8 text-center dark:border-slate-800">
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">No applications recorded yet</p>
                                <p class="mt-1 text-xs text-slate-400">Start adding your applications to track your career progress.</p>
                                <a href="{{ route('recordjob.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-[#4285F4] px-4 py-2 text-xs font-bold text-white transition hover:bg-blue-600">
                                    + Add First Application
                                </a>
                            </div>
                        @endforelse
                    </div>
                </article>
            </section>
        </div>
    </main>

    <!-- Chart.js Real-time Database Rendering -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const statusCanvas = document.getElementById('applicationStatusChart');
            const monthlyCanvas = document.getElementById('monthlyTrendChart');

            const statusData = @json($statusDistribution);
            const monthlyData = @json($monthlyTrend);

            // 1. Pipeline Status Doughnut Chart
            if (statusCanvas && statusData && statusData.total > 0) {
                new Chart(statusCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: statusData.labels,
                        datasets: [{
                            data: statusData.data,
                            backgroundColor: ['#4285F4', '#FBBC05', '#A855F7', '#34A853', '#EA4335'],
                            borderColor: '#ffffff',
                            borderWidth: 4,
                            hoverOffset: 8,
                            borderRadius: 8,
                            spacing: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        animation: { duration: 1000, easing: 'easeInOutQuart' },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                padding: 12,
                                backgroundColor: '#0F172A',
                                titleColor: '#ffffff',
                                bodyColor: '#CBD5E1',
                                borderColor: 'rgba(255,255,255,0.1)',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const percentage = statusData.percentages[label] || 0;
                                        return ` ${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // 2. Monthly Progression Line Chart
            if (monthlyCanvas && monthlyData) {
                const ctx = monthlyCanvas.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 240);
                gradient.addColorStop(0, 'rgba(66, 133, 244, 0.25)');
                gradient.addColorStop(1, 'rgba(66, 133, 244, 0.01)');

                new Chart(monthlyCanvas, {
                    type: 'line',
                    data: {
                        labels: monthlyData.labels,
                        datasets: [
                            {
                                label: 'Applications',
                                data: monthlyData.applications,
                                fill: true,
                                backgroundColor: gradient,
                                borderColor: '#4285F4',
                                borderWidth: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#4285F4',
                                pointBorderWidth: 2.5,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.38
                            },
                            {
                                label: 'Interviews',
                                data: monthlyData.interviews,
                                fill: false,
                                borderColor: '#34A853',
                                borderWidth: 2.5,
                                borderDash: [5, 5],
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#34A853',
                                pointBorderWidth: 2.5,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.38
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        animation: { duration: 1000, easing: 'easeInOutQuart' },
                        scales: {
                            x: {
                                grid: { display: false, drawBorder: false },
                                ticks: { color: '#64748B', font: { weight: '600' } }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    color: '#64748B',
                                    font: { weight: '600' },
                                    padding: 8
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.12)',
                                    drawBorder: false
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                padding: 12,
                                backgroundColor: '#0F172A',
                                titleColor: '#ffffff',
                                bodyColor: '#CBD5E1',
                                borderColor: 'rgba(255,255,255,0.1)',
                                borderWidth: 1
                            }
                        }
                    }
                });
            }
        });
    </script>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
