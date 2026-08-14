<x-app-layout>

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
    </style>

    <main class="min-h-screen bg-slate-50 text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100">
        @include('layouts.app.sidebar')

        <div class="w-full min-w-0 flex-1 max-w-7xl mx-auto min-h-screen px-4 py-8 sm:px-6 lg:px-8 lg:pl-72">

            <!-- Header Section -->
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1
                        class="font-display text-2xl font-black tracking-tight text-slate-950 dark:text-white sm:text-3xl">
                        Job Applications Record
                    </h1>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Track and manage your career journey efficiently.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('recordjob.create') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#4285F4] px-5 py-2.5 text-sm font-black text-white shadow-lg shadow-blue-500/30 transition-all duration-300 hover:bg-blue-600 hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Add New Application
                    </a>
                </div>
            </div>

            <!-- Search, Reset & Filter Bar -->
            <form method="GET" action="{{ route('recordjob.index') }}"
                class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="relative w-full sm:max-w-md">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder=" "
                        class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 placeholder-transparent focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100 dark:focus:border-[#4285F4] dark:focus:ring-[#4285F4]/10">
                    <label for="search"
                        class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                        Search company or position
                    </label>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <select name="status"
                        class="appearance-none rounded-2xl border border-slate-200 bg-white px-4 py-2.5 pr-10 text-sm font-semibold text-slate-700 outline-none transition-all duration-300 focus:border-[#4285F4] focus:ring-4 focus:ring-[#4285F4]/10 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                        <option value="">All Status</option>
                        <option value="Applied" {{ request('status') == 'Applied' ? 'selected' : '' }}>Applied</option>
                        <option value="Interview" {{ request('status') == 'Interview' ? 'selected' : '' }}>Interview</option>
                        <option value="Testing" {{ request('status') == 'Testing' ? 'selected' : '' }}>Testing</option>
                        <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#4285F4] px-5 py-2.5 text-sm font-black text-white shadow-lg shadow-blue-500/30 transition-all duration-300 hover:bg-blue-600 hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="8" r="3" />
                            <path d="M21 21l-4.35-4.35M5 11a6 6 0 1112 0 6 6 0 01-12 0z" />
                        </svg>
                        Search
                    </button>

                    <a href="{{ route('recordjob.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-2.5 text-sm font-semibold text-slate-600 transition-all duration-300 hover:bg-slate-100 hover:text-slate-900 dark:border-slate-800 dark:bg-slate-900/50 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-400/50">
                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18M6 12h12M10 18h8" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>

            <!-- Main Content Card / Table -->
            <div
                class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
                        <thead
                            class="border-b border-slate-200 bg-slate-50/50 text-xs uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-400">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Company & Position</th>
                                <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Platform</th>
                                <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Salary</th>
                                <th scope="col" class="px-6 py-4 font-semibold whitespace-nowrap">Date Applied</th>
                                <th scope="col"
                                    class="px-6 py-4 text-right font-semibold whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($jobs as $job)
                                <tr class="transition-colors hover:bg-slate-50/70 dark:hover:bg-slate-900/50"
                                    x-data="{ openEditModal: false }">
                                    <!-- Company & Position -->
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-900 dark:text-slate-100">
                                            {{ $job->company_name }}
                                        </div>
                                        <div class="text-slate-500 dark:text-slate-400">{{ $job->position }}
                                        </div>
                                    </td>

                                    <!-- Platform -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                            {{ $job->platform }}
                                        </span>
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusStyles = [
                                                'Applied' => 'bg-blue-50 text-blue-700 border-blue-200/60',
                                                'Interview' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                                'Testing' => 'bg-purple-50 text-purple-700 border-purple-200/60',
                                                'Accepted' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                                'Rejected' => 'bg-red-50 text-red-700 border-red-200/60',
                                            ];
                                            $currentStyle = $statusStyles[$job->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                        @endphp
                                        <span
                                            class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $currentStyle }}">
                                            {{ $job->status }}
                                        </span>
                                    </td>

                                    <!-- Salary -->
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-700 dark:text-slate-300">
                                        {{ $job->formatted_salary }}
                                    </td>

                                    <!-- Date Applied -->
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-500 dark:text-slate-400">
                                        {{ $job->applied_at->format('d M Y') }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            @if ($job->job_url)
                                                <a href="{{ $job->job_url }}" target="_blank"
                                                    class="rounded-xl p-2 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800"
                                                    title="Visit Job URL">
                                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                                        <polyline points="15 3 21 3 21 9" />
                                                        <line x1="10" y1="14" x2="21" y2="3" />
                                                    </svg>
                                                </a>
                                            @endif

                                            <!-- Tombol Trigger Modal Edit -->
                                            <button type="button" @click="openEditModal = true"
                                                data-job-id="{{ $job->id }}"
                                                class="rounded-xl p-2 text-slate-400 transition-colors hover:bg-amber-100 hover:text-amber-700 dark:hover:bg-amber-900/30"
                                                title="Edit Record">
                                                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                    <path d="m15 5 4 4" />
                                                </svg>
                                            </button>

                                            <!-- Form Delete -->
                                            <form id="delete-form-{{ $job->id }}"
                                                action="{{ route('recordjob.destroy', $job->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $job->id }})"
                                                    class="rounded-xl p-2 text-slate-400 transition-colors hover:bg-red-100 hover:text-red-700 dark:hover:bg-red-900/30"
                                                    title="Delete Record">
                                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M3 6h18" />
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <!-- Modal Edit (Teleported to Body) -->
                                            <template x-teleport="body">
                                                <div x-show="openEditModal" x-cloak
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 scale-95"
                                                    x-transition:enter-end="opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 scale-100"
                                                    x-transition:leave-end="opacity-0 scale-95"
                                                    @keydown.escape.window="openEditModal = false"
                                                    class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">

                                                    <!-- Backdrop Overlay -->
                                                    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                                                        @click="openEditModal = false"></div>

                                                    <!-- Modal Dialog Card -->
                                                    <div
                                                        class="relative z-10 w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-3xl bg-white p-6 shadow-2xl dark:bg-slate-900 sm:p-8 text-left">

                                                        <!-- Header Modal -->
                                                        <div
                                                            class="flex items-center justify-between border-b border-slate-100 pb-4 dark:border-slate-800">
                                                            <div>
                                                                <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100">
                                                                    Edit Job Application
                                                                </h3>
                                                                <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                                                    {{ $job->company_name }} —
                                                                    {{ $job->position }}
                                                                </p>
                                                            </div>

                                                            <!-- Close Button (X) -->
                                                            <button type="button"
                                                                @click="openEditModal = false"
                                                                class="rounded-xl p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <!-- Form Content -->
                                                        <div class="mt-4">
                                                            @include('recordjob.form', ['job' => $job])
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- Empty State -->
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div
                                                class="mx-auto flex max-w-sm flex-col items-center justify-center text-center">
                                                <div
                                                    class="mb-4 grid h-16 w-16 place-items-center rounded-full bg-slate-100 text-slate-400">
                                                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path
                                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                                        <line x1="12" y1="22.08" x2="12" y2="12" />
                                                    </svg>
                                                </div>
                                                <h3 class="mb-1 text-base font-semibold text-slate-900 dark:text-white">No applications found</h3>
                                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                                    You haven't added any job records yet. Start tracking
                                                    your applications now.
                                                </p>
                                                <a href="{{ route('recordjob.create') }}"
                                                    class="mt-5 text-sm font-medium text-[#4285F4] hover:text-blue-700 hover:underline">
                                                    + Add Your First Application
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                @if ($jobs->hasPages())
                    <div
                        class="border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-slate-800 dark:bg-slate-900/50">
                        {{ $jobs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Script SweetAlert2 & Helper -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            /*
            |--------------------------------------------------------------------------
            | Delete Confirmation
            |--------------------------------------------------------------------------
            */
            window.confirmDelete = function(id) {
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data lamaran ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    buttonsStyling: false,
                    reverseButtons: true,
                    focusCancel: true,
                    customClass: {
                        popup: 'rounded-3xl',
                        title: 'text-slate-950 font-black',
                        htmlContainer: 'text-slate-500 text-sm',
                        confirmButton: 'rounded-2xl bg-[#EA4335] px-5 py-3 text-sm font-black text-white transition hover:bg-red-600',
                        cancelButton: 'mr-3 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-black text-slate-700 transition hover:border-[#4285F4] hover:text-[#4285F4]',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Success Toast After Redirect
            |--------------------------------------------------------------------------
            */
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
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

            /*
            |--------------------------------------------------------------------------
            | Validation Error — Re-open Edit Modal
            |--------------------------------------------------------------------------
            | Jika validasi gagal, buka kembali modal edit untuk job yang relevan
            | agar pengguna tetap melihat error di konteks form yang sama.
            |--------------------------------------------------------------------------
            */
            @if ($errors->any())
                let editJobId = "{{ old('edit_job_id') }}";
                if (editJobId) {
                    let btn = document.querySelector('[data-job-id="' + editJobId + '"]');
                    if (btn) btn.click();
                }
            @endif
        });
    </script>
</x-app-layout>
