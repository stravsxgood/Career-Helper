<x-guest-layout>
    <main class="min-h-screen bg-slate-50 px-4 py-10 text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100 sm:px-6 lg:px-8"
        style="color-scheme: light;">
        <section class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-md items-center">
            <div
                class="group w-full rounded-[2rem] border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70 transition duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-slate-200/80 dark:border-white/10 dark:bg-slate-900/85 dark:shadow-black/20 sm:p-8">

                {{-- Header --}}
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p
                            class="inline-flex items-center gap-2 rounded-full bg-[#4285F4]/10 px-3 py-1 text-xs font-black text-[#1a73e8] dark:text-blue-300">
                            <span class="h-2 w-2 rounded-full bg-[#FBBC05]"></span>
                            Verification code
                        </p>

                        <h1 class="mt-4 text-3xl font-black tracking-[-0.045em] text-slate-950 dark:text-white">
                            Masukkan Kode
                        </h1>

                        <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400">
                            Kode reset password telah dikirim ke email akun yang terdaftar. Masukkan 6 digit kode untuk
                            melanjutkan.
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

                {{-- Status --}}
                @if (session('status'))
                    <div
                        class="mt-6 rounded-2xl border border-[#34A853]/25 bg-[#34A853]/10 px-4 py-3 text-sm font-bold leading-6 text-[#188038] dark:border-[#34A853]/30 dark:bg-[#34A853]/10 dark:text-green-300">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Global errors --}}
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

                {{-- Verify form --}}
                <form method="POST" action="{{ route('password.code.verify') }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="code" class="block text-sm font-black text-slate-700 dark:text-slate-200">
                            Reset Password Code
                        </label>

                        <div class="relative mt-2">
                            <input
                                id="code"
                                name="code"
                                type="text"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                maxlength="6"
                                value="{{ old('code') }}"
                                required
                                autofocus
                                autocomplete="one-time-code"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-center text-2xl font-black tracking-[0.45em] text-slate-950 outline-none transition-all duration-300 placeholder:text-slate-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-white/10 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-600 dark:focus:bg-slate-900"
                                placeholder="000000"
                                style="color-scheme: light;"
                            >

                            <div
                                class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-xs font-black text-[#4285F4]">
                                OTP
                            </div>
                        </div>

                        @error('code')
                            <p class="mt-2 text-xs font-black text-[#EA4335]">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Info card --}}
                    <div
                        class="rounded-2xl border border-[#FBBC05]/30 bg-[#FBBC05]/10 px-4 py-3 text-xs font-bold leading-5 text-slate-600 dark:border-[#FBBC05]/20 dark:bg-[#FBBC05]/10 dark:text-slate-300">
                        Kode hanya bisa digunakan untuk satu kali reset password. Jangan bagikan kode ini kepada siapa pun.
                    </div>

                    <button
                        type="submit"
                        class="group/button relative w-full overflow-hidden rounded-2xl bg-slate-950 px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-slate-950/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#4285F4] focus:outline-none focus:ring-4 focus:ring-[#4285F4]/20 active:translate-y-0 dark:bg-white dark:text-slate-950 dark:hover:bg-[#4285F4] dark:hover:text-white">
                        <span class="relative z-10 inline-flex items-center justify-center gap-2">
                            Verifikasi Kode
                            <span class="transition duration-300 group-hover/button:translate-x-1">→</span>
                        </span>

                        <span
                            class="absolute inset-y-0 left-0 w-0 bg-[#4285F4] transition-all duration-300 group-hover/button:w-full"></span>
                    </button>
                </form>

                {{-- Resend form --}}
                <form method="POST" action="{{ route('password.code.resend') }}" class="mt-4">
                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-700 transition-all duration-300 hover:-translate-y-0.5 hover:border-[#34A853]/40 hover:bg-[#34A853]/5 hover:text-[#188038] focus:outline-none focus:ring-4 focus:ring-[#34A853]/10 dark:border-white/10 dark:bg-slate-950 dark:text-slate-200 dark:hover:border-[#34A853]/40 dark:hover:bg-[#34A853]/10 dark:hover:text-green-300">
                        Kirim Ulang Kode
                    </button>
                </form>

                {{-- Footer links --}}
                <div class="mt-5 flex items-center justify-center gap-3 text-center text-sm">
                    <a
                        href="{{ route('password.code.request') }}"
                        class="font-black text-slate-500 transition hover:text-[#4285F4] hover:underline dark:text-slate-400 dark:hover:text-blue-300">
                        Ganti username
                    </a>

                    <span class="h-1 w-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>

                    <a
                        href="{{ route('login') }}"
                        class="font-black text-[#4285F4] transition hover:underline dark:text-blue-300">
                        Kembali ke login
                    </a>
                </div>
            </div>
        </section>
    </main>
</x-guest-layout>
