<x-guest-layout>
    <main class="min-h-screen bg-slate-50 px-4 py-10 text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100 sm:px-6 lg:px-8" style="color-scheme: light;">
        <section class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-md items-center">
            <div class="w-full rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70 dark:border-white/10 dark:bg-slate-900/85 dark:shadow-black/20 sm:p-8">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-[1.75rem] bg-slate-950 text-white shadow-lg shadow-slate-950/20 transition-all duration-500 hover:-translate-y-1 hover:rotate-3 dark:bg-white dark:text-slate-950">
                    <svg viewBox="0 0 24 24" fill="none" class="h-10 w-10 animate-pulse">
                        <path d="M7 10V8a5 5 0 0 1 10 0v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M6.8 10h10.4A2.8 2.8 0 0 1 20 12.8v5.4a2.8 2.8 0 0 1-2.8 2.8H6.8A2.8 2.8 0 0 1 4 18.2v-5.4A2.8 2.8 0 0 1 6.8 10Z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M12 15v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </div>

                <div class="mt-6 text-center">
                    <h1 class="text-3xl font-bold tracking-[-0.04em] text-slate-950 dark:text-white">Secure confirmation</h1>
                    <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400">Area ini membutuhkan konfirmasi password sebelum kamu melanjutkan tindakan sensitif.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="mt-8 space-y-5">
                    @csrf
                    <div class="relative">
                        <input id="password" name="password" type="password" required autocomplete="current-password" placeholder=" " class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900" style="color-scheme: light;">
                        <label for="password" class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">Password</label>
                        @error('password')<p class="mt-2 animate-pulse text-xs font-semibold text-[#EA4335]">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="group relative w-full overflow-hidden rounded-2xl bg-slate-950 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-slate-950/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#4285F4] dark:bg-white dark:text-slate-950 dark:hover:bg-[#4285F4] dark:hover:text-white">
                        <span class="absolute inset-y-0 left-0 w-0 bg-white/15 transition-all duration-500 group-hover:w-full"></span>
                        <span class="relative">Confirm password</span>
                    </button>
                </form>
            </div>
        </section>
    </main>
</x-guest-layout>
