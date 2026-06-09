<x-guest-layout>
    <main
        class="min-h-screen bg-slate-50 px-4 py-10 text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100 sm:px-6 lg:px-8"
        style="color-scheme: light;">
        <section class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-md items-center">
            <div class="w-full rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70 dark:border-white/10 dark:bg-slate-900/85 dark:shadow-black/20 sm:p-8"
                x-data="{ password: '', strength() { let s = 0; if (this.password.length >= 8) s++; if (/[A-Z]/.test(this.password)) s++; if (/[0-9]/.test(this.password)) s++; if (/[^A-Za-z0-9]/.test(this.password)) s++; return s }, width() { return ['w-[18%]', 'w-[38%]', 'w-[62%]', 'w-[82%]', 'w-full'][this.strength()] }, color() { return ['bg-slate-300', 'bg-[#EA4335]', 'bg-[#FBBC05]', 'bg-[#4285F4]', 'bg-[#34A853]'][this.strength()] }, label() { return ['Very weak', 'Weak', 'Fair', 'Good', 'Strong'][this.strength()] } }">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p
                            class="inline-flex rounded-full bg-[#4285F4]/10 px-3 py-1 text-xs font-bold text-[#1a73e8] dark:text-blue-300">
                            Secure reset</p>
                        <h1 class="mt-4 text-3xl font-bold tracking-[-0.04em] text-slate-950 dark:text-white">Create new
                            password</h1>
                    </div>
                    <span
                        class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-950 shadow-xl shadow-slate-950/[0.15] transition duration-300 group-hover:scale-105">
                        <span class="relative h-5 w-5 rounded-md bg-[#4285F4]">
                            <span class="absolute -right-1 -top-1 h-2.5 w-2.5 rounded-full bg-[#EA4335]"></span>
                            <span class="absolute -bottom-1 -left-1 h-2.5 w-2.5 rounded-full bg-[#34A853]"></span>
                            <span class="absolute -bottom-1 -right-1 h-2.5 w-2.5 rounded-full bg-[#FBBC05]"></span>
                        </span>
                    </span>
                </div>
                <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400">Gunakan kombinasi huruf besar,
                    angka, dan simbol agar akun kamu lebih aman.</p>

                <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="relative">
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                            placeholder=" " x-model="password"
                            class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                            style="color-scheme: light;">
                        <label for="password"
                            class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">New
                            password</label>
                        @error('password')
                            <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            autocomplete="new-password" placeholder=" "
                            class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                            style="color-scheme: light;">
                        <label for="password_confirmation"
                            class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">Confirm
                            password</label>
                        @error('password_confirmation')
                            <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full rounded-2xl bg-slate-950 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-slate-950/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#4285F4] dark:bg-white dark:text-slate-950 dark:hover:bg-[#4285F4] dark:hover:text-white">Reset
                        password</button>
                </form>
            </div>
        </section>
    </main>
</x-guest-layout>
