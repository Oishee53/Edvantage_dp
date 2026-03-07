<?php

namespace App\Services;

use App\Models\NotebookChunk;
use App\Models\NotebookDocument;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser as PdfParser;

class DocumentProcessingService
{
    private GeminiService $gemini;
    private int $chunkSize = 600;    // words per chunk
    private int $chunkOverlap = 80;  // overlap words to preserve context across chunks

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Main entry: extract text → chunk → embed → store
     */
    public function processDocument(NotebookDocument $document): void
    {
        try {
            // 1. Extract raw text from file
            $text = $this->extractText($document);

            if (empty(trim($text))) {
                throw new \Exception('No readable text found in document.');
            }

            // 2. Split into overlapping chunks
            $chunks = $this->splitIntoChunks($text);

            // 3. Embed each chunk and save to DB
            foreach ($chunks as $index => $chunkText) {
                $embedding = $this->gemini->getEmbedding($chunkText);

                NotebookChunk::create([
                    'document_id' => $document->id,
                    'course_id'   => $document->course_id,
                    'content'     => $chunkText,
                    'embedding'   => json_encode($embedding),
                    'chunk_index' => $index,
                ]);

                // Small delay to avoid hitting Gemini rate limits (60 req/min free tier)
                if ($index > 0 && $index % 50 === 0) {
                    sleep(1);
                }
            }

            // 4. Mark document as ready
            $document->update([
                'chunk_count' => count($chunks),
                'status'      => 'ready',
            ]);

        } catch (\Exception $e) {
            Log::error('Document processing failed', [
                'document_id' => $document->id,
                'error'       => $e->getMessage(),
            ]);

            $document->update(['status' => 'failed']);
            throw $e;
        }
    }

    /**
     * Extract plain text from PDF or TXT file
     * FIX: Laravel 11 stores local disk files under storage/app/private/ not storage/app/
     */
    private function extractText(NotebookDocument $document): string
    {
        $fullPath = storage_path('app/private/' . $document->file_path);

        return match($document->file_type) {
            'pdf'  => $this->extractFromPdf($fullPath),
            'txt'  => file_get_contents($fullPath),
            'docx' => $this->extractFromDocx($fullPath),
            default => throw new \Exception("Unsupported file type: {$document->file_type}"),
        };
    }

    private function extractFromPdf(string $path): string
    {
        $parser = new PdfParser();
        $pdf    = $parser->parseFile($path);
        return $pdf->getText();
    }

    private function extractFromDocx(string $path): string
    {
        // Extract text from docx (it's a zip with XML inside)
        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \Exception('Cannot open docx file.');
        }

        $xml  = $zip->getFromName('word/document.xml');
        $zip->close();

        // Strip XML tags to get plain text
        $text = strip_tags(str_replace('</w:p>', "\n", $xml));
        return html_entity_decode($text);
    }

    /**
     * Split text into overlapping word chunks for better context coverage
     */
    private function splitIntoChunks(string $text): array
    {
        // Normalize whitespace
        $text  = preg_replace('/\s+/', ' ', trim($text));
        $words = explode(' ', $text);
        $total = count($words);

        $chunks = [];
        $start  = 0;

        while ($start < $total) {
            $end        = min($start + $this->chunkSize, $total);
            $chunkWords = array_slice($words, $start, $end - $start);
            $chunks[]   = implode(' ', $chunkWords);

            // Move forward, but overlap to maintain context
            $start += ($this->chunkSize - $this->chunkOverlap);
        }

        return array_filter($chunks, fn($c) => strlen(trim($c)) > 50);
    }

    /**
     * Cosine similarity between two vectors (PHP implementation)
     * Returns value between -1 and 1 (1 = identical direction)
     */
    public static function cosineSimilarity(array $a, array $b): float
    {
        $dot    = 0.0;
        $magA   = 0.0;
        $magB   = 0.0;

        foreach ($a as $i => $val) {
            $dot  += $val * ($b[$i] ?? 0);
            $magA += $val * $val;
            $magB += ($b[$i] ?? 0) * ($b[$i] ?? 0);
        }

        $magnitude = sqrt($magA) * sqrt($magB);
        return $magnitude > 0 ? $dot / $magnitude : 0.0;
    }

    /**
     * Find top-N most relevant chunks for a query embedding
     */
    public static function findTopChunks(array $queryEmbedding, $courseId, int $topN = 5): array
    {
        // Load all chunks for this course (only content + embedding columns for performance)
        $chunks = NotebookChunk::where('course_id', $courseId)
            ->select('id', 'content', 'embedding', 'document_id', 'chunk_index')
            ->get();

        if ($chunks->isEmpty()) {
            return [];
        }

        // Score each chunk
        $scored = $chunks->map(function ($chunk) use ($queryEmbedding) {
            $embedding = is_string($chunk->embedding)
                ? json_decode($chunk->embedding, true)
                : $chunk->embedding;

            return [
                'chunk'      => $chunk,
                'similarity' => self::cosineSimilarity($queryEmbedding, $embedding),
            ];
        });

        // Sort by similarity descending, return top N
        return $scored
            ->sortByDesc('similarity')
            ->take($topN)
            ->pluck('chunk')
            ->values()
            ->toArray();
    }
}