<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    /**
     * Convert text into a vector embedding
     * Uses: gemini-embedding-001 (confirmed available on this API key)
     */
    public function getEmbedding(string $text): array
    {
        $response = Http::timeout(30)->post(
            "{$this->baseUrl}/models/gemini-embedding-001:embedContent?key={$this->apiKey}",
            [
                'model'   => 'models/gemini-embedding-001',
                'content' => [
                    'parts' => [['text' => $text]]
                ]
            ]
        );

        if (!$response->successful()) {
            Log::error('Gemini embedding error', ['body' => $response->body()]);
            throw new \Exception('Failed to generate embedding: ' . $response->body());
        }

        return $response->json('embedding.values');
    }

    /**
     * Generate a grounded answer using context chunks + question.
     * Tries gemini-2.0-flash first, falls back to gemini-2.0-flash-lite on quota errors.
     */
    public function generateAnswer(string $question, array $contextChunks, string $courseTitle): string
    {
        $context = collect($contextChunks)
            ->pluck('content')
            ->map(fn($c, $i) => "[Source " . ($i + 1) . "]\n" . $c)
            ->join("\n\n---\n\n");

        $prompt = <<<PROMPT
You are an intelligent study assistant for the course: "{$courseTitle}".

Your job is to answer the student's question using ONLY the provided course materials below.
- Be clear, concise, and educational.
- If the answer is in the materials, answer it confidently.
- If the materials don't contain enough information, say: "I couldn't find enough information in the uploaded course materials to answer this. Please refer to your instructor."
- Do NOT make up information that isn't in the sources.
- Format your answer nicely with bullet points or numbered lists when appropriate.

=== COURSE MATERIALS ===
{$context}

=== STUDENT QUESTION ===
{$question}

=== YOUR ANSWER ===
PROMPT;

        $payload = [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ],
            'generationConfig' => [
                'temperature'     => 0.3,
                'maxOutputTokens' => 1024,
            ]
        ];

        // Try models in order — fall back if quota exceeded
        $models = [
            'gemini-2.0-flash-lite',
            'gemini-2.0-flash',
            'gemini-2.5-flash',
        ];

        $lastError = null;
        foreach ($models as $model) {
            $response = Http::timeout(60)->post(
                "{$this->baseUrl}/models/{$model}:generateContent?key={$this->apiKey}",
                $payload
            );

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text') ?? 'No response generated.';
            }

            $status = $response->json('error.code');

            // If quota exceeded, try next model
            if ($status === 429) {
                Log::warning("Gemini quota exceeded for {$model}, trying next model.");
                $lastError = $response->body();
                continue;
            }

            // Any other error — throw immediately
            Log::error('Gemini chat error', ['model' => $model, 'body' => $response->body()]);
            throw new \Exception('Failed to generate answer: ' . $response->body());
        }

        // All models exhausted
        throw new \Exception('All Gemini models are currently rate-limited. Please try again in a minute.');
    }
}