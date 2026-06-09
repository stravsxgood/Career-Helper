<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class GeminiService
{
    public function generateText(string $prompt): string
    {
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model');

        if (!$apiKey) {
            throw new \Exception('Gemini API key belum diatur di file .env');
        }

        $response = Http::timeout(60)
            ->retry(2, 1000)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $apiKey,
            ])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                        ],
                    ],
                ],
            ]);

        if ($response->failed()) {
            throw new RequestException($response);
        }

        return $response->json('candidates.0.content.parts.0.text')
            ?? 'Gemini tidak mengembalikan jawaban.';
    }
}
