<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CareerAnalysisService;

class CareerAnalysisController extends Controller
{
    public function analyze(Request $request, CareerAnalysisService $careerAnalysisService)
    {
        $validated = $request->validate([
            'hard_skills' => ['required', 'string'],
            'soft_skills' => ['required', 'string'],
            'experience'  => ['nullable', 'string'],
        ]);

        try {
            $result = $careerAnalysisService->analyze($validated);

            return response()->json([
                'message' => 'Career analysis berhasil dibuat.',
                'data'    => $result->output_json, // ✅ Langsung akses property model
            ]);

        } catch (\RuntimeException $e) {
            return response()->json([
                'message' => 'Analisis gagal, silakan coba lagi.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
