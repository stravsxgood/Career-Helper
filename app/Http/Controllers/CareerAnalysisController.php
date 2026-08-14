<?php

namespace App\Http\Controllers;

use App\Services\CareerAnalysisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class CareerAnalysisController extends Controller
{
    /**
     * Menjalankan analisis karir berbasis AI berdasarkan skill dan pengalaman.
     */
    public function analyze(Request $request, CareerAnalysisService $careerAnalysisService): JsonResponse
    {
        $validated = $request->validate([
            'hard_skills' => ['required', 'string'],
            'soft_skills' => ['required', 'string'],
            'experience' => ['nullable', 'string'],
        ]);

        try {
            $result = $careerAnalysisService->analyze($validated);

            return response()->json([
                'success' => true,
                'message' => 'Career analysis berhasil dibuat.',
                'data' => $result->output_json,
            ]);
        } catch (RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Analisis gagal, silakan coba lagi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
