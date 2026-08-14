<x-layouts.app>
    <div class="w-full max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">

        <!-- Header Section -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-slate-100">Edit Job Application</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Update the details of "{{ $job->company_name }} - {{ $job->position }}".
                </p>
            </div>
            <a href="{{ route('recordjob.index') }}"
                class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600 transition-all hover:bg-slate-100 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                Back
            </a>
        </div>

        <!-- Alert Success Message -->
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-emerald-800 shadow-sm" role="alert">
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Card Form -->
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @include('recordjob.form')
        </div>

    </div>
</x-layouts.app>
