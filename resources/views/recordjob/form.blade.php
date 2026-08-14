@php
    $isEdit = isset($job);
    $statuses = ['Applied', 'Interview', 'Testing', 'Accepted', 'Rejected'];
@endphp

<form method="POST" action="{{ $isEdit ? route('recordjob.update', $job->id) : route('recordjob.store') }}" class="mt-6 space-y-5">
    @csrf
    @if ($isEdit)
        @method('PUT')
        <input type="hidden" name="edit_job_id" value="{{ $job->id }}">
    @endif

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <!-- Company Name -->
        <div class="relative">
            <input id="company_name" name="company_name" type="text"
                value="{{ old('company_name', $job->company_name ?? '') }}" placeholder=" "
                class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 placeholder-transparent focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:bg-slate-900">
            <label for="company_name"
                class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                Company Name
            </label>
            @error('company_name')
                <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Position -->
        <div class="relative">
            <input id="position" name="position" type="text" value="{{ old('position', $job->position ?? '') }}"
                placeholder=" "
                class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 placeholder-transparent focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:bg-slate-900">
            <label for="position"
                class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                Position
            </label>
            @error('position')
                <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Platform -->
        <div class="relative">
            <input id="platform" name="platform" type="text" value="{{ old('platform', $job->platform ?? '') }}"
                placeholder=" "
                class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 placeholder-transparent focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:bg-slate-900">
            <label for="platform"
                class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                Platform
            </label>
            @error('platform')
                <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div class="relative">
            <select id="status" name="status"
                class="peer w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:bg-slate-900">
                <option value="" disabled selected>Choose status</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}"
                        {{ old('status', $job->status ?? '') == $status ? 'selected' : '' }}>{{ $status }}
                    </option>
                @endforeach
            </select>
            <label for="status"
                class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                Status
            </label>
            @error('status')
                <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Applied At -->
        <div class="relative">
            <input id="applied_at" name="applied_at" type="date"
                value="{{ old('applied_at', isset($job) ? $job->applied_at->format('Y-m-d') : '') }}"
                placeholder=" "
                class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 placeholder-transparent focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:bg-slate-900">
            <label for="applied_at"
                class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                Date Applied
            </label>
            @error('applied_at')
                <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Salary -->
        <div class="relative">
            <input id="salary" name="salary" type="text" value="{{ old('salary', $job->salary ?? '') }}"
                placeholder=" "
                class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 placeholder-transparent focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:bg-slate-900">
            <label for="salary"
                class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                Salary (Rp)
            </label>
            @error('salary')
                <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Job URL -->
        <div class="sm:col-span-2 relative">
            <input id="job_url" name="job_url" type="url" value="{{ old('job_url', $job->job_url ?? '') }}"
                placeholder=" "
                class="peer w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 placeholder-transparent focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:bg-slate-900">
            <label for="job_url"
                class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                Job URL
            </label>
            @error('job_url')
                <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
            @enderror
        </div>

        <!-- Notes -->
        <div class="sm:col-span-2 relative">
            <textarea id="notes" name="notes" rows="4" placeholder=" "
                class="peer w-full resize-y rounded-2xl border border-slate-200 bg-slate-50 px-4 pb-3 pt-6 text-sm font-semibold text-slate-900 outline-none transition-all duration-300 placeholder-transparent focus:border-[#4285F4] focus:bg-white focus:ring-4 focus:ring-[#4285F4]/10 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:bg-slate-900">{{ old('notes', $job->notes ?? '') }}</textarea>
            <label for="notes"
                class="pointer-events-none absolute left-4 top-2 text-xs font-bold text-slate-400 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs peer-focus:text-[#4285F4]">
                Notes
            </label>
            @error('notes')
                <p class="mt-2 text-xs font-semibold text-[#EA4335]">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Actions Section -->
    <div class="flex items-center justify-end gap-3 pt-2">
        @if ($isEdit)
            <!-- Jika dalam modal Edit: Tutup Modal -->
            <button type="button" @click="openEditModal = false"
                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-2.5 text-sm font-semibold text-slate-600 transition-all duration-300 hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:bg-slate-800/50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400/50">
                Cancel
            </button>
        @else
            <!-- Jika dalam halaman Create: Kembalikan ke Index -->
            <a href="{{ route('recordjob.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-2.5 text-sm font-semibold text-slate-600 transition-all duration-300 hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:bg-slate-800/50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400/50">
                Back
            </a>
        @endif

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#4285F4] px-5 py-2.5 text-sm font-black text-white shadow-lg shadow-blue-500/30 transition-all duration-300 hover:bg-blue-600 hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
            {{ $isEdit ? 'Update' : 'Save' }}
        </button>
    </div>
</form>
