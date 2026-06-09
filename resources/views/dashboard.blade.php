<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard — Career Helper</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
<body class="min-h-screen bg-[#F8FAFC] text-slate-950 antialiased selection:bg-blue-200 selection:text-slate-950">
    @include('layouts.app.sidebar')

    @php
        $userName = auth()->user()?->name ?? 'Career Seeker';
        $metrics = [
            ['label' => 'Applications Sent', 'value' => '38', 'change' => '+12 this week', 'accent' => 'blue', 'icon' => 'M9 12l2 2 4-4M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
            ['label' => 'Interviews Scheduled', 'value' => '6', 'change' => '2 tomorrow', 'accent' => 'green', 'icon' => 'M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z'],
            ['label' => 'Profile Views', 'value' => '1,284', 'change' => '+18.6%', 'accent' => 'yellow', 'icon' => 'M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12s-3.5 6.75-9.75 6.75S2.25 12 2.25 12Z M12 15.25a3.25 3.25 0 1 0 0-6.5 3.25 3.25 0 0 0 0 6.5Z'],
            ['label' => 'Skill Match Score', 'value' => '84%', 'change' => '+7 points', 'accent' => 'red', 'icon' => 'M13 2 3 14h8l-1 8 10-12h-8l1-8Z'],
        ];
        $jobs = [
            ['title' => 'Junior Backend Developer', 'company' => 'Nusantara Cloud', 'meta' => 'Remote · Laravel · 0-2 yrs', 'score' => '91%', 'salary' => 'IDR 6-9m'],
            ['title' => 'AI Product Assistant', 'company' => 'Karya Digital Labs', 'meta' => 'Hybrid · Prompting · API', 'score' => '87%', 'salary' => 'IDR 5-8m'],
            ['title' => 'Laravel Support Engineer', 'company' => 'Orbit Systems', 'meta' => 'Remote · Debugging · MySQL', 'score' => '82%', 'salary' => 'IDR 5-7m'],
        ];
        $interviews = [
            ['time' => '09:30', 'title' => 'Technical screening', 'company' => 'Nusantara Cloud', 'type' => 'Google Meet', 'color' => 'blue'],
            ['time' => '13:00', 'title' => 'HR culture fit', 'company' => 'Karya Digital Labs', 'type' => 'Phone call', 'color' => 'green'],
            ['time' => '16:15', 'title' => 'Portfolio review', 'company' => 'Orbit Systems', 'type' => 'Zoom', 'color' => 'yellow'],
        ];
    @endphp

    <main class="min-h-screen pb-28 lg:ml-72 lg:pb-0">
        <div class="mx-auto max-w-[92rem] px-4 py-5 sm:px-6 lg:px-8 lg:py-8">
            <header class="relative overflow-hidden rounded-[2rem] bg-slate-950 p-5 shadow-2xl shadow-slate-950/[0.12] sm:p-7 lg:p-8">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(66,133,244,0.22),transparent_28%),radial-gradient(circle_at_85%_10%,rgba(52,168,83,0.14),transparent_25%),radial-gradient(circle_at_76%_80%,rgba(251,188,5,0.12),transparent_24%)]"></div>
                <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/[0.06] px-3 py-1.5 text-xs font-bold text-slate-300 backdrop-blur">
                            <span class="h-2 w-2 rounded-full bg-[#34A853] shadow-[0_0_0_6px_rgba(52,168,83,0.13)]"></span>
                            Job market status: active hiring window
                        </div>
                        <h1 class="font-display mt-4 text-3xl font-black tracking-[-0.04em] text-white sm:text-4xl lg:text-5xl">Welcome back, {{ Auth::user()->username }}</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-400 sm:text-base">Your career pipeline is moving. Focus today on roles with the highest fit score and follow up on interviews within the next 24 hours.</p>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2 lg:w-[28rem]">
                        <div class="rounded-[1.45rem] border border-white/10 bg-white/[0.06] p-4 backdrop-blur">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-500">Next action</p>
                            <p class="mt-2 text-sm font-bold text-white">Send 3 tailored applications</p>
                        </div>
                        <div class="rounded-[1.45rem] border border-white/10 bg-white/[0.06] p-4 backdrop-blur">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-500">Resume version</p>
                            <p class="mt-2 text-sm font-bold text-white">Backend v4 · 84% optimized</p>
                        </div>
                    </div>
                </div>
            </header>

            <section aria-label="Career metrics" class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($metrics as $metric)
                    @php
                        $accentClasses = [
                            'blue' => 'bg-blue-50 text-[#4285F4] ring-blue-100',
                            'green' => 'bg-emerald-50 text-[#34A853] ring-emerald-100',
                            'yellow' => 'bg-yellow-50 text-[#B77900] ring-yellow-100',
                            'red' => 'bg-red-50 text-[#EA4335] ring-red-100',
                        ][$metric['accent']];
                    @endphp
                    <article class="group overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/[0.08] sm:p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-500">{{ $metric['label'] }}</p>
                                <p class="mt-3 text-3xl font-black tracking-tight text-slate-950">{{ $metric['value'] }}</p>
                            </div>
                            <span class="grid h-11 w-11 place-items-center rounded-2xl ring-1 transition duration-300 group-hover:scale-105 {{ $accentClasses }}">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $metric['icon'] }}"/></svg>
                            </span>
                        </div>
                        <div class="mt-5 flex items-center justify-between gap-3">
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600">{{ $metric['change'] }}</span>
                            <span class="h-1.5 w-16 overflow-hidden rounded-full bg-slate-100">
                                <span class="block h-full w-[72%] rounded-full bg-slate-950 transition duration-500 group-hover:w-[88%]"></span>
                            </span>
                        </div>
                    </article>
                @endforeach
            </section>

            <section class="mt-5 grid gap-5 xl:grid-cols-[0.86fr_1.14fr]">
                <article class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-slate-500">Application Status Distribution</p>
                            <h2 class="font-display mt-1 text-2xl font-black tracking-[-0.03em] text-slate-950">Pipeline health</h2>
                        </div>
                        <span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-extrabold text-blue-700 ring-1 ring-blue-100">Live</span>
                    </div>
                    <div class="mt-5 grid items-center gap-5 sm:grid-cols-[1fr_0.9fr]">
                        <div class="mx-auto w-full max-w-[18rem]"><canvas id="applicationStatusChart" height="260"></canvas></div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3"><span class="flex items-center gap-2 text-sm font-semibold text-slate-600"><span class="h-2.5 w-2.5 rounded-full bg-[#34A853]"></span>Offered</span><span class="text-sm font-black text-slate-950">14%</span></div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3"><span class="flex items-center gap-2 text-sm font-semibold text-slate-600"><span class="h-2.5 w-2.5 rounded-full bg-[#4285F4]"></span>Interview</span><span class="text-sm font-black text-slate-950">26%</span></div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3"><span class="flex items-center gap-2 text-sm font-semibold text-slate-600"><span class="h-2.5 w-2.5 rounded-full bg-[#EA4335]"></span>Rejected</span><span class="text-sm font-black text-slate-950">19%</span></div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3"><span class="flex items-center gap-2 text-sm font-semibold text-slate-600"><span class="h-2.5 w-2.5 rounded-full bg-[#FBBC05]"></span>Pending</span><span class="text-sm font-black text-slate-950">41%</span></div>
                        </div>
                    </div>
                </article>

                <article class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-500">Monthly Profile Impressions & Clicks</p>
                            <h2 class="font-display mt-1 text-2xl font-black tracking-[-0.03em] text-slate-950">Recruiter attention trend</h2>
                        </div>
                        <div class="flex gap-2">
                            <span class="rounded-full bg-slate-950 px-3 py-1.5 text-xs font-extrabold text-white">Impressions</span>
                            <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-extrabold text-slate-600">Clicks</span>
                        </div>
                    </div>
                    <div class="mt-6 h-[19rem]"><canvas id="profileTrendChart"></canvas></div>
                </article>
            </section>

            <section class="mt-5 grid gap-5 xl:grid-cols-[0.95fr_1.05fr]">
                <article class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-slate-500">Upcoming Interviews</p>
                            <h2 class="font-display mt-1 text-2xl font-black tracking-[-0.03em] text-slate-950">Next 24 hours</h2>
                        </div>
                        <a href="{{ Route::has('applications.index') ? route('applications.index') : url('/applications') }}" class="rounded-2xl bg-slate-100 px-4 py-2 text-xs font-extrabold text-slate-700 transition hover:bg-slate-950 hover:text-white">View all</a>
                    </div>

                    <div class="mt-6 space-y-3">
                        @foreach ($interviews as $interview)
                            @php
                                $dot = [
                                    'blue' => 'bg-[#4285F4] shadow-[0_0_0_7px_rgba(66,133,244,0.12)]',
                                    'green' => 'bg-[#34A853] shadow-[0_0_0_7px_rgba(52,168,83,0.12)]',
                                    'yellow' => 'bg-[#FBBC05] shadow-[0_0_0_7px_rgba(251,188,5,0.13)]',
                                ][$interview['color']];
                            @endphp
                            <div class="group relative grid grid-cols-[4.5rem_1fr] gap-4 rounded-[1.55rem] border border-slate-200 bg-slate-50 p-3 transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:bg-white hover:shadow-xl hover:shadow-slate-950/[0.08]">
                                <div class="rounded-2xl bg-white px-3 py-4 text-center shadow-sm transition duration-300 group-hover:bg-slate-950">
                                    <p class="text-sm font-black text-slate-950 transition duration-300 group-hover:text-white">{{ $interview['time'] }}</p>
                                    <p class="mt-1 text-[0.68rem] font-bold uppercase tracking-[0.18em] text-slate-400">Today</p>
                                </div>
                                <div class="flex min-w-0 items-center justify-between gap-4">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $dot }}"></span>
                                            <h3 class="truncate text-sm font-extrabold text-slate-950">{{ $interview['title'] }}</h3>
                                        </div>
                                        <p class="mt-1 truncate text-sm font-semibold text-slate-500">{{ $interview['company'] }} · {{ $interview['type'] }}</p>
                                    </div>
                                    <button type="button" class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl bg-white text-slate-500 shadow-sm transition duration-300 hover:bg-blue-50 hover:text-[#4285F4]">
                                        <svg class="h-[1.125rem] w-[1.125rem]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 5 7 7-7 7"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article x-data="{ saved: {} }" class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-500">Recommended Jobs for You</p>
                            <h2 class="font-display mt-1 text-2xl font-black tracking-[-0.03em] text-slate-950">High-fit roles</h2>
                        </div>
                        <a href="{{ Route::has('jobs.index') ? route('jobs.index') : url('/jobs') }}" class="rounded-2xl bg-slate-950 px-4 py-2 text-xs font-extrabold text-white transition duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-slate-950/[0.14]">Open search</a>
                    </div>

                    <div class="mt-6 space-y-3">
                        @foreach ($jobs as $index => $job)
                            <div class="group rounded-[1.55rem] border border-slate-200 bg-white p-4 transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/[0.08]">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-base font-extrabold tracking-tight text-slate-950">{{ $job['title'] }}</h3>
                                        <p class="mt-1 text-sm font-semibold text-slate-500">{{ $job['company'] }}</p>
                                    </div>
                                    <button type="button" @click="saved[{{ $index }}] = !saved[{{ $index }}]" class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl border border-slate-200 transition duration-300 hover:-translate-y-0.5" :class="saved[{{ $index }}] ? 'bg-[#FBBC05]/[0.15] text-[#B77900] border-[#FBBC05]/30' : 'bg-slate-50 text-slate-500 hover:bg-slate-950 hover:text-white'" :aria-pressed="saved[{{ $index }}] ? 'true' : 'false'">
                                        <svg class="h-[1.125rem] w-[1.125rem] transition duration-300" :class="saved[{{ $index }}] ? 'scale-110 fill-current' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21 12 17 5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16Z"/></svg>
                                    </button>
                                </div>
                                <div class="mt-4 flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-extrabold text-blue-700 ring-1 ring-blue-100">{{ $job['score'] }} match</span>
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700 ring-1 ring-emerald-100">{{ $job['salary'] }}</span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $job['meta'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const statusCanvas = document.getElementById('applicationStatusChart');
            const profileCanvas = document.getElementById('profileTrendChart');

            if (statusCanvas) {
                new Chart(statusCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: ['Offered', 'Interview', 'Rejected', 'Pending'],
                        datasets: [{
                            data: [14, 26, 19, 41],
                            backgroundColor: ['#34A853', '#4285F4', '#EA4335', '#FBBC05'],
                            borderColor: '#ffffff',
                            borderWidth: 5,
                            hoverOffset: 10,
                            borderRadius: 12,
                            spacing: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        animation: { duration: 1200, easing: 'easeInOutQuart' },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                padding: 12,
                                backgroundColor: '#0F172A',
                                titleColor: '#ffffff',
                                bodyColor: '#CBD5E1',
                                borderColor: 'rgba(255,255,255,0.1)',
                                borderWidth: 1,
                                displayColors: true,
                                callbacks: { label: context => `${context.label}: ${context.raw}%` }
                            }
                        }
                    }
                });
            }

            if (profileCanvas) {
                const ctx = profileCanvas.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 320);
                gradient.addColorStop(0, 'rgba(66, 133, 244, 0.28)');
                gradient.addColorStop(1, 'rgba(66, 133, 244, 0.02)');

                new Chart(profileCanvas, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        datasets: [
                            {
                                label: 'Impressions',
                                data: [320, 460, 520, 610, 740, 980, 1284],
                                fill: true,
                                backgroundColor: gradient,
                                borderColor: '#4285F4',
                                borderWidth: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#4285F4',
                                pointBorderWidth: 3,
                                pointRadius: 4,
                                pointHoverRadius: 7,
                                tension: 0.42
                            },
                            {
                                label: 'Clicks',
                                data: [28, 41, 52, 76, 91, 112, 148],
                                fill: false,
                                borderColor: '#34A853',
                                borderWidth: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#34A853',
                                pointBorderWidth: 3,
                                pointRadius: 4,
                                pointHoverRadius: 7,
                                tension: 0.42
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        animation: { duration: 1200, easing: 'easeInOutQuart' },
                        scales: {
                            x: {
                                grid: { display: false, drawBorder: false },
                                ticks: { color: '#64748B', font: { weight: 700 } }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(148, 163, 184, 0.18)', drawBorder: false },
                                ticks: { color: '#64748B', font: { weight: 700 }, padding: 10 }
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
                                borderWidth: 1,
                                usePointStyle: true
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
