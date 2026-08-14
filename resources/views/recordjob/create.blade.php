<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Job - Create</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">

    <x-app-layout>
        @include('layouts.app.sidebar')
        <div class="w-full min-w-0 flex-1 max-w-7xl mx-auto min-h-screen px-4 py-8 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Add Job Application</h1>
                    <p class="mt-1 text-sm text-slate-500">Add a new job application record to track your career journey.</p>
                </div>
                <a href="{{ route('recordjob.index') }}"
                    class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600 transition-all duration-300 hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-400/50">
                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back
                </a>
            </div>

            <!-- Create Form Card -->
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="p-6 sm:p-8">
                    @include('recordjob.form')
                </div>
            </div>
        </div>
    </x-app-layout>

</body>
</html>
