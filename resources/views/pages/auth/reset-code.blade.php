<x-guest-layout>
    <main class="min-h-screen bg-slate-50 px-4 py-10 text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100 sm:px-6 lg:px-8"
        style="color-scheme: light;">
        <section class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-md items-center">
            <div
                class="group w-full rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70 transition duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-slate-200/80 dark:border-white/10 dark:bg-slate-900/85 dark:shadow-black/20 sm:p-8"
                x-data="{
                    password: '',
                    strength() {
                        let s = 0;
                        if (this.password.length >= 8) s++;
                        if (/[A-Z]/.test(this.password)) s++;
                        if (/[0-9]/.test(this.password)) s++;
                        if (/[^A-Za-z0-9]/.test(this.password)) s++;
                        return s;
                    },
                    width() {
                        return ['w-[18%]', 'w-[38%]', 'w-[62%]', 'w-[82%]', 'w-full'][this.strength()];
                    },
                    color() {
                        return ['bg-slate-300', 'bg-[#EA4335]', 'bg-[#FBBC05]', 'bg-[#4285F4]', 'bg-[#34A853]'][this.strength()];
                    },
                    label() {
                        return ['Very weak', 'Weak', 'Fair', 'Good', 'Strong'][this.strength()];
                    }
                }">

                {{-- Header --}}
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p
                            class="inline-flex items-center gap-2 rounded-full bg-[#4285F4]/10 px-3 py-1 text-xs font-black text-[#1a73e8] dark:text-blue-300">
                            <span class="h-2 w-2 rounded-full bg-[#34A853]"></span>
                            Secure reset
                        </p>

                        <h1 class="mt-4 text-3xl font-black tracking-[-0.045em] text-slate-950 dark:text-white">
                            Buat Password Baru
                        </h1>

                        <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400">
                            Masukkan password baru untuk akunmu. Gunakan kombinasi huruf besar, angka, dan simbol agar
                            akun lebih aman.
                        </p>
                    </div>

                    {{-- Google-style icon --}}
                    <div
                        class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-slate-950 shadow-lg shadow-slate-950/15 transition duration-300 group-hover:scale-105 dark:bg-white">
                        <div class="relative h-6 w-6 rounded-lg bg-[#4285F4]">
                            <span class="absolute -right-1 -top-1 h-3 w-3 rounded-full bg-[#EA4335]"></span>
                            <span class="absolute -bottom-1 -left-1 h-3 w-3 rounded-full bg-[#34A853]"></span>
                            <span class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full bg-[#FBBC05]"></span>
                        </div>
                    </div>
                </div>

                {{-- Error box --}}
                @if ($errors->any())
                    <div
                        class="mt-6 rounded-2xl border border-[#EA4335]/25 bg-[#EA4335]/10 px-4 py-3 text-sm font-bold leading-6 text-[#EA4335] dark:border-[#EA4335]/30 dark:bg-[#EA4335]/10">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('password.code.update') }}" class="mt-6 space-y-5">
                    @csrf

                    {{-- New password --}}
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder=" "
                            x-model="password"
                            class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-950 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                            style="color-scheme: light;"
                        >

                        <label
                            for="password"
                            class="pointer-events-none absolute left-4 top-2 text-xs font-black text-slate-400 transition-all duration-300 peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:font-bold peer-focus:top-2 peer-focus:text-xs peer-focus:font-black peer-focus:text-[#4285F4]">
                            New Password
                        </label>

                        @error('password')
                            <p class="mt-2 text-xs font-black text-[#EA4335]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                        <p class="mt-3 text-xs font-semibold leading-5 text-slate-400">
                            Minimal 8 karakter. Lebih baik jika memakai huruf besar, angka, dan simbol.
                        </p>

                    {{-- Confirm password --}}
                    <div class="relative">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder=" "
                            class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-950 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:focus:bg-slate-900"
                            style="color-scheme: light;"
                        >

                        <label
                            for="password_confirmation"
                            class="pointer-events-none absolute left-4 top-2 text-xs font-black text-slate-400 transition-all duration-300 peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:font-bold peer-focus:top-2 peer-focus:text-xs peer-focus:font-black peer-focus:text-[#4285F4]">
                            Confirm Password
                        </label>

                        @error('password_confirmation')
                            <p class="mt-2 text-xs font-black text-[#EA4335]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Info card --}}
                    <div
                        class="rounded-2xl border border-[#FBBC05]/30 bg-[#FBBC05]/10 px-4 py-3 text-xs font-bold leading-5 text-slate-600 dark:border-[#FBBC05]/20 dark:bg-[#FBBC05]/10 dark:text-slate-300">
                        Setelah password berhasil direset, kode reset akan otomatis dihapus dan kamu akan diarahkan ke
                        halaman login.
                    </div>

                    <button
                        type="submit"
                        class="group/button relative w-full overflow-hidden rounded-2xl bg-slate-950 px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-slate-950/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#4285F4] focus:outline-none focus:ring-4 focus:ring-[#4285F4]/20 active:translate-y-0 dark:bg-white dark:text-slate-950 dark:hover:bg-[#4285F4] dark:hover:text-white">
                        <span class="relative z-10 inline-flex items-center justify-center gap-2">
                            Reset Password
                            <span class="transition duration-300 group-hover/button:translate-x-1">→</span>
                        </span>

                        <span
                            class="absolute inset-y-0 left-0 w-0 bg-[#4285F4] transition-all duration-300 group-hover/button:w-full"></span>
                    </button>

                    <p class="text-center text-xs font-semibold leading-5 text-slate-400">
                        Ingin mulai ulang?
                        <a href="{{ route('password.code.request') }}" class="font-black text-[#4285F4] hover:underline">
                            Ganti username
                        </a>
                    </p>
                </form>
            </div>
        </section>
    </main>
</x-guest-layout>
