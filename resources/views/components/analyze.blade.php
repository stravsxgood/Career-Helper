<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\CareerAnalysisService;
use App\Services\PdfTextExtractorService;

new class extends Component {
    use WithFileUploads;

    public string $target_role = '';
    public string $career_interest = '';
    public string $hard_skills = '';
    public string $soft_skills = '';
    public string $work_preference = '';
    public string $location = '';
    public string $cv_text = '';

    public $cv_file = null;

    public function submit()
    {
        try {
            $validated = $this->validate(
                [
                    'target_role' => ['required', 'string', 'max:500'],
                    'career_interest' => ['required', 'string', 'max:1000'],
                    'hard_skills' => ['required', 'string', 'max:3000'],
                    'soft_skills' => ['required', 'string', 'max:3000'],
                    'work_preference' => ['required', 'string', 'in:Full-time,Part-time,Hybrid,Remote,Freelancer,Kontrak'],
                    'location' => ['nullable', 'string', 'max:500'],
                    'cv_text' => ['nullable', 'string', 'max:20000'],
                    'cv_file' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
                ],
                [
                    'target_role.required' => 'Target pekerjaan wajib diisi.',
                    'career_interest.required' => 'Bidang yang diminati wajib diisi.',
                    'hard_skills.required' => 'Hard skill wajib diisi.',
                    'soft_skills.required' => 'Soft skill wajib diisi.',
                    'work_preference.required' => 'Jenis pekerjaan wajib dipilih.',
                    'cv_file.mimes' => 'CV harus berupa file PDF.',
                    'cv_file.max' => 'Ukuran CV maksimal 5 MB.',
                ],
                [
                    'target_role' => 'Target pekerjaan',
                    'career_interest' => 'Bidang yang diminati',
                    'hard_skills' => 'Hard skill',
                    'soft_skills' => 'Soft skill',
                    'work_preference' => 'Jenis pekerjaan',
                    'location' => 'Lokasi',
                    'cv_file' => 'CV',
                ],
            );

            Log::info('ANALYZE: validasi lolos', [
                'target_role' => $validated['target_role'] ?? null,
                'career_interest' => $validated['career_interest'] ?? null,
                'hard_skills' => $validated['hard_skills'] ?? null,
                'soft_skills' => $validated['soft_skills'] ?? null,
                'work_preference' => $validated['work_preference'] ?? null,
                'has_cv_file' => (bool) $this->cv_file,
            ]);

            $cvText = $validated['cv_text'] ?? '';

            if ($this->cv_file) {
                Log::info('ANALYZE: mulai simpan CV');

                $cvPath = $this->cv_file->store('cv-files', 'local');

                Log::info('ANALYZE: CV tersimpan', [
                    'path' => $cvPath,
                ]);

                $cvText = app(PdfTextExtractorService::class)->extract(Storage::disk('local')->path($cvPath));

                Log::info('ANALYZE: teks CV berhasil diekstrak', [
                    'length' => mb_strlen($cvText),
                ]);

                $validated['cv_file_path'] = $cvPath;
                $validated['cv_original_name'] = $this->cv_file->getClientOriginalName();
            } else {
                Log::info('ANALYZE: tanpa CV');

                $validated['cv_file_path'] = null;
                $validated['cv_original_name'] = null;
            }

            $validated['cv_text'] = $cvText;

            unset($validated['cv_file']);

            Log::info('ANALYZE: mulai panggil CareerAnalysisService');

            $analysis = app(CareerAnalysisService::class)->analyze($validated);

            Log::info('ANALYZE: analisis berhasil dibuat', [
                'id' => $analysis->id,
            ]);

            return $this->redirectRoute('result', [
                'id' => $analysis->id,
            ]);
        } catch (ValidationException $e) {
            Log::warning('ANALYZE: validasi gagal', [
                'errors' => $e->errors(),
            ]);

            throw $e;
        } catch (\Throwable $e) {
            Log::error('ANALYZE: error saat submit', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            $this->addError('submit', 'Terjadi error saat analisis: ' . $e->getMessage());

            return;
        }
    }
}; ?>
<div x-data="careerAnalyzeForm()"
    class="min-h-screen bg-slate-50 px-4 py-8 text-slate-900 antialiased dark:bg-slate-900 dark:text-slate-100 sm:px-6 lg:px-8">

    <div wire:loading.flex wire:target="submit"
        class="fixed inset-0 z-[9999] items-center justify-center bg-slate-950/55 px-4 backdrop-blur-sm">
        <div
            class="w-full max-w-md rounded-[2rem] border border-white/15 bg-white p-6 text-center shadow-2xl dark:bg-slate-900">
            <div
                class="mx-auto grid h-16 w-16 place-items-center rounded-3xl bg-blue-50 text-[#4285F4] dark:bg-blue-950/40">
                <svg class="h-8 w-8 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"></path>
                </svg>
            </div>

            <h3 class="mt-5 text-lg font-black text-slate-950 dark:text-white">
                AI sedang menganalisis profilmu
            </h3>

            <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                Mohon tunggu sebentar. Sistem sedang membaca skill, CV, preferensi kerja, dan membuat rekomendasi
                karier.
            </p>

            <div class="mt-5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                <div class="h-2 w-1/2 animate-[loadingBar_1.4s_ease-in-out_infinite] rounded-full bg-[#4285F4]"></div>
            </div>

            <p class="mt-4 text-xs font-bold uppercase tracking-[0.18em] text-[#4285F4]">
                Processing
            </p>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes loadingBar {
            0% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(80%);
            }

            100% {
                transform: translateX(220%);
            }
        }
    </style>

    @php
        $inputBase =
            'w-full rounded-2xl bg-white px-4 py-3.5 text-sm font-semibold text-slate-950 caret-[#4285F4] outline-none transition duration-200 ease-in-out placeholder:text-slate-400 hover:border-slate-300 focus:scale-[1.01] focus:border-[#4285F4] focus:ring-4 focus:ring-blue-100 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:ring-blue-950/70';

        $textareaBase =
            'w-full resize-y rounded-2xl bg-white px-4 py-3.5 text-sm font-semibold leading-6 text-slate-950 caret-[#4285F4] outline-none transition duration-200 ease-in-out placeholder:text-slate-400 hover:border-slate-300 focus:scale-[1.01] focus:border-[#4285F4] focus:ring-4 focus:ring-blue-100 dark:bg-slate-950 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-600 dark:focus:ring-blue-950/70';

        $shortFields = [
            [
                'label' => 'Target Pekerjaan',
                'model' => 'target_role',
                'type' => 'text',
                'placeholder' => 'e.g., Senior Laravel Developer, Data Analyst',
                'required' => true,
            ],
            [
                'label' => 'Lokasi',
                'model' => 'location',
                'type' => 'text',
                'placeholder' => 'Contoh: Bekasi, Cikarang, Jakarta',
                'required' => false,
            ],
        ];

        $longFields = [
            [
                'label' => 'Bidang yang diminati',
                'model' => 'career_interest',
                'rows' => 3,
                'placeholder' => 'Contoh: Technology, Finance, Healthcare, manufaktur, admin, sales, desain.',
                'required' => true,
            ],
        ];

        $jobTypes = ['Full-time', 'Part-time', 'Hybrid', 'Remote', 'Freelancer', 'Kontrak'];
    @endphp

    <main class="mx-auto max-w-6xl">
        <header class="mb-8 grid gap-5 lg:grid-cols-[1.2fr_0.8fr] lg:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-[#4285F4]">
                    Career Helper
                </p>

                <h1 class="mt-3 text-3xl font-black tracking-tight text-slate-950 dark:text-white sm:text-4xl">
                    Analisis Profil Karier
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-300">
                    Isi profil kariermu dengan rapi. AI akan membaca skill, pengalaman, preferensi kerja, dan CV jika
                    tersedia.
                </p>
            </div>

            <aside
                class="rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-start gap-3">
                    <div
                        class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl bg-blue-50 text-[#4285F4] dark:bg-blue-950/40">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-black text-slate-950 dark:text-white">
                            CV optional
                        </p>
                        <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                            Tanpa CV tetap bisa dianalisis, tetapi hasil akan lebih kuat jika data resume tersedia.
                        </p>
                    </div>
                </div>
            </aside>
        </header>

        <form wire:submit.prevent="submit" x-on:submit.capture="handleSubmit($event)" enctype="multipart/form-data"
            class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800 sm:p-7 lg:p-8">
            <div x-cloak x-show="hasError" x-transition.opacity.duration.200ms
                class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-[#EA4335] dark:border-red-900/60 dark:bg-red-950/30"
                x-text="errorMessage"></div>

            <div x-cloak x-show="showNoCvNote && !fileName" x-transition.opacity.duration.200ms
                class="mb-6 rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm font-semibold text-[#4285F4] dark:border-blue-900/60 dark:bg-blue-950/30">
                Catatan: Anda tidak mengunggah CV. AI akan menganalisis profil tanpa data resume detail.
            </div>

            <section>
                <div class="mb-5">
                    <h2 class="text-base font-black text-slate-950 dark:text-white">
                        Data Utama
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Bagian ini menjadi dasar AI memahami arah kariermu.
                    </p>
                </div>

                @if ($errors->any())
                    <div
                        class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-[#EA4335] dark:border-red-900/60 dark:bg-red-950/30">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid gap-5 md:grid-cols-2">
                    @foreach ($shortFields as $field)
                        <div class="{{ $field['model'] === 'location' ? 'md:col-span-2' : '' }}">
                            <label for="{{ $field['model'] }}"
                                class="mb-2 block text-sm font-bold text-slate-800 dark:text-slate-100">
                                {{ $field['label'] }}
                                @if ($field['required'])
                                    <span class="text-[#EA4335]">*</span>
                                @endif
                            </label>

                            <input id="{{ $field['model'] }}" type="{{ $field['type'] }}"
                                wire:model="{{ $field['model'] }}" placeholder="{{ $field['placeholder'] }}"
                                style="color-scheme: light;"
                                class="{{ $inputBase }} {{ $errors->has($field['model']) ? 'border border-red-300 focus:border-[#EA4335] focus:ring-red-100 dark:border-red-800 dark:focus:ring-red-950/60' : 'border border-slate-200 dark:border-slate-700' }}">

                            @error($field['model'])
                                <p class="mt-2 text-xs font-bold text-[#EA4335]">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    @foreach ($longFields as $field)
                        <div
                            class="{{ in_array($field['model'], ['experience', 'projects']) ? 'md:col-span-2' : '' }}">
                            <label for="{{ $field['model'] }}"
                                class="mb-2 block text-sm font-bold text-slate-800 dark:text-slate-100">
                                {{ $field['label'] }}
                                @if ($field['required'])
                                    <span class="text-[#EA4335]">*</span>
                                @endif
                            </label>

                            <textarea id="{{ $field['model'] }}" wire:model="{{ $field['model'] }}" rows="{{ $field['rows'] }}"
                                placeholder="{{ $field['placeholder'] }}" style="color-scheme: light;"
                                class="{{ $textareaBase }} {{ $errors->has($field['model']) ? 'border border-red-300 focus:border-[#EA4335] focus:ring-red-100 dark:border-red-800 dark:focus:ring-red-950/60' : 'border border-slate-200 dark:border-slate-700' }}"></textarea>

                            @error($field['model'])
                                <p class="mt-2 text-xs font-bold text-[#EA4335]">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="mt-8 border-t border-slate-100 pt-8 dark:border-slate-700">
                <div class="mb-5">
                    <h2 class="text-base font-black text-slate-950 dark:text-white">
                        Skill & Preferensi Kerja
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Tulis skill dengan koma agar mudah dibaca seperti tag.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="hard_skills"
                            class="mb-2 block text-sm font-bold text-slate-800 dark:text-slate-100">
                            Hard Skill <span class="text-[#EA4335]">*</span>
                        </label>

                        <div
                            class="{{ $errors->has('hard_skills') ? 'border-red-300 focus-within:border-[#EA4335] focus-within:ring-red-100 dark:border-red-800 dark:focus-within:ring-red-950/60' : 'border-slate-200 dark:border-slate-700' }} rounded-2xl border bg-white px-4 py-3.5 transition duration-200 ease-in-out hover:border-slate-300 focus-within:scale-[1.01] focus-within:border-[#4285F4] focus-within:ring-4 focus-within:ring-blue-100 dark:bg-slate-950 dark:hover:border-slate-600 dark:focus-within:ring-blue-950/70">
                            <textarea id="hard_skills" x-model="hardSkills" wire:model.live="hard_skills" rows="3"
                                placeholder="e.g., PHP, Tailwind CSS, MySQL" style="color-scheme: light;"
                                class="w-full resize-y border-0 bg-transparent p-0 text-sm font-semibold leading-6 text-slate-950 caret-[#4285F4] outline-none placeholder:text-slate-400 focus:ring-0 dark:text-white dark:placeholder:text-slate-500"></textarea>

                            <div class="mt-3 flex flex-wrap gap-2" x-show="skillTags(hardSkills).length" x-cloak>
                                <template x-for="skill in skillTags(hardSkills)" :key="skill">
                                    <span
                                        class="rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-bold text-[#4285F4] dark:border-blue-900/60 dark:bg-blue-950/40">
                                        <span x-text="skill"></span>
                                    </span>
                                </template>
                            </div>
                        </div>

                        @error('hard_skills')
                            <p class="mt-2 text-xs font-bold text-[#EA4335]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="soft_skills"
                            class="mb-2 block text-sm font-bold text-slate-800 dark:text-slate-100">
                            Soft Skill <span class="text-[#EA4335]">*</span>
                        </label>

                        <div
                            class="{{ $errors->has('soft_skills') ? 'border-red-300 focus-within:border-[#EA4335] focus-within:ring-red-100 dark:border-red-800 dark:focus-within:ring-red-950/60' : 'border-slate-200 dark:border-slate-700' }} rounded-2xl border bg-white px-4 py-3.5 transition duration-200 ease-in-out hover:border-slate-300 focus-within:scale-[1.01] focus-within:border-[#4285F4] focus-within:ring-4 focus-within:ring-blue-100 dark:bg-slate-950 dark:hover:border-slate-600 dark:focus-within:ring-blue-950/70">
                            <textarea id="soft_skills" x-model="softSkills" wire:model.live="soft_skills" rows="3"
                                placeholder="e.g., Communication, Problem Solving, Leadership" style="color-scheme: light;"
                                class="w-full resize-y border-0 bg-transparent p-0 text-sm font-semibold leading-6 text-slate-950 caret-[#4285F4] outline-none placeholder:text-slate-400 focus:ring-0 dark:text-white dark:placeholder:text-slate-500"></textarea>

                            <div class="mt-3 flex flex-wrap gap-2" x-show="skillTags(softSkills).length" x-cloak>
                                <template x-for="skill in skillTags(softSkills)" :key="skill">
                                    <span
                                        class="rounded-full border border-green-100 bg-green-50 px-3 py-1 text-xs font-bold text-[#34A853] dark:border-green-900/60 dark:bg-green-950/40">
                                        <span x-text="skill"></span>
                                    </span>
                                </template>
                            </div>
                        </div>

                        @error('soft_skills')
                            <p class="mt-2 text-xs font-bold text-[#EA4335]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <fieldset class="mt-6">
                    <legend class="text-sm font-bold text-slate-800 dark:text-slate-100">
                        Jenis Pekerjaan <span class="text-[#EA4335]">*</span>
                    </legend>

                    <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($jobTypes as $type)
                            <label
                                x-on:click="workPreference = '{{ $type }}'; $wire.set('work_preference', '{{ $type }}')"
                                class="group cursor-pointer rounded-2xl border p-4 transition duration-200 ease-in-out hover:-translate-y-0.5 hover:shadow-sm"
                                :class="workPreference === '{{ $type }}'
                                    ?
                                    'border-[#4285F4] bg-blue-50 text-[#4285F4] shadow-sm dark:border-[#4285F4] dark:bg-blue-950/30' :
                                    'border-slate-200 bg-white text-slate-700 hover:border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:border-slate-600'">
                                <input type="radio" name="work_preference" x-model="workPreference"
                                    wire:model.live="work_preference" value="{{ $type }}" class="sr-only">

                                <span class="flex items-center justify-between gap-3">
                                    <span class="text-sm font-bold">{{ $type }}</span>

                                    <span
                                        class="grid h-5 w-5 place-items-center rounded-full border transition duration-200"
                                        :class="workPreference === '{{ $type }}'
                                            ?
                                            'border-[#4285F4] bg-[#4285F4]' :
                                            'border-slate-300 bg-white dark:border-slate-600 dark:bg-slate-900'">
                                        <svg class="h-3 w-3 text-white transition duration-200"
                                            :class="workPreference === '{{ $type }}' ? 'scale-100 opacity-100' :
                                                'scale-50 opacity-0'"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.25 7.333a1 1 0 0 1-1.42 0L3.29 9.287a1 1 0 1 1 1.42-1.414l4.04 4.04 6.54-6.617a1 1 0 0 1 1.414-.006Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                            </label>
                        @endforeach
                    </div>

                    @error('work_preference')
                        <p class="mt-2 text-xs font-bold text-[#EA4335]">{{ $message }}</p>
                    @enderror
                </fieldset>
            </section>

            <section class="mt-8 border-t border-slate-100 pt-8 dark:border-slate-700">
                <div class="mb-4 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                    <div>
                        <label for="cv_file" class="block text-sm font-bold text-slate-800 dark:text-slate-100">
                            Upload CV
                        </label>
                        <p class="mt-1 text-xs font-medium text-slate-500 dark:text-slate-400">
                            Optional · PDF only · Max 5MB
                        </p>
                    </div>

                    <span x-cloak x-show="fileName && cvUploaded" x-transition.opacity.duration.200ms
                        class="w-fit rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-[#34A853] dark:bg-green-950/40">
                        CV siap digunakan
                    </span>
                </div>

                <div class="rounded-[1.5rem] border-2 border-dashed p-5 transition duration-200 ease-in-out"
                    :class="uploadZoneClass()" x-on:dragover.prevent="isDragging = true"
                    x-on:dragleave.prevent="isDragging = false" x-on:drop.prevent="handleDrop($event)"
                    x-on:livewire-upload-start="isUploading = true; cvUploaded = false; hasError = false; showNoCvNote = false"
                    x-on:livewire-upload-finish="isUploading = false; cvUploaded = true; uploadProgress = 100"
                    x-on:livewire-upload-error="isUploading = false; cvUploaded = false; hasError = true; errorMessage = 'Gagal: Upload CV bermasalah. Pastikan file PDF maksimal 5MB.'"
                    x-on:livewire-upload-progress="uploadProgress = $event.detail.progress">
                    <input id="cv_file" name="cv_file" type="file" accept="application/pdf,.pdf"
                        class="sr-only" x-ref="cvInput" wire:model="cv_file" x-on:change="handleFileChange($event)">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-start gap-4">
                            <label for="cv_file"
                                class="grid h-12 w-12 shrink-0 cursor-pointer place-items-center rounded-2xl transition duration-200"
                                :class="cvUploaded ? 'bg-green-50 text-[#34A853] dark:bg-green-950/40' :
                                    'bg-blue-50 text-[#4285F4] dark:bg-blue-950/40'"
                                aria-label="Pilih CV">
                                <svg x-show="!cvUploaded" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                                    aria-hidden="true">
                                    <path d="M12 15V4m0 0 4 4m-4-4-4 4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M20 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-3" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" />
                                </svg>

                                <svg x-cloak x-show="cvUploaded" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                                    aria-hidden="true">
                                    <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.4"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </label>

                            <div>
                                <p class="text-sm font-bold text-slate-900 dark:text-white"
                                    x-text="fileName || 'Tarik file CV ke area ini'"></p>

                                <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">
                                    <span x-show="!fileName">
                                        Atau klik tombol pilih file. Form tetap bisa dikirim tanpa CV.
                                    </span>

                                    <span x-cloak x-show="fileName && isUploading">
                                        Memproses CV... <span x-text="`${uploadProgress}%`"></span>
                                    </span>

                                    <span x-cloak x-show="fileName && cvUploaded">
                                        Upload selesai · <span x-text="fileSize"></span>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <label for="cv_file"
                                class="cursor-pointer rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 transition duration-200 hover:border-[#4285F4] hover:text-[#4285F4] dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300">
                                Pilih File
                            </label>

                            <button x-cloak x-show="fileName" x-transition.opacity.duration.200ms type="button"
                                class="rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-500 transition duration-200 hover:border-[#EA4335] hover:text-[#EA4335] dark:border-slate-700 dark:bg-slate-950"
                                x-on:click="resetUpload()">
                                Hapus
                            </button>
                        </div>
                    </div>

                    <div x-cloak x-show="fileName" x-transition.opacity.duration.200ms class="mt-5">
                        <div class="h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-700">
                            <div class="h-full rounded-full transition-all duration-300"
                                :class="cvUploaded ? 'bg-[#34A853]' : 'bg-[#4285F4]'"
                                :style="`width: ${uploadProgress}%`"></div>
                        </div>
                    </div>
                </div>

                @error('cv_file')
                    <p class="mt-2 text-xs font-bold text-[#EA4335]">{{ $message }}</p>
                @enderror
            </section>

            @error('submit')
                <div
                    class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-[#EA4335] dark:border-red-900/60 dark:bg-red-950/30">
                    {{ $message }}
                </div>
            @enderror

            <footer
                class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 dark:border-slate-700 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs leading-5 text-slate-500 dark:text-slate-400">
                    Field bertanda <span class="font-bold text-[#EA4335]">*</span> wajib diisi. CV boleh dikosongkan.
                </p>

                <button type="submit" wire:loading.attr="disabled" wire:target="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-[#4285F4] px-6 py-3 text-sm font-black text-white shadow-sm transition duration-200 ease-in-out hover:-translate-y-0.5 hover:bg-blue-600 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-blue-100 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-70 dark:focus:ring-blue-950/70">
                    <span wire:loading.remove wire:target="submit" class="inline-flex items-center gap-2">
                        Analyze Career

                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            <path d="m13 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>

                    <span wire:loading.inline-flex wire:target="submit" class="items-center gap-2">
                        <svg class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z">
                            </path>
                        </svg>

                        AI sedang menganalisis
                    </span>
                </button>
            </footer>
        </form>
    </main>

    <script>
        function careerAnalyzeForm() {
            return {
                hardSkills: '',
                softSkills: '',
                workPreference: '',

                isDragging: false,
                isUploading: false,
                cvUploaded: false,
                hasError: false,
                errorMessage: '',
                showNoCvNote: false,
                uploadProgress: 0,
                fileName: '',
                fileSize: '',

                skillTags(value) {
                    return value
                        .split(',')
                        .map((item) => item.trim())
                        .filter(Boolean)
                        .slice(0, 8);
                },

                handleSubmit(event) {
                    this.hasError = false;
                    this.errorMessage = '';

                    if (this.isUploading) {
                        event.preventDefault();
                        event.stopImmediatePropagation();

                        this.hasError = true;
                        this.errorMessage = 'Gagal: Harap tunggu hingga proses upload CV selesai!';
                        return;
                    }

                    if (!this.fileName && !this.cvUploaded) {
                        this.showNoCvNote = true;
                    }
                },

                handleFileChange(event) {
                    const file = event.target.files[0];

                    if (!file) {
                        this.resetUpload();
                        return;
                    }

                    const maxSize = 5 * 1024 * 1024;

                    if (file.size > maxSize) {
                        event.target.value = '';
                        this.resetUpload();

                        this.hasError = true;
                        this.errorMessage = 'Gagal: Ukuran CV maksimal 5MB.';
                        return;
                    }

                    this.fileName = file.name;
                    this.fileSize = this.formatFileSize(file.size);
                    this.uploadProgress = 0;
                    this.cvUploaded = false;
                    this.showNoCvNote = false;
                },

                handleDrop(event) {
                    this.isDragging = false;

                    const file = event.dataTransfer.files[0];

                    if (!file) {
                        return;
                    }

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    this.$refs.cvInput.files = dataTransfer.files;
                    this.$refs.cvInput.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                },

                resetUpload() {
                    if (this.$refs.cvInput) {
                        this.$refs.cvInput.value = '';
                    }

                    if (this.$wire) {
                        this.$wire.set('cv_file', null);
                    }

                    this.fileName = '';
                    this.fileSize = '';
                    this.uploadProgress = 0;
                    this.isUploading = false;
                    this.cvUploaded = false;
                    this.isDragging = false;
                    this.hasError = false;
                    this.errorMessage = '';
                    this.showNoCvNote = false;
                },

                uploadZoneClass() {
                    if (this.hasError) {
                        return 'border-[#EA4335] bg-red-50 dark:border-[#EA4335] dark:bg-red-950/20';
                    }

                    if (this.isDragging) {
                        return 'border-[#4285F4] bg-blue-50 dark:border-[#4285F4] dark:bg-blue-950/20';
                    }

                    if (this.cvUploaded) {
                        return 'border-[#34A853] bg-green-50 dark:border-[#34A853] dark:bg-green-950/20';
                    }

                    if (this.isUploading) {
                        return 'border-[#4285F4] bg-blue-50/70 dark:border-[#4285F4] dark:bg-blue-950/20';
                    }

                    return 'border-slate-200 bg-slate-50 hover:border-slate-300 dark:border-slate-700 dark:bg-slate-950 dark:hover:border-slate-600';
                },

                formatFileSize(bytes) {
                    if (!bytes) {
                        return '0 KB';
                    }

                    const units = ['B', 'KB', 'MB'];
                    const index = Math.min(Math.floor(Math.log(bytes) / Math.log(1024)), units.length - 1);
                    const size = bytes / Math.pow(1024, index);

                    return `${size.toFixed(index === 0 ? 0 : 1)} ${units[index]}`;
                }
            };
        }
    </script>
</div>
