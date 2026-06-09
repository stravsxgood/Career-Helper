<?php

namespace App\Services;

use App\Models\AiAnalyses;

class CareerAnalysisService
{
    public function __construct(
        protected GeminiService $geminiService,
        protected PromptBuilderService $promptBuilderService
    ) {}

    public function analyze(array $data): AiAnalyses
    {
        $prompt = $this->promptBuilderService->buildCareerAnalysisPrompt($data);

        $responseText = $this->geminiService->generateText($prompt);

        $decodedResult = $this->parseJsonResponse($responseText);

        return AiAnalyses::create([
            'type' => 'career_analysis',
            'input_json' => $data,
            'output_json' => $decodedResult,
            'model' => config('services.gemini.model'),
            'status' => 'completed',
        ]);
    }

    private function parseJsonResponse(string $responseText): array
    {
        $cleaned = trim($responseText);

        // Ambil isi JSON dari karakter { pertama sampai } terakhir.
        // Ini aman walaupun response dibungkus ```json ... ```
        $firstBrace = strpos($cleaned, '{');
        $lastBrace = strrpos($cleaned, '}');

        if ($firstBrace !== false && $lastBrace !== false && $lastBrace > $firstBrace) {
            $cleaned = substr($cleaned, $firstBrace, $lastBrace - $firstBrace + 1);
        }

        $decoded = json_decode($cleaned, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'json_error' => json_last_error_msg(),
                'raw_response' => $responseText,
            ];
        }

        return $this->normalizeResult($decoded);
    }

    private function normalizeResult(array $result): array
    {
        // Kalau AI sudah menghasilkan format baru, langsung pakai.
        if (isset($result['profile_summary'])) {
            return $result;
        }

        // Kalau AI masih menghasilkan format lama:
        // analisis_skill, analisis_cv, rekomendasi_role, skill_gap, roadmap_karier
        return [
            'profile_summary' => [
                'summary' => data_get(
                    $result,
                    'analisis_cv.kesesuaian_target',
                    'Analisis profil berhasil dibuat berdasarkan CV dan input user.'
                ),
                'career_stage' => 'entry_level',
                'confidence_level' => 'medium',
                'missing_information' => [],
            ],

            'cv_extracted_data' => [
                'name' => '',
                'education' => [],
                'experience' => [],
                'tools' => [],
                'certifications' => [],
                'projects' => [],
            ],

            'hard_skill_analysis' => collect(data_get($result, 'analisis_skill.kekuatan', []))
                ->map(function ($item) {
                    return [
                        'skill' => $item,
                        'estimated_level' => 'beginner',
                        'is_verified' => true,
                        'evidence' => 'Ditemukan dari CV atau input user.',
                        'career_relevance' => 'Relevan dengan target pekerjaan user.',
                        'improvement_note' => 'Perkuat skill ini dengan bukti project, dokumentasi, atau pengalaman kerja yang lebih spesifik.',
                    ];
                })
                ->values()
                ->toArray(),

            'soft_skill_analysis' => [],

            'recommended_roles' => collect(data_get($result, 'rekomendasi_role', []))
                ->map(function ($role) {
                    return [
                        'role' => $role,
                        'field' => 'Belum diklasifikasikan',
                        'fit_score' => 70,
                        'fit_level' => 'medium',
                        'why_it_fits' => 'Role ini direkomendasikan berdasarkan CV dan input user.',
                        'matched_skills' => [],
                        'missing_skills' => [],
                        'next_steps' => [
                            'Perkuat CV dengan bukti pengalaman yang lebih spesifik.',
                            'Tambahkan project atau portfolio yang relevan dengan role ini.',
                        ],
                    ];
                })
                ->values()
                ->toArray(),

            'cv_feedback' => [
                'cv_score' => 60,
                'strengths' => data_get($result, 'analisis_skill.kekuatan', []),
                'weaknesses' => data_get($result, 'analisis_skill.kelemahan', []),
                'improvement_suggestions' => [
                    data_get($result, 'analisis_cv.kualitas_data', 'CV perlu dibuat lebih spesifik dan berbasis bukti.'),
                ],
                'better_profile_summary' => data_get($result, 'analisis_cv.kesesuaian_target', ''),
                'better_experience_bullets' => [],
            ],

            'skill_recommendations' => collect(data_get($result, 'skill_gap', []))
                ->map(function ($skill) {
                    return [
                        'skill' => $skill,
                        'priority' => 'medium',
                        'reason' => 'Skill ini termasuk gap yang perlu ditingkatkan untuk target pekerjaan user.',
                        'how_to_learn' => 'Pelajari konsep dasarnya, praktikkan dalam project kecil, lalu dokumentasikan hasilnya.',
                        'proof_output' => 'Buat project, catatan belajar, sertifikat, atau portfolio yang membuktikan skill ini.',
                    ];
                })
                ->values()
                ->toArray(),

            'career_roadmap' => [
                'next_7_days' => [
                    'Rapikan CV agar pengalaman dan skill lebih spesifik.',
                    'Identifikasi skill gap utama dari hasil analisis.',
                ],
                'next_30_days' => [
                    data_get($result, 'roadmap_karier.0-6_bulan', 'Perkuat portfolio dan skill utama.'),
                ],
                'next_90_days' => [
                    data_get($result, 'roadmap_karier.6-18_bulan', 'Mulai melamar pekerjaan yang relevan dan evaluasi hasil lamaran.'),
                ],
            ],

            'final_advice' => data_get(
                $result,
                'roadmap_karier.18_bulan_ke_atas',
                'Fokus pada portfolio, skill gap, dan konsistensi melamar pekerjaan.'
            ),
        ];
    }
}
