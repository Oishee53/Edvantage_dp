<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Enrollment;
use App\Models\NotebookChunk;
use App\Models\NotebookConversation;
use App\Models\NotebookDocument;
use App\Services\DocumentProcessingService;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class NotebookController extends Controller
{
    public function __construct(
        private GeminiService $gemini,
        private DocumentProcessingService $processor
    ) {}

    /**
     * Show the Notebook page for a specific course
     */
    public function index(Request $request, $courseId)
    {
        $course = Courses::findOrFail($courseId);
        $user   = auth()->user();

        // Check enrollment using Enrollment model
        $isEnrolled = Enrollment::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->exists();

        if (!$isEnrolled) {
            abort(403, 'You must be enrolled in this course to use the notebook.');
        }

        // Student's uploaded documents for this course
        $documents = NotebookDocument::where('course_id', $courseId)
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // Student's past conversations for this course
        $conversations = NotebookConversation::where('course_id', $courseId)
            ->where('user_id', $user->id)
            ->latest()
            ->take(50)
            ->get()
            ->reverse()
            ->values();

        return view('notebook.index', compact('course', 'documents', 'conversations'));
    }

    /**
     * Handle document upload from student
     */
    public function upload(Request $request, $courseId)
    {
        try {
            $request->validate([
                'document' => 'required|file|mimes:pdf,txt,docx|max:20480', // 20MB max
                'title'    => 'required|string|max:255',
            ]);

            $course = Courses::findOrFail($courseId);
            $user   = auth()->user();

            // Enrollment check using Enrollment model
            $isEnrolled = Enrollment::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->exists();

            if (!$isEnrolled) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be enrolled in this course.'
                ], 403);
            }

            $file     = $request->file('document');
            $ext      = $file->getClientOriginalExtension();
            $filePath = $file->store("notebooks/{$courseId}/{$user->id}", 'local');

            // Create document record
            $document = NotebookDocument::create([
                'course_id' => $courseId,
                'user_id'   => $user->id,
                'title'     => $request->title,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $ext,
                'status'    => 'processing',
            ]);

            // Process the document (extract text → chunk → embed)
            $this->processor->processDocument($document);

            return response()->json([
                'success'  => true,
                'message'  => 'Document uploaded and processed successfully!',
                'document' => [
                    'id'          => $document->fresh()->id,
                    'title'       => $document->title,
                    'file_name'   => $document->file_name,
                    'file_type'   => $document->file_type,
                    'chunk_count' => $document->fresh()->chunk_count,
                    'status'      => $document->fresh()->status,
                ],
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . collect($e->errors())->flatten()->implode(' '),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Notebook upload error', [
                'course_id' => $courseId,
                'user_id'   => auth()->id(),
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process document: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle student question → RAG → Gemini answer
     */
    public function ask(Request $request, $courseId)
    {
        try {
            $request->validate([
                'question' => 'required|string|max:1000',
            ]);

            $course = Courses::findOrFail($courseId);
            $user   = auth()->user();

            // Enrollment check using Enrollment model
            $isEnrolled = Enrollment::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->exists();

            if (!$isEnrolled) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be enrolled in this course.'
                ], 403);
            }

            // Check there are documents to search
            $hasChunks = NotebookChunk::where('course_id', $courseId)->exists();
            if (!$hasChunks) {
                return response()->json([
                    'success' => false,
                    'message' => 'No documents have been uploaded yet. Please upload your course materials first.',
                ], 422);
            }

            $question = $request->question;

            // 1. Embed the question
            $questionEmbedding = $this->gemini->getEmbedding($question);

            // 2. Find the most relevant chunks (cosine similarity in PHP)
            $topChunks = DocumentProcessingService::findTopChunks(
                $questionEmbedding,
                $courseId,
                topN: 5
            );

            if (empty($topChunks)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No relevant content found. Try rephrasing your question.',
                ], 422);
            }

            // 3. Generate grounded answer via Gemini
            $answer = $this->gemini->generateAnswer($question, $topChunks, $course->title);

            // 4. Save conversation
            $conversation = NotebookConversation::create([
                'course_id'     => $courseId,
                'user_id'       => $user->id,
                'question'      => $question,
                'answer'        => $answer,
                'source_chunks' => collect($topChunks)->pluck('id')->toArray(),
            ]);

            return response()->json([
                'success'         => true,
                'question'        => $question,
                'answer'          => $answer,
                'sources'         => collect($topChunks)->map(fn($c) => [
                    'content' => substr($c['content'], 0, 200) . '...',
                ])->toArray(),
                'conversation_id' => $conversation->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Notebook ask error', [
                'course_id' => $courseId,
                'user_id'   => auth()->id(),
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate answer: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a document and its chunks
     */
    public function deleteDocument(Request $request, $courseId, $documentId)
    {
        try {
            $document = NotebookDocument::where('id', $documentId)
                ->where('course_id', $courseId)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Delete file from storage
            Storage::disk('local')->delete($document->file_path);

            // Cascade deletes chunks via DB foreign key
            $document->delete();

            return response()->json([
                'success' => true,
                'message' => 'Document deleted successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Document delete error', [
                'document_id' => $documentId,
                'error'       => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete document.'
            ], 500);
        }
    }

    /**
     * Clear chat history for this student + course
     */
    public function clearHistory(Request $request, $courseId)
    {
        try {
            NotebookConversation::where('course_id', $courseId)
                ->where('user_id', auth()->id())
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Chat history cleared successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Clear history error', [
                'course_id' => $courseId,
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to clear history.'
            ], 500);
        }
    }
}