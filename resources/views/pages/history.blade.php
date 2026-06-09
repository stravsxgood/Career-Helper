<x-app-layout>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
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

        @keyframes subtleFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .subtle-float {
            animation: subtleFloat 6s ease-in-out infinite;
        }
    </style>

    <main class="min-h-screen bg-slate-50 text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100">
        @include('layouts.app.sidebar')
        
        <section class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div>
                    <h1 class="mt-4 text-3xl font-black tracking-[-0.04em] text-slate-950 dark:text-white">
                        History Analisis
                    </h1>

                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                        Semua hasil analisis karier yang pernah kamu generate tersimpan di sini.
                    </p>
                </div>

                <a href="{{ route('analysis') }}"
                    class="rounded-2xl bg-[#4285F4] px-5 py-3 text-sm font-black text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-600">
                    Analisis Baru
                </a>
            </div>

            @if ($analyses->isEmpty())
                <div
                    class="rounded-[2rem] border border-dashed border-slate-300 bg-white p-10 text-center shadow-sm dark:border-white/10 dark:bg-slate-900">
                    <h2 class="text-xl font-black text-slate-950 dark:text-white">
                        Belum ada history
                    </h2>

                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                        Setelah kamu generate analisis karier, hasilnya akan muncul di sini.
                    </p>

                    <a href="{{ route('analysis') }}"
                        class="mt-6 inline-flex rounded-2xl bg-slate-950 px-5 py-3 text-sm font-black text-white transition hover:bg-[#4285F4] dark:bg-white dark:text-slate-950">
                        Mulai Analisis
                    </a>
                </div>
            @else
                <div class="grid gap-4">

                    @if (session('status'))
                        <div
                            class="mb-6 rounded-2xl border border-[#34A853]/25 bg-[#34A853]/10 px-4 py-3 text-sm font-bold text-[#188038] dark:border-[#34A853]/30 dark:bg-[#34A853]/10 dark:text-green-300">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach ($analyses as $analysis)
                        <article
                            class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-slate-900">
                            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span
                                            class="rounded-full bg-[#4285F4]/10 px-3 py-1 text-xs font-black text-[#1a73e8]">
                                            {{ $analysis->target_role ?? 'Target role' }}
                                        </span>

                                        <span
                                            class="rounded-full bg-[#34A853]/10 px-3 py-1 text-xs font-black text-[#188038]">
                                            {{ $analysis->work_preference ?? 'Preference' }}
                                        </span>
                                    </div>

                                    <h2 class="mt-4 text-lg font-black text-slate-950 dark:text-white">
                                        {{ $analysis->career_interest ?? 'Career Analysis' }}
                                    </h2>

                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        Dibuat pada
                                        {{ $analysis->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('result', $analysis->id) }}"
                                        class="rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-black text-slate-700 transition hover:border-[#4285F4] hover:text-[#4285F4] dark:border-white/10 dark:text-slate-200">
                                        Lihat Detail
                                    </a>

                                    <form method="POST" action="{{ route('history.destroy', $analysis->id) }}"
                                        class="js-delete-history-form"
                                        data-title="{{ $analysis->target_role ?? 'Career Analysis' }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="rounded-2xl border border-[#EA4335]/25 bg-[#EA4335]/10 px-4 py-2.5 text-sm font-black text-[#EA4335] transition hover:bg-[#EA4335] hover:text-white">
                                            Sampah
                                        </button>
                                    </form>

                                    <a href="{{ route('result.pdf', $analysis->id) }}"
                                        class="js-download-pdf-link rounded-2xl bg-slate-950 px-5 py-3 text-sm font-black text-white transition hover:bg-[#4285F4]"
                                        data-title="{{ data_get($analysis, 'recommended_roles.0.role', 'Career Analysis') }}">
                                        Unduh PDF
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $analyses->links() }}
                </div>
            @endif
        </section>
    </main>


    @once
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                /*
                |--------------------------------------------------------------------------
                | Trash / Soft Delete Confirm
                |--------------------------------------------------------------------------
                */
                document.querySelectorAll('.js-delete-history-form').forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();

                        const title = form.dataset.title || 'history analisis ini';

                        Swal.fire({
                            title: 'Pindahkan ke Sampah?',
                            text: `Data akan dipindahkan ke Sampah dan masih bisa direstore.`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, pindahkan',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            focusCancel: true,
                            buttonsStyling: false,
                            customClass: {
                                popup: 'rounded-[2rem]',
                                title: 'text-slate-950 font-black',
                                htmlContainer: 'text-slate-500 text-sm',
                                confirmButton: 'rounded-2xl bg-[#EA4335] px-5 py-3 text-sm font-black text-white transition hover:bg-red-600',
                                cancelButton: 'mr-3 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-700 transition hover:border-[#4285F4] hover:text-[#4285F4]',
                            },
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });

                /*
                |--------------------------------------------------------------------------
                | Download PDF
                |--------------------------------------------------------------------------
                | Alert "Menyiapkan PDF..." akan terus muncul sampai file PDF selesai
                | diterima browser. Setelah itu download dimulai dan muncul alert sukses.
                |--------------------------------------------------------------------------
                */
                document.querySelectorAll('.js-download-pdf-link').forEach(function(link) {
                    link.addEventListener('click', async function(event) {
                        event.preventDefault();

                        const url = link.href;
                        const title = link.dataset.title || 'Career Analysis';

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: 'Menyiapkan PDF...',
                            text: `Report "${title}" sedang dibuat. Mohon tunggu.`,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            timerProgressBar: false,
                            background: '#ffffff',
                            color: '#0f172a',
                            didOpen: function() {
                                Swal.showLoading();
                            },
                            customClass: {
                                popup: 'rounded-2xl border border-slate-200 shadow-xl shadow-slate-200/70',
                                title: 'text-sm font-black text-slate-950',
                                htmlContainer: 'text-xs font-semibold text-slate-500',
                            },
                        });

                        try {
                            const response = await fetch(url, {
                                method: 'GET',
                                credentials: 'same-origin',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/pdf',
                                },
                            });

                            if (!response.ok) {
                                throw new Error('Gagal membuat PDF.');
                            }

                            const blob = await response.blob();

                            if (!blob || blob.size === 0) {
                                throw new Error('File PDF kosong.');
                            }

                            let filename = 'career-analysis-report.pdf';
                            const disposition = response.headers.get('Content-Disposition');

                            if (disposition) {
                                const filenameMatch = disposition.match(/filename="?([^"]+)"?/);

                                if (filenameMatch && filenameMatch[1]) {
                                    filename = filenameMatch[1].trim();
                                }
                            }

                            const downloadUrl = window.URL.createObjectURL(blob);

                            const temporaryLink = document.createElement('a');
                            temporaryLink.href = downloadUrl;
                            temporaryLink.download = filename;
                            document.body.appendChild(temporaryLink);
                            temporaryLink.click();
                            temporaryLink.remove();

                            setTimeout(function() {
                                window.URL.revokeObjectURL(downloadUrl);
                            }, 1000);

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'PDF berhasil dimuat',
                                text: `Report PDF dapat diunduh sekarang`,
                                showConfirmButton: false,
                                timer: 4000,
                                timerProgressBar: true,
                                background: '#ffffff',
                                color: '#0f172a',
                                customClass: {
                                    popup: 'rounded-2xl border border-slate-200 shadow-xl shadow-slate-200/70',
                                    title: 'text-sm font-black text-slate-950',
                                    htmlContainer: 'text-xs font-semibold text-slate-500',
                                    timerProgressBar: 'bg-[#34A853]',
                                },
                            });
                        } catch (error) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Gagal download PDF',
                                text: 'Terjadi masalah saat membuat report. Coba lagi.',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                background: '#ffffff',
                                color: '#0f172a',
                                customClass: {
                                    popup: 'rounded-2xl border border-slate-200 shadow-xl shadow-slate-200/70',
                                    title: 'text-sm font-black text-slate-950',
                                    htmlContainer: 'text-xs font-semibold text-slate-500',
                                    timerProgressBar: 'bg-[#EA4335]',
                                },
                            });
                        }
                    });
                });

                /*
                |--------------------------------------------------------------------------
                | Success Toast After Redirect
                |--------------------------------------------------------------------------
                */
                @if (session('status'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: @json(session('status')),
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        background: '#ffffff',
                        color: '#0f172a',
                        customClass: {
                            popup: 'rounded-2xl border border-slate-200 shadow-xl shadow-slate-200/70',
                            title: 'text-sm font-black text-slate-950',
                            timerProgressBar: 'bg-[#34A853]',
                        },
                    });
                @endif
            });
        </script>
    @endonce

</x-app-layout>
