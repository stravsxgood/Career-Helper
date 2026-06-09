@php
    $aiResult = $result ?? $analysis->output_json ?? [];

    if (is_string($aiResult)) {
        $clean = trim($aiResult);
        $clean = preg_replace('/^```json\s*/', '', $clean);
        $clean = preg_replace('/^```\s*/', '', $clean);
        $clean = preg_replace('/\s*```$/', '', $clean);

        $decoded = json_decode($clean, true);
        $aiResult = json_last_error() === JSON_ERROR_NONE ? $decoded : [];
    }

    if ($aiResult instanceof \Illuminate\Support\Collection) {
        $aiResult = $aiResult->toArray();
    }

    $profile = data_get($aiResult, 'profile_summary', []);
    $cvData = data_get($aiResult, 'cv_extracted_data', []);
    $cvFeedback = data_get($aiResult, 'cv_feedback', []);
    $roles = data_get($aiResult, 'recommended_roles', []);
    $hardSkills = data_get($aiResult, 'hard_skill_analysis', []);
    $softSkills = data_get($aiResult, 'soft_skill_analysis', []);
    $skillRecommendations = data_get($aiResult, 'skill_recommendations', []);
    $roadmap = data_get($aiResult, 'career_roadmap', []);
    $finalAdvice = data_get($aiResult, 'final_advice', '-');

    $mainRole = data_get($roles, '0.role', $analysis->target_role ?? '-');
    $mainScore = data_get($roles, '0.fit_score', data_get($cvFeedback, 'cv_score', 0));
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Career Analysis Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #0f172a;
            font-size: 12px;
            line-height: 1.6;
        }

        .header {
            border-bottom: 4px solid #4285F4;
            padding-bottom: 16px;
            margin-bottom: 22px;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            background: #E8F0FE;
            color: #1a73e8;
            font-weight: bold;
            font-size: 11px;
        }

        h1 {
            margin: 12px 0 4px;
            font-size: 24px;
        }

        h2 {
            margin-top: 22px;
            margin-bottom: 8px;
            font-size: 16px;
            color: #1a73e8;
        }

        h3 {
            margin: 0 0 6px;
            font-size: 13px;
            color: #0f172a;
        }

        .card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 12px;
        }

        .soft-blue {
            background: #f8fbff;
        }

        .soft-green {
            background: #f6fff8;
        }

        .soft-yellow {
            background: #fffdf3;
        }

        .label {
            color: #64748b;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .value {
            font-weight: bold;
            color: #0f172a;
        }

        .score {
            font-size: 34px;
            font-weight: bold;
            color: #4285F4;
            line-height: 1;
        }

        .muted {
            color: #64748b;
        }

        ul {
            margin-top: 6px;
            padding-left: 18px;
        }

        li {
            margin-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .pill {
            display: inline-block;
            padding: 4px 8px;
            margin: 2px 3px 2px 0;
            border-radius: 999px;
            background: #e8f0fe;
            color: #1a73e8;
            font-size: 10px;
            font-weight: bold;
        }

        .footer {
            margin-top: 28px;
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
            color: #64748b;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <span class="badge">Career Helper Report</span>

        <h1>Career Analysis Report</h1>

        <p class="muted">
            Generated at {{ now()->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
        </p>
    </div>

    <div class="card soft-blue">
        <table>
            <tr>
                <td width="65%">
                    <div class="label">Nama</div>
                    <div class="value">{{ data_get($cvData, 'name', '-') }}</div>

                    <br>

                    <div class="label">Target Role Utama</div>
                    <div class="value">{{ $mainRole }}</div>
                </td>

                <td width="35%" align="right">
                    <div class="label">Match Score</div>
                    <div class="score">{{ (int) $mainScore }}%</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="card">
        <table>
            <tr>
                <td width="50%">
                    <div class="label">Career Stage</div>
                    <div class="value">{{ data_get($profile, 'career_stage', '-') }}</div>
                </td>

                <td width="50%">
                    <div class="label">Confidence Level</div>
                    <div class="value">{{ data_get($profile, 'confidence_level', '-') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <h2>Ringkasan Profil</h2>
    <div class="card">
        {{ data_get($profile, 'summary', 'Belum ada ringkasan profil.') }}
    </div>

    <h2>Data CV Terdeteksi</h2>
    <div class="card">
        <div class="label">Education</div>
        <ul>
            @forelse ((array) data_get($cvData, 'education', []) as $item)
                <li>{{ $item }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ul>

        <div class="label">Experience</div>
        <ul>
            @forelse ((array) data_get($cvData, 'experience', []) as $item)
                <li>{{ $item }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ul>

        <div class="label">Projects</div>
        <ul>
            @forelse ((array) data_get($cvData, 'projects', []) as $item)
                <li>{{ $item }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ul>

        <div class="label">Tools</div>
        <p>
            @forelse ((array) data_get($cvData, 'tools', []) as $tool)
                <span class="pill">{{ $tool }}</span>
            @empty
                -
            @endforelse
        </p>
    </div>

    <h2>Feedback CV</h2>
    <div class="card soft-yellow">
        <div class="label">CV Score</div>
        <div class="value">{{ data_get($cvFeedback, 'cv_score', '-') }}/100</div>

        <h3>Strengths</h3>
        <ul>
            @forelse ((array) data_get($cvFeedback, 'strengths', []) as $item)
                <li>{{ $item }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ul>

        <h3>Weaknesses</h3>
        <ul>
            @forelse ((array) data_get($cvFeedback, 'weaknesses', []) as $item)
                <li>{{ $item }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ul>

        <h3>Better Profile Summary</h3>
        <p>{{ data_get($cvFeedback, 'better_profile_summary', '-') }}</p>

        <h3>Improvement Suggestions</h3>
        <ul>
            @forelse ((array) data_get($cvFeedback, 'improvement_suggestions', []) as $item)
                <li>{{ $item }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ul>
    </div>

    <h2>Rekomendasi Role</h2>
    @forelse ($roles as $role)
        <div class="card">
            <h3>
                {{ data_get($role, 'role', '-') }}
                — {{ data_get($role, 'fit_score', '-') }}%
            </h3>

            <p>
                <strong>Fit Level:</strong> {{ data_get($role, 'fit_level', '-') }}
            </p>

            <p>
                {{ data_get($role, 'why_it_fits', '-') }}
            </p>

            <div class="label">Matched Skills</div>
            <p>
                @forelse ((array) data_get($role, 'matched_skills', []) as $skill)
                    <span class="pill">{{ $skill }}</span>
                @empty
                    -
                @endforelse
            </p>

            <div class="label">Missing Skills</div>
            <p>
                @forelse ((array) data_get($role, 'missing_skills', []) as $skill)
                    <span class="pill">{{ $skill }}</span>
                @empty
                    -
                @endforelse
            </p>

            <div class="label">Next Steps</div>
            <ul>
                @forelse ((array) data_get($role, 'next_steps', []) as $step)
                    <li>{{ $step }}</li>
                @empty
                    <li>-</li>
                @endforelse
            </ul>
        </div>
    @empty
        <div class="card">Belum ada rekomendasi role.</div>
    @endforelse

    <h2>Analisis Hard Skill</h2>
    @forelse ($hardSkills as $skill)
        <div class="card">
            <h3>
                {{ data_get($skill, 'skill', '-') }}
                — {{ data_get($skill, 'estimated_level', '-') }}
            </h3>

            <p><strong>Evidence:</strong> {{ data_get($skill, 'evidence', '-') }}</p>
            <p><strong>Career Relevance:</strong> {{ data_get($skill, 'career_relevance', '-') }}</p>
            <p><strong>Improvement:</strong> {{ data_get($skill, 'improvement_note', '-') }}</p>
        </div>
    @empty
        <div class="card">{{ $analysis->hard_skills ?? '-' }}</div>
    @endforelse

    <h2>Analisis Soft Skill</h2>
    @forelse ($softSkills as $skill)
        <div class="card">
            <h3>{{ data_get($skill, 'skill', '-') }}</h3>

            <p><strong>Evidence:</strong> {{ data_get($skill, 'evidence', '-') }}</p>
            <p><strong>How to Prove:</strong> {{ data_get($skill, 'how_to_prove', '-') }}</p>
            <p><strong>Career Relevance:</strong> {{ data_get($skill, 'career_relevance', '-') }}</p>
        </div>
    @empty
        <div class="card">{{ $analysis->soft_skills ?? '-' }}</div>
    @endforelse

    <h2>Rekomendasi Skill</h2>
    @forelse ($skillRecommendations as $skill)
        <div class="card">
            <h3>
                {{ data_get($skill, 'skill', '-') }}
                — Priority: {{ data_get($skill, 'priority', '-') }}
            </h3>

            <p><strong>Reason:</strong> {{ data_get($skill, 'reason', '-') }}</p>
            <p><strong>How to Learn:</strong> {{ data_get($skill, 'how_to_learn', '-') }}</p>
            <p><strong>Proof Output:</strong> {{ data_get($skill, 'proof_output', '-') }}</p>
        </div>
    @empty
        <div class="card">Belum ada rekomendasi skill.</div>
    @endforelse

    <h2>Roadmap Karier</h2>
    <div class="card soft-green">
        <div class="label">Next 7 Days</div>
        <ul>
            @forelse ((array) data_get($roadmap, 'next_7_days', []) as $item)
                <li>{{ $item }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ul>

        <div class="label">Next 30 Days</div>
        <ul>
            @forelse ((array) data_get($roadmap, 'next_30_days', []) as $item)
                <li>{{ $item }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ul>

        <div class="label">Next 90 Days</div>
        <ul>
            @forelse ((array) data_get($roadmap, 'next_90_days', []) as $item)
                <li>{{ $item }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ul>
    </div>

    <h2>Saran Akhir</h2>
    <div class="card">
        {{ $finalAdvice }}
    </div>

    <div class="footer">
        Report ini dibuat otomatis oleh Career Helper.
    </div>
</body>
</html>
