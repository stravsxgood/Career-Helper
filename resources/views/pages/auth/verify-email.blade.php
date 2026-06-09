<x-guest-layout>
    <main class="min-h-screen bg-slate-50 px-4 py-10 text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100 sm:px-6 lg:px-8" style="color-scheme: light;">
        <section class="mx-auto flex min-h-[calc(100vh-5rem)] max-w-xl items-center">
            <div class="w-full overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-xl shadow-slate-200/70 dark:border-white/10 dark:bg-slate-900/85 dark:shadow-black/20">
                <div class="relative bg-slate-950 p-8 text-center text-white dark:bg-white dark:text-slate-950">
                    <div class="absolute left-8 top-8 h-16 w-16 rounded-full bg-[#4285F4]/20 blur-2xl"></div>
                    <div class="absolute bottom-6 right-10 h-20 w-20 rounded-full bg-[#34A853]/20 blur-2xl"></div>
                    <div class="relative mx-auto flex h-24 w-24 animate-bounce items-center justify-center rounded-[2rem] bg-white/10 ring-1 ring-white/15 dark:bg-slate-950/10 dark:ring-slate-900/10">
                        <svg viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-[#FBBC05]">
                            <path d="M4 8.2 12 13l8-4.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5.8 6h12.4A2.8 2.8 0 0 1 21 8.8v6.4a2.8 2.8 0 0 1-2.8 2.8H5.8A2.8 2.8 0 0 1 3 15.2V8.8A2.8 2.8 0 0 1 5.8 6Z" stroke="currentColor" stroke-width="1.8"/>
                            <path d="m9.5 12.5 1.7 1.7 3.6-4" stroke="#34A853" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h1 class="relative mt-6 text-3xl font-bold tracking-[-0.04em]">Check your inbox</h1>
                    <p class="relative mt-3 text-sm leading-6 opacity-75">Kami sudah menyiapkan akses akunmu. Satu langkah lagi: verifikasi email.</p>
                </div>

                <div class="p-6 sm:p-8">
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-5 rounded-2xl border border-[#34A853]/20 bg-[#34A853]/10 p-4 text-sm font-semibold text-[#188038] dark:text-green-300">Link verifikasi baru sudah dikirim ke email kamu.</div>
                    @endif

                    <p class="text-sm leading-7 text-slate-600 dark:text-slate-300">Sebelum lanjut memakai Career Helper, klik link verifikasi yang kami kirimkan ke email kamu. Tidak menerima email? Kamu bisa kirim ulang.</p>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full rounded-2xl bg-slate-950 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-slate-950/15 transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#4285F4] dark:bg-white dark:text-slate-950 dark:hover:bg-[#4285F4] dark:hover:text-white sm:w-auto">Resend verification email</button>
                        </form>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-2xl px-5 py-3 text-sm font-bold text-slate-500 transition hover:bg-slate-100 hover:text-[#EA4335] dark:text-slate-400 dark:hover:bg-slate-950">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-guest-layout>
