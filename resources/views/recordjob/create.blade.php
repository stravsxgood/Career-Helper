<x-app-layout>
    @include('layouts.app.sidebar')
    <div class="w-full min-w-0 flex-1 max-w-5xl mx-auto px-4 py-8 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="font-display text-2xl font-black tracking-tight text-slate-950 dark:text-white sm:text-3xl">
                    Add Job Application
                </h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Add a new job application record to track your career journey.
                </p>
            </div>
            <a href="{{ route('recordjob.index') }}"
                class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600 transition-all duration-300 hover:bg-slate-100 hover:text-slate-900 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-400/50">
                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back
            </a>
        </div>

        <!-- Create Form Card -->
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @include('recordjob.form')
        </div>
    </div>
</x-app-layout>
