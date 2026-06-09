<x-guest-layout>
    <main
        class="min-h-screen bg-slate-50 px-4 py-10 text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100 sm:px-6 lg:px-8"
        style="color-scheme: light;">
        <section class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-5xl items-center">
            <div
                class="grid w-full overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-200/70 dark:border-white/10 dark:bg-slate-900/85 dark:shadow-black/20 lg:grid-cols-[0.9fr_1.1fr]">
                <aside
                    class="relative hidden overflow-hidden bg-slate-950 p-8 text-white dark:bg-white dark:text-slate-950 lg:block">
                    <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#4285F4]/20 blur-3xl"></div>
                    <div class="absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-[#34A853]/20 blur-3xl"></div>
                    <div class="relative flex h-full flex-col justify-between">
                        <div>
                            <div
                                class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/15 dark:bg-slate-950/10 dark:ring-slate-900/10">
                                <svg viewBox="0 0 24 24" fill="none" class="h-8 w-8 text-[#FBBC05]">
                                    <path d="M4 7.8 12 13l8-5.2" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M5.8 5h12.4A2.8 2.8 0 0 1 21 7.8v8.4a2.8 2.8 0 0 1-2.8 2.8H5.8A2.8 2.8 0 0 1 3 16.2V7.8A2.8 2.8 0 0 1 5.8 5Z"
                                        stroke="currentColor" stroke-width="1.8" />
                                    <path d="m4 18 5.3-5.3M20 18l-5.3-5.3" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                            <h2 class="mt-8 text-4xl font-black tracking-[-0.05em]">Lost password, not progress.</h2>
                            <p class="mt-4 text-sm leading-7 opacity-70">Kami akan mengirimkan link reset password yang
                                aman ke email akun kamu.</p>
                        </div>
                        <div
                            class="grid grid-cols-3 gap-2 rounded-3xl bg-white/10 p-2 ring-1 ring-white/10 dark:bg-slate-950/10 dark:ring-slate-900/10">
                            <div class="rounded-2xl bg-white/10 p-3 text-center dark:bg-white/40">
                                <p class="font-black">1</p>
                                <p class="text-[11px] opacity-70">Email</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-3 text-center dark:bg-white/40">
                                <p class="font-black">2</p>
                                <p class="text-[11px] opacity-70">Verify</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-3 text-center dark:bg-white/40">
                                <p class="font-black">3</p>
                                <p class="text-[11px] opacity-70">Reset</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <article class="p-6 sm:p-8 lg:p-10">
                    <div class="mx-auto max-w-md">
                        <div
                            class="mx-auto flex h-20 w-20 items-center justify-center rounded-[1.75rem] bg-[#4285F4]/10 text-[#4285F4] lg:hidden">
                            <svg viewBox="0 0 24 24" fill="none" class="h-10 w-10">
                                <path d="M4 7.8 12 13l8-5.2" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M5.8 5h12.4A2.8 2.8 0 0 1 21 7.8v8.4a2.8 2.8 0 0 1-2.8 2.8H5.8A2.8 2.8 0 0 1 3 16.2V7.8A2.8 2.8 0 0 1 5.8 5Z"
                                    stroke="currentColor" stroke-width="1.8" />
                            </svg>
                        </div>
                        <h1 class="mt-6 text-3xl font-bold tracking-[-0.04em] text-slate-950 dark:text-white">Forgot
                            password?</h1>
                        <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400">Masukkan email akun kamu.
                            Kami akan mengirim link untuk membuat password baru.</p>

                        @if (session('status'))
                            <div
                                class="mt-5 rounded-2xl border border-[#34A853]/20 bg-[#34A853]/10 p-4 text-sm font-semibold text-[#188038] dark:text-green-300">
                                {{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5"
                            x-data="{ loading: false }" @submit="loading = true">
                            @csrf
                            <div class="relative">
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                    autofocus autocomplete="username" placeholder=" "
                                    class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                                    style="color-scheme: light;">
                                <label for="email"
                                    class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">Email
                                    address</label>
                                @error('email')
                                    <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-3 rounded-2xl bg-slate-950 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-slate-950/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#4285F4] dark:bg-white dark:text-slate-950 dark:hover:bg-[#4285F4] dark:hover:text-white"
                                :disabled="loading">
                                <svg x-show="loading" x-cloak class="h-5 w-5 animate-spin" viewBox="0 0 24 24"
                                    fill="none">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"></path>
                                </svg>
                                <span
                                    x-text="loading ? 'Sending secure link...' : 'Email password reset link'">{{ __('Forgot Password') }}</span>
                            </button>

                            <div class="mt-5 text-center">
                                <a href="{{ route('password.code.request') }}"
                                    class="text-sm font-bold text-[#4285F4] hover:underline">
                                    {{ __('Reset menggunakan username') }}
                                </a>
                            </div>

                            <a href="{{ url('/login') }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-extrabold text-slate-700 transition duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/[0.08]">Back
                                to login</a>
                        </form>
                    </div>
                </article>
            </div>
        </section>
    </main>
</x-guest-layout>
