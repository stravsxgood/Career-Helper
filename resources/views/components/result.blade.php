<x-app-layout>
    @php

        $toList = function ($value) {
            if ($value instanceof \Illuminate\Support\Collection) {
                return $value->all();
            }

            if (is_array($value)) {
                return $value;
            }

            return filled($value) ? [$value] : [];
        };
        $result = $result ?? [];

        $profile = data_get($result, 'profile_summary', []);
        $cvData = data_get($result, 'cv_extracted_data', []);
        $cvFeedback = data_get($result, 'cv_feedback', []);
        $recommendedRoles = data_get($result, 'recommended_roles', []);
        $hardSkills = data_get($result, 'hard_skill_analysis', []);
        $softSkills = data_get($result, 'soft_skill_analysis', []);
        $skillRecommendations = data_get($result, 'skill_recommendations', []);
        $roadmap = data_get($result, 'career_roadmap', []);

        $score = collect($recommendedRoles)->max('fit_score') ?? data_get($cvFeedback, 'cv_score', 0);
        $score = (int) $score;

        $scoreLabel = $score >= 80 ? 'Sangat Cocok' : ($score >= 65 ? 'Cukup Cocok' : 'Perlu Ditingkatkan');

        $chartLabels = collect($hardSkills)->pluck('skill')->take(6)->values();
        $chartData = collect($hardSkills)
            ->map(function ($item) {
                return match (strtolower(data_get($item, 'estimated_level', ''))) {
                    'advanced', 'mahir' => 90,
                    'intermediate', 'menengah' => 75,
                    'junior' => 65,
                    'beginner/intermediate' => 60,
                    'beginner', 'basic', 'pemula', 'dasar' => 45,
                    default => 55,
                };
            })
            ->take(6)
            ->values();

        if ($chartLabels->isEmpty()) {
            $chartLabels = collect(['Skill 1', 'Skill 2', 'Skill 3']);
            $chartData = collect([50, 50, 50]);
        }
    @endphp

    <main
        class="min-h-screen bg-slate-50 px-4 py-8 text-slate-950 antialiased dark:bg-slate-950 dark:text-slate-100 sm:px-6 lg:px-8">

        <section class="mx-auto max-w-7xl">
            <header
                class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/80 sm:p-8">
                <div class="grid gap-6 lg:grid-cols-[1fr_320px] lg:items-center">

                    <div class="min-w-0">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-[#4285F4]">
                                    Career Helper
                                </p>

                                <h1
                                    class="mt-3 text-3xl font-black tracking-tight text-slate-950 dark:text-white sm:text-4xl">
                                    Hasil Analisis Karier
                                </h1>
                            </div>

                            <a href="{{ route('analysis') }}"
                                class="inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-extrabold text-slate-700 transition duration-300 hover:-translate-y-0.5 hover:border-[#4285F4] hover:text-[#4285F4] hover:shadow-xl hover:shadow-slate-950/[0.08] dark:border-white/10 dark:bg-slate-950 dark:text-slate-200 dark:hover:border-[#4285F4] dark:hover:text-blue-300 sm:w-auto">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M15 18 9 12l6-6" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                {{ __('Analisis Lagi') }}
                            </a>
                        </div>

                        <p class="mt-4 max-w-3xl text-sm leading-7 text-slate-600 dark:text-slate-300">
                            {{ data_get($profile, 'summary', 'Belum ada ringkasan profil yang tersedia.') }}
                        </p>
                    </div>

                    <div
                        class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5 dark:border-white/10 dark:bg-slate-950/60">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">
                            Match Score
                        </p>

                        <div class="mt-3 flex items-end justify-between gap-4">
                            <div class="text-6xl font-black tracking-[-0.07em] text-slate-950 dark:text-white">
                                {{ $score }}<span class="text-2xl">%</span>
                            </div>

                            <span
                                class="rounded-full bg-[#34A853]/10 px-3 py-1 text-xs font-bold text-[#188038] ring-1 ring-[#34A853]/20 dark:text-green-300">
                                {{ $scoreLabel }}
                            </span>
                        </div>

                        <div class="mt-4 h-2 overflow-hidden rounded-full bg-slate-200 dark:bg-white/10">
                            <div class="h-full rounded-full bg-[#34A853]" style="width: {{ max(0, min($score, 100)) }}%"></div>
                        </div>
                    </div>
                </div>
            </header>

            <section class="mt-6 grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                <article
                    class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/80">
                    <h2 class="text-lg font-black text-slate-950 dark:text-white">
                        Data CV yang Terbaca
                    </h2>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-950/60">
                            <p class="text-xs font-bold uppercase text-slate-400">Nama</p>
                            <p class="mt-1 font-bold">{{ data_get($cvData, 'name', '-') ?: '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-950/60">
                            <p class="text-xs font-bold uppercase text-slate-400">Tahap Karier</p>
                            <p class="mt-1 font-bold">{{ data_get($profile, 'career_stage', '-') ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-5 space-y-5">
                        @foreach ([
                                    'education' => 'Pendidikan',
                                    'experience' => 'Pengalaman',
                                    'tools' => 'Tools',
                                    'certifications' => 'Sertifikat',
                                    'projects' => 'Project',
                                ] as $key => $label)
                            <div>
                                <h3 class="text-sm font-black text-slate-800 dark:text-slate-100">{{ $label }}
                                </h3>

                                @forelse ($toList(data_get($cvData, $key)) as $item)
                                    <p
                                        class="mt-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 dark:border-white/10 dark:bg-slate-950/60 dark:text-slate-300">
                                        {{ $item }}
                                    </p>
                                @empty
                                    <p class="mt-2 text-sm text-slate-400">Belum terdeteksi dari CV.</p>
                                @endforelse
                            </div>
                        @endforeach
                    </div>
                </article>

                <article
                    class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/80">
                    <h2 class="text-lg font-black text-slate-950 dark:text-white">
                        Analisis Skill
                    </h2>

                    <div class="mt-5 h-[320px] rounded-[1.5rem] bg-slate-50 p-4 dark:bg-slate-950/60">
                        <canvas id="skillChart"></canvas>
                    </div>
                </article>
            </section>

            <section
                class="mt-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/80">
                <h2 class="text-lg font-black text-slate-950 dark:text-white">
                    Rekomendasi Role Pekerjaan
                </h2>

                <div class="mt-5 grid gap-4 lg:grid-cols-2">
                    @forelse ($recommendedRoles as $role)
                        <article
                            class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5 dark:border-white/10 dark:bg-slate-950/60">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="font-black text-slate-950 dark:text-white">
                                        {{ data_get($role, 'role', '-') }}
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                        {{ data_get($role, 'field', '-') }}
                                    </p>
                                </div>

                                <span class="rounded-full bg-[#4285F4]/10 px-3 py-1 text-xs font-black text-[#4285F4]">
                                    {{ data_get($role, 'fit_score', 0) }}%
                                </span>
                            </div>

                            <p class="mt-4 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                {{ data_get($role, 'why_it_fits', '-') }}
                            </p>

                            <div class="mt-4">
                                <p class="text-xs font-black uppercase text-slate-400">Skill Cocok</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach (data_get($role, 'matched_skills', []) as $skill)
                                        <span
                                            class="rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-[#34A853] dark:bg-green-950/40">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-xs font-black uppercase text-slate-400">Skill yang Kurang</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach (data_get($role, 'missing_skills', []) as $skill)
                                        <span
                                            class="rounded-full bg-yellow-50 px-3 py-1 text-xs font-bold text-[#a46b00] dark:bg-yellow-950/40 dark:text-yellow-300">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada rekomendasi role.</p>
                    @endforelse
                </div>
            </section>

            <section class="mt-6 grid gap-6 lg:grid-cols-2">
                <article
                    class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/80">
                    <h2 class="text-lg font-black text-slate-950 dark:text-white">
                        Feedback CV
                    </h2>

                    <div class="mt-5 rounded-2xl bg-slate-50 p-4 dark:bg-slate-950/60">
                        <p class="text-xs font-bold uppercase text-slate-400">Skor CV</p>
                        <p class="mt-1 text-3xl font-black">{{ data_get($cvFeedback, 'cv_score', 0) }}/100</p>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-black text-slate-900 dark:text-white">Kekuatan</h3>
                        <ul class="mt-2 list-disc space-y-2 pl-5 text-sm text-slate-600 dark:text-slate-300">
                            @foreach (data_get($cvFeedback, 'strengths', []) as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-black text-slate-900 dark:text-white">Kelemahan</h3>
                        <ul class="mt-2 list-disc space-y-2 pl-5 text-sm text-slate-600 dark:text-slate-300">
                            @foreach (data_get($cvFeedback, 'weaknesses', []) as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-black text-slate-900 dark:text-white">Ringkasan Profil yang Lebih Baik</h3>
                        <p
                            class="mt-2 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm leading-6 text-slate-700 dark:border-white/10 dark:bg-slate-950/60 dark:text-slate-300">
                            {{ data_get($cvFeedback, 'better_profile_summary', 'Belum ada saran ringkasan profil.') }}
                        </p>
                    </div>
                </article>

                <article
                    class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/80">
                    <h2 class="text-lg font-black text-slate-950 dark:text-white">
                        Rekomendasi Skill
                    </h2>

                    <div class="mt-5 space-y-4">
                        @forelse ($skillRecommendations as $item)
                            <div
                                class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 dark:border-white/10 dark:bg-slate-950/60">
                                <div class="flex items-start justify-between gap-4">
                                    <h3 class="font-black text-slate-950 dark:text-white">
                                        {{ data_get($item, 'skill', '-') }}
                                    </h3>

                                    <span
                                        class="rounded-full bg-[#EA4335]/10 px-3 py-1 text-xs font-black text-[#EA4335]">
                                        {{ data_get($item, 'priority', '-') }}
                                    </span>
                                </div>

                                <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                    {{ data_get($item, 'reason', '-') }}
                                </p>

                                <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400">
                                    <strong>Cara belajar:</strong> {{ data_get($item, 'how_to_learn', '-') }}
                                </p>

                                <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                                    <strong>Bukti output:</strong> {{ data_get($item, 'proof_output', '-') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada rekomendasi skill.</p>
                        @endforelse
                    </div>
                </article>
            </section>

            <section
                class="mt-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-900/80">
                <h2 class="text-lg font-black text-slate-950 dark:text-white">
                    Roadmap Karier
                </h2>

                <div class="mt-5 grid gap-4 md:grid-cols-3">
                    @foreach ([
                                'next_7_days' => '7 Hari',
                                'next_30_days' => '30 Hari',
                                'next_90_days' => '90 Hari',
                            ] as $key => $label)
                        <div
                            class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5 dark:border-white/10 dark:bg-slate-950/60">
                            <h3 class="font-black text-slate-950 dark:text-white">{{ $label }}</h3>

                            <ul
                                class="mt-3 list-disc space-y-2 pl-5 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                @forelse (data_get($roadmap, $key, []) as $item)
                                    <li>{{ $item }}</li>
                                @empty
                                    <li>Belum ada roadmap.</li>
                                @endforelse
                            </ul>
                        </div>
                    @endforeach
                </div>
            </section>

            <section
                class="mt-6 rounded-[2rem] border border-blue-100 bg-blue-50 p-6 shadow-sm dark:border-blue-900/40 dark:bg-blue-950/20">
                <h2 class="text-lg font-black text-slate-950 dark:text-white">
                    Saran Akhir
                </h2>

                <p class="mt-3 text-sm leading-7 text-slate-700 dark:text-slate-300">
                    {{ data_get($result, 'final_advice', 'Belum ada saran akhir.') }}
                </p>
            </section>
        </section>
    </main>

    @once
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endonce


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('skillChart');

            if (!canvas || typeof Chart === 'undefined') {
                return;
            }

            const dark = document.documentElement.classList.contains('dark');
            const gridColor = dark ? 'rgba(255,255,255,0.08)' : 'rgba(15,23,42,0.08)';
            const textColor = dark ? '#cbd5e1' : '#475569';

            new Chart(canvas, {
                type: 'radar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Level Skill',
                        data: @json($chartData),
                        borderColor: '#4285F4',
                        backgroundColor: 'rgba(66,133,244,0.16)',
                        pointBackgroundColor: '#4285F4',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: textColor,
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        }
                    },
                    scales: {
                        r: {
                            min: 0,
                            max: 100,
                            ticks: {
                                display: false
                            },
                            grid: {
                                color: gridColor
                            },
                            angleLines: {
                                color: gridColor
                            },
                            pointLabels: {
                                color: textColor,
                                font: {
                                    size: 12,
                                    weight: 700
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
