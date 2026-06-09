<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Career Helper</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
        }

        .font-display {
            font-family: 'Plus Jakarta Sans', Inter, ui-sans-serif, system-ui, sans-serif;
        }

        @keyframes floatCard {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-12px) rotate(1deg);
            }
        }

        @keyframes errorShake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-4px);
            }

            40% {
                transform: translateX(4px);
            }

            60% {
                transform: translateX(-3px);
            }

            80% {
                transform: translateX(3px);
            }
        }

        .float-card {
            animation: floatCard 7s ease-in-out infinite;
        }

        .error-shake {
            animation: errorShake .34s ease-in-out;
        }
    </style>
</head>

<body class="min-h-screen bg-[#F8FAFC] text-slate-950 antialiased selection:bg-blue-200 selection:text-slate-950">
    <main class="grid min-h-screen lg:grid-cols-[1.06fr_0.94fr]">
        <section
            class="relative hidden overflow-hidden bg-slate-950 p-8 text-white lg:flex lg:flex-col lg:justify-between xl:p-12">
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_18%_18%,rgba(66,133,244,0.24),transparent_28%),radial-gradient(circle_at_82%_34%,rgba(52,168,83,0.16),transparent_28%),radial-gradient(circle_at_50%_86%,rgba(251,188,5,0.12),transparent_28%)]">
            </div>
            <div class="absolute left-12 top-32 h-28 w-28 rounded-[2.2rem] bg-[#EA4335]/[0.12] blur-xl"></div>
            <div class="absolute bottom-12 right-12 h-48 w-48 rounded-full bg-[#4285F4]/[0.12] blur-3xl"></div>

            <a href="{{ url('/') }}" class="relative z-10 flex items-center gap-3">
                <span
                    class="grid h-12 w-12 place-items-center rounded-2xl bg-white text-slate-950 shadow-xl shadow-slate-950/30">
                    <span class="relative h-5 w-5 rounded-md bg-[#4285F4]">
                        <span class="absolute -right-1 -top-1 h-2.5 w-2.5 rounded-full bg-[#EA4335]"></span>
                        <span class="absolute -bottom-1 -left-1 h-2.5 w-2.5 rounded-full bg-[#34A853]"></span>
                        <span class="absolute -bottom-1 -right-1 h-2.5 w-2.5 rounded-full bg-[#FBBC05]"></span>
                    </span>
                </span>
                <span>
                    <span class="block font-display text-base font-black tracking-tight">Career Helper</span>
                    <span class="block text-xs font-semibold text-slate-400">Your career command center</span>
                </span>
            </a>

            <div class="relative z-10 mx-auto w-full max-w-xl">
                <div
                    class="float-card overflow-hidden rounded-[2.4rem] border border-white/10 bg-white/[0.065] p-6 shadow-2xl shadow-slate-950/40 backdrop-blur-xl">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-extrabold uppercase tracking-[0.24em] text-blue-200">Today’s career
                                signal</p>
                            <h1
                                class="font-display mt-4 text-4xl font-black leading-tight tracking-[-0.05em] text-white">
                                Better opportunities come from better systems.</h1>
                        </div>
                        <span
                            class="grid h-14 w-14 shrink-0 place-items-center rounded-3xl bg-white text-slate-950 shadow-lg">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 2 3 14h8l-1 8 10-12h-8l1-8Z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-8 grid gap-3 sm:grid-cols-3">
                        <div class="rounded-[1.35rem] border border-white/10 bg-white/[0.055] p-4">
                            <p class="text-2xl font-black">84%</p>
                            <p class="mt-1 text-xs font-semibold text-slate-400">resume score</p>
                        </div>
                        <div class="rounded-[1.35rem] border border-white/10 bg-white/[0.055] p-4">
                            <p class="text-2xl font-black">6</p>
                            <p class="mt-1 text-xs font-semibold text-slate-400">interviews</p>
                        </div>
                        <div class="rounded-[1.35rem] border border-white/10 bg-white/[0.055] p-4">
                            <p class="text-2xl font-black">3.1x</p>
                            <p class="mt-1 text-xs font-semibold text-slate-400">reply lift</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 grid grid-cols-4 gap-3">
                <div class="h-2 rounded-full bg-[#4285F4]"></div>
                <div class="h-2 rounded-full bg-[#EA4335]"></div>
                <div class="h-2 rounded-full bg-[#FBBC05]"></div>
                <div class="h-2 rounded-full bg-[#34A853]"></div>
            </div>
        </section>

        <section class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-10">
            <div class="w-full max-w-md">
                <div class="mb-8 flex items-center justify-between gap-4 lg:hidden">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <span
                            class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-950 text-white shadow-lg shadow-slate-950/[0.15]">CH</span>
                        <span class="font-display text-base font-black tracking-tight">Career Helper</span>
                    </a>
                    <a href="{{ Route::has('register') ? route('register') : url('/register') }}"
                        class="rounded-2xl bg-slate-100 px-4 py-2 text-xs font-extrabold text-slate-700">Register</a>
                </div>

                <div
                    class="rounded-[2.2rem] border border-slate-200 bg-white p-5 shadow-2xl shadow-slate-950/[0.08] sm:p-8">

                    <div class="mt-6 flex justify-end">
                        <a href="{{ url('/') }}" aria-label="Back to Dashboard" title="Back to Dashboard"
                            class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 transition duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:text-[#4285F4] hover:shadow-xl hover:shadow-slate-950/[0.08] dark:border-white/10 dark:bg-slate-900 dark:text-slate-200">

                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                                <path d="M3 10.8 12 3l9 7.8" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />

                                <path d="M5.5 10.5V20h13v-9.5" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />

                                <path d="M9.5 20v-6h5v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                    <p class="text-sm font-extrabold uppercase tracking-[0.24em] text-[#4285F4]">Welcome back</p>
                    <h2 class="font-display mt-3 text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">
                        Sign in to your dashboard</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-500">Continue tracking applications, interviews,
                        resume progress, and recommended roles.</p>
                </div>

                @if ($errors->any())
                    <div
                        class="error-shake mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 shadow-sm shadow-red-500/[0.05]">
                        Please check your email and password, then try again.
                    </div>
                @endif

                <form method="POST" action="{{ Route::has('login') ? route('login') : url('/login') }}"
                    class="mt-7 space-y-5" x-data="{ showPassword: false, remember: {{ old('remember') ? 'true' : 'false' }} }">
                    @csrf

                    <div>
                        <div class="relative">
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                autocomplete="email" required placeholder=" "
                                class="peer h-14 w-full rounded-2xl border bg-white px-4 pt-5 text-sm font-semibold text-slate-950 outline-none transition duration-300 placeholder:text-transparent focus:ring-4 {{ $errors->has('email') ? 'border-red-300 shadow-[0_0_0_4px_rgba(239,68,68,0.08)] focus:border-red-400 focus:ring-red-100' : 'border-slate-200 focus:border-[#4285F4] focus:ring-blue-100' }}">
                            <label for="email"
                                class="pointer-events-none absolute left-4 top-2 text-[0.72rem] font-bold uppercase tracking-[0.16em] text-slate-400 transition-all duration-300 peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-placeholder-shown:text-slate-500 peer-focus:top-2 peer-focus:text-[0.72rem] peer-focus:font-bold peer-focus:uppercase peer-focus:tracking-[0.16em] peer-focus:text-[#4285F4]">Email
                                address</label>
                        </div>
                        @error('email')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="relative">
                            <input id="password" name="password" :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password" required placeholder=" "
                                class="peer h-14 w-full rounded-2xl border bg-white px-4 pr-12 pt-5 text-sm font-semibold text-slate-950 outline-none transition duration-300 placeholder:text-transparent focus:ring-4 {{ $errors->has('password') ? 'border-red-300 shadow-[0_0_0_4px_rgba(239,68,68,0.08)] focus:border-red-400 focus:ring-red-100' : 'border-slate-200 focus:border-[#4285F4] focus:ring-blue-100' }}">
                            <label for="password"
                                class="pointer-events-none absolute left-4 top-2 text-[0.72rem] font-bold uppercase tracking-[0.16em] text-slate-400 transition-all duration-300 peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-placeholder-shown:text-slate-500 peer-focus:top-2 peer-focus:text-[0.72rem] peer-focus:font-bold peer-focus:uppercase peer-focus:tracking-[0.16em] peer-focus:text-[#4285F4]">Password</label>
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 grid h-9 w-9 -translate-y-1/2 place-items-center rounded-xl text-slate-400 transition hover:bg-slate-100 hover:text-slate-900">
                                <svg x-show="!showPassword" class="h-[1.125rem] w-[1.125rem]" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12s-3.5 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg x-show="showPassword" x-cloak class="h-[1.125rem] w-[1.125rem]"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m3 3 18 18" />
                                    <path
                                        d="M10.73 5.08A10.7 10.7 0 0 1 12 5c6.25 0 9.75 7 9.75 7a18.2 18.2 0 0 1-2.3 3.24" />
                                    <path
                                        d="M6.61 6.61C3.78 8.53 2.25 12 2.25 12S5.75 19 12 19a10.6 10.6 0 0 0 4.39-.92" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <label
                            class="group flex cursor-pointer items-center gap-3 text-sm font-semibold text-slate-600">
                            <input type="checkbox" name="remember" value="1" x-model="remember"
                                class="sr-only">
                            <span class="grid h-5 w-5 place-items-center rounded-md border transition duration-300"
                                :class="remember ?
                                    'border-[#4285F4] bg-[#4285F4] text-white shadow-[0_0_0_4px_rgba(66,133,244,0.12)]' :
                                    'border-slate-300 bg-white text-transparent group-hover:border-slate-400'">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m20 6-11 11-5-5" />
                                </svg>
                            </span>
                            {{ __('Remember me') }}
                        </label>
                        <a href="{{ url('/forgot-password') }}"
                            class="text-sm font-extrabold text-[#4285F4] transition hover:text-blue-700">Forgot
                            password?</a>
                    </div>

                    <div class="space-y-3 pt-1">
                        <button type="submit"
                            class="group relative min-h-[3.25rem] w-full overflow-hidden rounded-2xl bg-slate-950 px-4 py-3.5 text-sm font-extrabold text-white shadow-xl shadow-slate-950/[0.14] transition duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-slate-950/[0.18]">
                            <span
                                class="absolute inset-0 translate-y-full bg-[#4285F4] transition duration-300 group-hover:translate-y-0"></span>
                            <span class="relative flex items-center justify-center gap-2">Sign in with email <svg
                                    class="h-4 w-4 transition duration-300 group-hover:translate-x-0.5"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="m13 5 7 7-7 7" />
                                </svg></span>
                        </button>
                    </div>
                </form>

                <p class="mt-7 text-center text-sm font-semibold text-slate-500">
                    New to Career Helper?
                    <a href="{{ Route::has('register') ? route('register') : url('/register') }}"
                        class="font-extrabold text-slate-950 transition hover:text-[#4285F4]">Create an account</a>
                </p>
            </div>
            </div>
        </section>
    </main>
</body>

</html>
