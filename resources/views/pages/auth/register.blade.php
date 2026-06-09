<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register — Career Helper</title>
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

        @keyframes orbitSoft {
            0% {
                transform: rotate(0deg) translateX(8px) rotate(0deg);
            }

            100% {
                transform: rotate(360deg) translateX(8px) rotate(-360deg);
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

        .orbit-soft {
            animation: orbitSoft 12s linear infinite;
        }

        .error-shake {
            animation: errorShake .34s ease-in-out;
        }
    </style>
</head>

<body class="min-h-screen bg-[#F8FAFC] text-slate-950 antialiased selection:bg-blue-200 selection:text-slate-950">
    <main class="relative min-h-screen overflow-hidden">
        <div
            class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_15%_20%,rgba(66,133,244,0.16),transparent_28%),radial-gradient(circle_at_88%_18%,rgba(52,168,83,0.12),transparent_26%),linear-gradient(135deg,#f8fafc_0%,#eef4ff_48%,#f8fafc_100%)]">
        </div>
        <div class="absolute left-8 top-24 -z-10 h-40 w-40 rounded-full bg-[#FBBC05]/[0.12] blur-3xl"></div>
        <div class="absolute bottom-12 right-8 -z-10 h-52 w-52 rounded-full bg-slate-950/5 blur-3xl"></div>

        <section
            class="mx-auto grid min-h-screen max-w-7xl items-center gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8 lg:py-10">
            <aside class="hidden lg:block">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <span
                        class="grid h-12 w-12 place-items-center rounded-2xl bg-slate-950 shadow-xl shadow-slate-950/[0.15]">
                        <span class="relative h-5 w-5 rounded-md bg-[#4285F4]">
                            <span class="absolute -right-1 -top-1 h-2.5 w-2.5 rounded-full bg-[#EA4335]"></span>
                            <span class="absolute -bottom-1 -left-1 h-2.5 w-2.5 rounded-full bg-[#34A853]"></span>
                            <span class="absolute -bottom-1 -right-1 h-2.5 w-2.5 rounded-full bg-[#FBBC05]"></span>
                        </span>
                    </span>
                    <span>
                        <span class="block font-display text-base font-black tracking-tight text-slate-950">Career
                            Helper</span>
                        <span class="block text-xs font-semibold text-slate-500">Plan. Apply. Improve.</span>
                    </span>
                </a>

                <div class="mt-16 max-w-xl">
                    <p class="text-sm font-extrabold uppercase tracking-[0.24em] text-[#34A853]">Build your career
                        cockpit</p>
                    <h1
                        class="font-display mt-4 text-5xl font-black leading-[0.96] tracking-[-0.06em] text-slate-950 xl:text-6xl">
                        Start with a target role, then let the system sharpen the path.</h1>
                    <p class="mt-6 max-w-lg text-base leading-8 text-slate-600">Career Helper works like a navigation
                        map for job hunting: it does not drive for you, but it keeps the route, signals, and next turns
                        visible.</p>
                </div>

                <div
                    class="relative mt-12 max-w-lg rounded-[2.2rem] bg-slate-950 p-5 text-white shadow-2xl shadow-slate-950/[0.16]">
                    <div
                        class="absolute -right-5 -top-5 grid h-16 w-16 place-items-center rounded-[1.5rem] bg-white text-slate-950 shadow-xl orbit-soft">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v20" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-[1.45rem] border border-white/10 bg-white/[0.06] p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-500">Step 01</p>
                            <p class="mt-2 text-sm font-bold text-white">Define desired role</p>
                        </div>
                        <div class="rounded-[1.45rem] border border-white/10 bg-white/[0.06] p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-500">Step 02</p>
                            <p class="mt-2 text-sm font-bold text-white">Map your resume gap</p>
                        </div>
                        <div class="rounded-[1.45rem] border border-white/10 bg-white/[0.06] p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-500">Step 03</p>
                            <p class="mt-2 text-sm font-bold text-white">Track every application</p>
                        </div>
                        <div class="rounded-[1.45rem] border border-white/10 bg-white/[0.06] p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-500">Step 04</p>
                            <p class="mt-2 text-sm font-bold text-white">Improve weekly</p>
                        </div>
                    </div>
                </div>
            </aside>

            <section class="mx-auto w-full max-w-2xl">
                <div class="mb-7 flex items-center justify-between gap-4 lg:hidden">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <span
                            class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-950 text-white shadow-lg shadow-slate-950/[0.15]">CH</span>
                        <span class="font-display text-base font-black tracking-tight">Career Helper</span>
                    </a>
                    <a href="{{ Route::has('login') ? route('login') : url('/login') }}"
                        class="rounded-2xl bg-slate-100 px-4 py-2 text-xs font-extrabold text-slate-700">Login</a>
                </div>

                <div
                    class="rounded-[2.35rem] border border-slate-200 bg-white p-5 shadow-2xl shadow-slate-950/[0.08] sm:p-8 lg:p-10">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-sm font-extrabold uppercase tracking-[0.24em] text-[#4285F4]">Create account
                            </p>
                            <h2
                                class="font-display mt-3 text-3xl font-black tracking-[-0.04em] text-slate-950 sm:text-4xl">
                                Set up your career system</h2>
                            <p class="mt-3 max-w-xl text-sm leading-6 text-slate-500">A few details are enough to
                                personalize job recommendations, resume feedback, and application tracking.</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3 text-right ring-1 ring-slate-200">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Progress</p>
                            <p class="mt-1 text-sm font-black text-slate-950">1 of 1</p>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div
                            class="error-shake mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 shadow-sm shadow-red-500/[0.05]">
                            Some information needs attention before your account can be created.
                        </div>
                    @endif

                    <form method="POST" action="{{ Route::has('register') ? route('register') : url('/register') }}"
                        class="mt-8" x-data="{
                            password: '',
                            terms: false,
                            strength() {
                                let score = 0;
                                if (this.password.length >= 8) score++;
                                if (/[A-Z]/.test(this.password)) score++;
                                if (/[0-9]/.test(this.password)) score++;
                                if (/[^A-Za-z0-9]/.test(this.password)) score++;
                                if (this.password.length === 0) return { percent: 8, label: 'Start typing', bar: 'bg-slate-300', text: 'text-slate-500' };
                                if (score <= 1) return { percent: 28, label: 'Weak', bar: 'bg-[#EA4335]', text: 'text-red-600' };
                                if (score === 2) return { percent: 52, label: 'Fair', bar: 'bg-[#FBBC05]', text: 'text-yellow-700' };
                                if (score === 3) return { percent: 76, label: 'Good', bar: 'bg-[#4285F4]', text: 'text-blue-700' };
                                return { percent: 100, label: 'Strong', bar: 'bg-[#34A853]', text: 'text-emerald-700' };
                            }
                        }">
                        @csrf

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <div class="relative">
                                    <input id="name" name="name" type="text" value="{{ old('name') }}"
                                        autocomplete="name" required placeholder=" " style="color-scheme: light;"
                                        class="peer h-14 w-full rounded-2xl border bg-white px-4 pt-5 text-sm font-semibold text-slate-950 outline-none transition duration-300 placeholder:text-transparent focus:ring-4 {{ $errors->has('name') ? 'border-red-300 shadow-[0_0_0_4px_rgba(239,68,68,0.08)] focus:border-red-400 focus:ring-red-100' : 'border-slate-200 focus:border-[#4285F4] focus:ring-blue-100' }}">

                                    <label for="name"
                                        class="pointer-events-none absolute left-4 top-2 text-[0.72rem] font-bold uppercase tracking-[0.16em] text-slate-400 transition-all duration-300 peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-placeholder-shown:text-slate-500 peer-focus:top-2 peer-focus:text-[0.72rem] peer-focus:font-bold peer-focus:uppercase peer-focus:tracking-[0.16em] peer-focus:text-[#4285F4]">Full
                                        name</label>
                                </div>
                                @error('username')
                                    <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <div class="relative">
                                    <input id="username" name="username" type="text" value="{{ old('username') }}"
                                        autocomplete="username" required placeholder=" " style="color-scheme: light;"
                                        class="peer h-14 w-full rounded-2xl border bg-white px-4 pt-5 text-sm font-semibold text-slate-950 outline-none transition duration-300 placeholder:text-transparent focus:ring-4 {{ $errors->has('username') ? 'border-red-300 shadow-[0_0_0_4px_rgba(239,68,68,0.08)] focus:border-red-400 focus:ring-red-100' : 'border-slate-200 focus:border-[#4285F4] focus:ring-blue-100' }}">

                                    <label for="username"
                                        class="pointer-events-none absolute left-4 top-2 text-[0.72rem] font-bold uppercase tracking-[0.16em] text-slate-400 transition-all duration-300 peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-placeholder-shown:text-slate-500 peer-focus:top-2 peer-focus:text-[0.72rem] peer-focus:font-bold peer-focus:uppercase peer-focus:tracking-[0.16em] peer-focus:text-[#4285F4]">username</label>
                                </div>
                                @error('username')
                                    <p class="mt-2 text-xs font-bold text-[#EA4335]">{{ $message }}</p>
                                @enderror
                            </div>

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
                                    <input id="password" name="password" x-model="password" type="password"
                                        autocomplete="new-password" required placeholder=" "
                                        class="peer h-14 w-full rounded-2xl border bg-white px-4 pt-5 text-sm font-semibold text-slate-950 outline-none transition duration-300 placeholder:text-transparent focus:ring-4 {{ $errors->has('password') ? 'border-red-300 shadow-[0_0_0_4px_rgba(239,68,68,0.08)] focus:border-red-400 focus:ring-red-100' : 'border-slate-200 focus:border-[#4285F4] focus:ring-blue-100' }}">
                                    <label for="password"
                                        class="pointer-events-none absolute left-4 top-2 text-[0.72rem] font-bold uppercase tracking-[0.16em] text-slate-400 transition-all duration-300 peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-placeholder-shown:text-slate-500 peer-focus:top-2 peer-focus:text-[0.72rem] peer-focus:font-bold peer-focus:uppercase peer-focus:tracking-[0.16em] peer-focus:text-[#4285F4]">Password</label>
                                </div>
                                <div class="mt-3">
                                    <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-full rounded-full transition-all duration-500 ease-in-out"
                                            :class="strength().bar" :style="`width: ${strength().percent}%`"></div>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <div class="relative">
                                    <input id="password_confirmation" name="password_confirmation"
                                        x-model="passwordConfirmation" type="password" autocomplete="new-password"
                                        required placeholder=" "
                                        class="peer h-14 w-full rounded-2xl border bg-white px-4 pt-5 text-sm font-semibold text-slate-950 outline-none transition duration-300 placeholder:text-transparent focus:ring-4 {{ $errors->has('password_confirmation') ? 'border-red-300 shadow-[0_0_0_4px_rgba(239,68,68,0.08)] focus:border-red-400 focus:ring-red-100' : 'border-slate-200 focus:border-[#4285F4] focus:ring-blue-100' }}">

                                    <label for="password_confirmation"
                                        class="pointer-events-none absolute left-4 top-2 text-[0.72rem] font-bold uppercase tracking-[0.16em] text-slate-400 transition-all duration-300 peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:normal-case peer-placeholder-shown:tracking-normal peer-placeholder-shown:text-slate-500 peer-focus:top-2 peer-focus:text-[0.72rem] peer-focus:font-bold peer-focus:uppercase peer-focus:tracking-[0.16em] peer-focus:text-[#4285F4]">
                                        Confirm Password
                                    </label>
                                </div>

                                @error('password_confirmation')
                                    <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <label
                            class="group mt-6 flex cursor-pointer items-start gap-3 rounded-[1.35rem] border border-slate-200 bg-slate-50 p-4 transition duration-300 hover:border-slate-300 hover:bg-white">
                            <input type="checkbox" name="terms" value="1" x-model="terms" required
                                class="sr-only">
                            <span
                                class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-lg border transition duration-300"
                                :class="terms ?
                                    'scale-105 border-[#34A853] bg-[#34A853] text-white shadow-[0_0_0_5px_rgba(52,168,83,0.13)]' :
                                    'border-slate-300 bg-white text-transparent group-hover:border-slate-400'">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m20 6-11 11-5-5" />
                                </svg>
                            </span>
                            <span class="text-sm leading-6 text-slate-600">
                                <span class="font-extrabold text-slate-950">I agree to the Terms & Conditions</span>
                                and allow Career Helper to personalize my dashboard using the role preferences I
                                provide.
                            </span>
                        </label>
                        @error('terms')
                            <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ url('/login') }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-extrabold text-slate-700 transition duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/[0.08]">Back
                                to login</a>
                            <button type="submit"
                                class="group relative inline-flex min-h-[3.25rem] items-center justify-center overflow-hidden rounded-2xl bg-slate-950 px-6 py-3.5 text-sm font-extrabold text-white shadow-xl shadow-slate-950/[0.14] transition duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-slate-950/[0.18]">
                                <span
                                    class="absolute inset-0 translate-y-full bg-[#4285F4] transition duration-300 group-hover:translate-y-0"></span>
                                <span class="relative flex items-center gap-2">Create account <svg
                                        class="h-4 w-4 transition duration-300 group-hover:translate-x-0.5"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14" />
                                        <path d="m13 5 7 7-7 7" />
                                    </svg></span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </main>
</body>

</html>
