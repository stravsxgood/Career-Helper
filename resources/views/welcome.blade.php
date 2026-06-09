<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Career Helper — Find Better Work Faster</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: Inter, ui-sans-serif, system-ui, sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', Inter, ui-sans-serif, system-ui, sans-serif; }
        @keyframes slowDrift {
            0%, 100% { transform: translate3d(0, 0, 0) rotate(0deg); }
            50% { transform: translate3d(12px, -16px, 0) rotate(2deg); }
        }
        @keyframes softBlink {
            0%, 100% { opacity: .38; }
            50% { opacity: .9; }
        }
        .slow-drift { animation: slowDrift 9s ease-in-out infinite; }
        .soft-blink { animation: softBlink 2.8s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen bg-[#F8FAFC] text-slate-950 antialiased selection:bg-blue-200 selection:text-slate-950">
    <div class="relative isolate overflow-hidden">
        <div class="absolute inset-x-0 top-0 -z-10 h-[48rem] bg-[radial-gradient(circle_at_20%_20%,rgba(66,133,244,0.18),transparent_30%),radial-gradient(circle_at_78%_10%,rgba(52,168,83,0.12),transparent_26%),linear-gradient(180deg,#f8fafc_0%,#eef4ff_54%,#f8fafc_100%)]"></div>
        <div class="absolute left-0 top-0 -z-10 h-[34rem] w-[34rem] -translate-x-1/2 rounded-full bg-slate-900/5 blur-3xl"></div>

        <header x-data="{ open: false }" class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="group flex items-center gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-950 shadow-xl shadow-slate-950/[0.15] transition duration-300 group-hover:scale-105">
                    <span class="relative h-5 w-5 rounded-md bg-[#4285F4]">
                        <span class="absolute -right-1 -top-1 h-2.5 w-2.5 rounded-full bg-[#EA4335]"></span>
                        <span class="absolute -bottom-1 -left-1 h-2.5 w-2.5 rounded-full bg-[#34A853]"></span>
                        <span class="absolute -bottom-1 -right-1 h-2.5 w-2.5 rounded-full bg-[#FBBC05]"></span>
                    </span>
                </span>
                <span>
                    <span class="block font-display text-base font-extrabold tracking-tight">Career Helper</span>
                    <span class="block text-xs font-semibold text-slate-500">Work moves, organized.</span>
                </span>
            </a>

            <nav aria-label="Main navigation" class="hidden items-center gap-8 md:flex">
                <a href="#features" class="text-sm font-semibold text-slate-600 transition hover:text-slate-950">Features</a>
                <a href="#insights" class="text-sm font-semibold text-slate-600 transition hover:text-slate-950">Insights</a>
                <a href="#outcomes" class="text-sm font-semibold text-slate-600 transition hover:text-slate-950">Outcomes</a>
            </nav>

            <div class="hidden items-center gap-3 md:flex">
                <a href="{{ Route::has('login') ? route('login') : url('/login') }}" class="rounded-2xl px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-100 hover:text-slate-950">Log in</a>
                <a href="{{ Route::has('register') ? route('register') : url('/register') }}" class="group relative overflow-hidden rounded-2xl bg-slate-950 px-5 py-2.5 text-sm font-bold text-white shadow-xl shadow-slate-950/[0.15] transition duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-slate-950/20">
                    <span class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition duration-700 group-hover:translate-x-full"></span>
                    <span class="relative">Start free</span>
                </a>
            </div>

            <button type="button" @click="open = ! open" class="grid h-11 w-11 place-items-center rounded-2xl border border-slate-200 bg-white text-slate-800 shadow-sm md:hidden">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16"/><path d="M4 12h16"/><path d="M4 17h16"/></svg>
            </button>

            <div x-show="open" x-cloak x-transition class="absolute left-5 right-5 top-20 z-30 rounded-[1.7rem] border border-slate-200 bg-white/95 p-3 shadow-2xl shadow-slate-950/10 backdrop-blur-xl md:hidden">
                <a href="#features" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Features</a>
                <a href="#insights" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Insights</a>
                <a href="#outcomes" class="block rounded-2xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Outcomes</a>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    <a href="{{ Route::has('login') ? route('login') : url('/login') }}" class="rounded-2xl bg-slate-100 px-4 py-3 text-center text-sm font-bold text-slate-800">Log in</a>
                    <a href="{{ Route::has('register') ? route('register') : url('/register') }}" class="rounded-2xl bg-slate-950 px-4 py-3 text-center text-sm font-bold text-white">Start free</a>
                </div>
            </div>
        </header>

        <main>
            <section class="mx-auto grid max-w-7xl items-center gap-12 px-5 pb-16 pt-10 sm:px-6 md:pt-16 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:pb-24">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/[0.78] px-3 py-2 text-xs font-bold text-slate-600 shadow-sm backdrop-blur">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-[#34A853] shadow-[0_0_0_6px_rgba(52,168,83,0.12)]"></span>
                        Live job-market guidance, not a static tracker
                    </div>

                    <h1 class="font-display mt-7 max-w-4xl text-5xl font-black leading-[0.95] tracking-[-0.06em] text-slate-950 sm:text-6xl lg:text-7xl">
                        Turn job hunting into a clean, measurable system.
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">
                        Career Helper helps workers find relevant jobs, improve resumes, track every application, and understand which actions actually move their career forward.
                    </p>

                    <form action="{{ Route::has('jobs.index') ? route('jobs.index') : url('/jobs') }}" method="GET" x-data="{ focused: false, role: '' }" class="mt-8 max-w-2xl">
                        <label for="landing-role-search" class="sr-only">Search job or role</label>
                        <div class="group relative rounded-[1.65rem] border border-slate-200 bg-white p-2 shadow-xl shadow-slate-950/[0.08] transition-all duration-500 ease-in-out" :class="focused ? 'scale-[1.015] border-blue-300 shadow-2xl shadow-blue-500/[0.12]' : ''">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                <div class="relative flex min-h-14 flex-1 items-center rounded-[1.25rem] bg-slate-50 px-4 transition duration-300 group-focus-within:bg-white">
                                    <svg class="h-5 w-5 shrink-0 text-slate-400 transition duration-300 group-focus-within:text-[#4285F4]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.35-4.35"/><circle cx="10.5" cy="10.5" r="6.5"/></svg>
                                    <input id="landing-role-search" name="q" x-model="role" @focus="focused = true" @blur="focused = false" type="search" autocomplete="off" placeholder="Search role, skill, or company" class="w-full border-0 bg-transparent px-3 text-sm font-semibold text-slate-900 outline-none ring-0 placeholder:text-slate-400 focus:ring-0 sm:text-base">
                                    <span x-show="role.length > 0" x-transition class="hidden rounded-full bg-blue-50 px-2.5 py-1 text-[0.68rem] font-bold text-blue-700 sm:inline-flex">Smart match</span>
                                </div>
                                <button type="submit" class="group/btn relative min-h-14 overflow-hidden rounded-[1.25rem] bg-slate-950 px-6 text-sm font-extrabold text-white shadow-lg shadow-slate-950/[0.16] transition duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-slate-950/[0.18] sm:px-7">
                                    <span class="absolute inset-0 translate-y-full bg-[#4285F4] transition duration-300 group-hover/btn:translate-y-0"></span>
                                    <span class="relative flex items-center justify-center gap-2">Explore roles <svg class="h-4 w-4 transition duration-300 group-hover/btn:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 5 7 7-7 7"/></svg></span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ Route::has('register') ? route('register') : url('/register') }}" class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-[#4285F4] px-5 py-3.5 text-sm font-extrabold text-white shadow-xl shadow-blue-500/[0.18] transition duration-300 hover:-translate-y-1 hover:scale-[1.015] hover:shadow-2xl hover:shadow-blue-500/[0.24]">
                            Build my career dashboard
                            <svg class="h-4 w-4 transition duration-300 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 5 7 7-7 7"/></svg>
                        </a>
                        <a href="#features" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-extrabold text-slate-800 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/[0.08]">See how it works</a>
                    </div>
                </div>

                <div class="relative lg:pl-8">
                    <div class="slow-drift absolute -right-5 -top-7 h-28 w-28 rounded-[2rem] bg-[#FBBC05]/[0.18] blur-2xl"></div>
                    <div class="relative overflow-hidden rounded-[2.2rem] border border-white bg-slate-950 p-3 shadow-2xl shadow-slate-950/[0.18]">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_25%_15%,rgba(66,133,244,0.22),transparent_34%),radial-gradient(circle_at_80%_65%,rgba(52,168,83,0.16),transparent_30%)]"></div>
                        <div class="relative rounded-[1.7rem] border border-white/10 bg-white/[0.055] p-4 backdrop-blur">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Job radar</p>
                                    <h2 class="mt-2 text-xl font-extrabold tracking-tight text-white">Backend Developer</h2>
                                </div>
                                <span class="rounded-full bg-emerald-400/[0.12] px-3 py-1.5 text-xs font-bold text-emerald-200 ring-1 ring-emerald-300/20">84% fit</span>
                            </div>

                            <div class="mt-6 grid gap-3">
                                <article class="group rounded-[1.35rem] border border-white/10 bg-white/[0.06] p-4 transition duration-300 hover:-translate-y-1 hover:bg-white/[0.09]">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h3 class="text-sm font-bold text-white">Junior Laravel Developer</h3>
                                            <p class="mt-1 text-xs text-slate-400">Remote · Indonesia · Posted 2h ago</p>
                                        </div>
                                        <span class="rounded-full bg-blue-400/[0.12] px-2.5 py-1 text-[0.68rem] font-bold text-blue-200">New</span>
                                    </div>
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <span class="rounded-full bg-white/[0.08] px-2.5 py-1 text-[0.7rem] font-semibold text-slate-300">Laravel</span>
                                        <span class="rounded-full bg-white/[0.08] px-2.5 py-1 text-[0.7rem] font-semibold text-slate-300">MySQL</span>
                                        <span class="rounded-full bg-white/[0.08] px-2.5 py-1 text-[0.7rem] font-semibold text-slate-300">API</span>
                                    </div>
                                </article>

                                <article class="rounded-[1.35rem] border border-white/10 bg-white/[0.045] p-4">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-bold text-white">Application quality</p>
                                        <p class="text-sm font-extrabold text-[#34A853]">+18%</p>
                                    </div>
                                    <div class="mt-3 h-2 rounded-full bg-white/10">
                                        <div class="h-full w-[76%] rounded-full bg-gradient-to-r from-[#4285F4] via-[#34A853] to-[#FBBC05]"></div>
                                    </div>
                                </article>
                            </div>

                            <div class="mt-6 grid grid-cols-3 gap-3">
                                <div class="rounded-[1.25rem] border border-white/10 bg-white/[0.055] p-3">
                                    <p class="text-2xl font-black text-white">42</p>
                                    <p class="mt-1 text-[0.68rem] font-semibold text-slate-400">saved jobs</p>
                                </div>
                                <div class="rounded-[1.25rem] border border-white/10 bg-white/[0.055] p-3">
                                    <p class="text-2xl font-black text-white">9</p>
                                    <p class="mt-1 text-[0.68rem] font-semibold text-slate-400">interviews</p>
                                </div>
                                <div class="rounded-[1.25rem] border border-white/10 bg-white/[0.055] p-3">
                                    <p class="text-2xl font-black text-white">3.1x</p>
                                    <p class="mt-1 text-[0.68rem] font-semibold text-slate-400">response lift</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="features" class="mx-auto max-w-7xl px-5 py-12 sm:px-6 lg:px-8 lg:py-20">
                <div class="grid gap-8 lg:grid-cols-[0.85fr_1.15fr] lg:items-end">
                    <div>
                        <p class="text-sm font-extrabold uppercase tracking-[0.24em] text-[#4285F4]">Designed for momentum</p>
                        <h2 class="font-display mt-3 text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-5xl">Everything important, without the busywork.</h2>
                    </div>
                    <p class="max-w-2xl text-base leading-8 text-slate-600 lg:ml-auto">The interface keeps the serious parts dense and readable, while the interactive pieces help you act faster: optimize, apply, follow up, and measure.</p>
                </div>

                <div class="mt-10 grid gap-4 md:grid-cols-6">
                    <article class="group relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-500/10 md:col-span-3 lg:col-span-2">
                        <div class="absolute inset-x-8 top-0 h-px bg-gradient-to-r from-transparent via-[#4285F4]/60 to-transparent opacity-0 transition duration-500 group-hover:opacity-100"></div>
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-blue-50 text-[#4285F4] ring-1 ring-blue-100">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h8l-1 8 10-12h-8l1-8Z"/></svg>
                        </span>
                        <h3 class="mt-6 text-lg font-extrabold tracking-tight text-slate-950">AI Resume Optimization</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600">Transforms rough work history into targeted, readable resume bullets that match the role without sounding robotic.</p>
                    </article>

                    <article class="group relative overflow-hidden rounded-[2rem] border border-slate-200 bg-slate-950 p-6 shadow-xl shadow-slate-950/[0.12] transition duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-950/20 md:col-span-3 lg:col-span-2">
                        <div class="absolute -right-10 -top-12 h-32 w-32 rounded-full bg-[#34A853]/20 blur-2xl"></div>
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-white/[0.08] text-[#34A853] ring-1 ring-white/10">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        </span>
                        <h3 class="mt-6 text-lg font-extrabold tracking-tight text-white">Application Tracking</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-400">A pipeline built like a compact CRM, so every job has a status, deadline, note, and next action.</p>
                    </article>

                    <article class="group relative overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition duration-500 hover:-translate-y-1 hover:shadow-2xl hover:shadow-yellow-500/10 md:col-span-6 lg:col-span-2">
                        <div class="absolute bottom-0 left-6 right-6 h-px bg-gradient-to-r from-transparent via-[#FBBC05]/80 to-transparent opacity-0 transition duration-500 group-hover:opacity-100"></div>
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-yellow-50 text-[#B77900] ring-1 ring-yellow-100">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </span>
                        <h3 class="mt-6 text-lg font-extrabold tracking-tight text-slate-950">Salary Insights</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600">Understand market ranges and negotiation signals before accepting a role too quickly.</p>
                    </article>
                </div>
            </section>

            <section id="insights" class="mx-auto max-w-7xl px-5 py-10 sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-[2.4rem] bg-slate-950 p-5 shadow-2xl shadow-slate-950/[0.16] sm:p-8 lg:p-10">
                    <div class="grid gap-8 lg:grid-cols-[1fr_1.2fr] lg:items-center">
                        <div>
                            <p class="text-sm font-extrabold uppercase tracking-[0.24em] text-blue-300">Numbers that tell you what to do next</p>
                            <h2 class="font-display mt-4 max-w-xl text-3xl font-black tracking-[-0.04em] text-white sm:text-5xl">Track the funnel, not just the hope.</h2>
                            <p class="mt-5 max-w-xl text-sm leading-7 text-slate-400 sm:text-base">Career Helper turns scattered applications into visible patterns: which role gets replies, which resume version wins, and when you should follow up.</p>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <div class="rounded-[1.7rem] border border-white/10 bg-white/[0.055] p-5">
                                <p class="text-4xl font-black tracking-tight text-white">18k+</p>
                                <p class="mt-2 text-sm font-semibold text-slate-400">active jobs scanned weekly</p>
                            </div>
                            <div class="rounded-[1.7rem] border border-white/10 bg-white/[0.055] p-5 sm:translate-y-7">
                                <p class="text-4xl font-black tracking-tight text-white">7.4k</p>
                                <p class="mt-2 text-sm font-semibold text-slate-400">successful hires tracked</p>
                            </div>
                            <div class="rounded-[1.7rem] border border-white/10 bg-white/[0.055] p-5">
                                <p class="text-4xl font-black tracking-tight text-white">2.8x</p>
                                <p class="mt-2 text-sm font-semibold text-slate-400">average response lift</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="outcomes" class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8 lg:py-24">
                <div class="relative overflow-hidden rounded-[2.4rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-950/[0.08] sm:p-10">
                    <div class="absolute right-8 top-8 hidden h-16 w-16 rounded-3xl bg-[#EA4335]/10 sm:block"></div>
                    <div class="absolute bottom-8 right-24 hidden h-10 w-10 rounded-2xl bg-[#34A853]/[0.12] sm:block"></div>
                    <div class="max-w-2xl">
                        <p class="text-sm font-extrabold uppercase tracking-[0.24em] text-[#EA4335]">Your next move</p>
                        <h2 class="font-display mt-4 text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-5xl">Start with one role. Build the system around it.</h2>
                        <p class="mt-5 text-base leading-8 text-slate-600">Create a career dashboard, add your target role, and let the product surface the gaps, actions, and job opportunities that deserve your attention.</p>
                    </div>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ Route::has('register') ? route('register') : url('/register') }}" class="group inline-flex items-center justify-center rounded-2xl bg-slate-950 px-6 py-4 text-sm font-extrabold text-white shadow-xl shadow-slate-950/[0.14] transition duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-950/[0.18]">
                            Create free account
                            <svg class="ml-2 h-4 w-4 transition duration-300 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 5 7 7-7 7"/></svg>
                        </a>
                        <a href="{{ Route::has('login') ? route('login') : url('/login') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-6 py-4 text-sm font-extrabold text-slate-800 transition duration-300 hover:-translate-y-1 hover:bg-white hover:shadow-xl hover:shadow-slate-950/[0.08]">I already have an account</a>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
