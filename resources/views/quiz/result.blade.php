@extends('layouts.app')

@section('title', 'Quiz Result')

@section('content')
<div class="quiz-result-wrapper">
    <div class="quiz-result-card">
        <!-- Top bar -->
        <div class="result-header">
            <h3>{{ $quiz->title }}</h3>
        </div>

        <!-- Content -->
        <div class="result-body">
            <h2>🎉 Congratulations!</h2>
            <p>You’ve completed the quiz. We hope you’ve learned something new today.</p>
            <p>Your quiz score is:</p>

            <!-- Circular Score -->
            <div class="score-circle">
                <span>{{ $submission->score }}</span>
            </div>
            <p class="pass-message">
                You scored {{ $submission->score }} out of {{ $quiz->questions->count() }}
            </p>
        </div>

        <!-- Actions -->
        <div class="result-actions">

            <a href="{{ route('courses.enrolled', $quiz->course_id) }}" class="btn-finish">Finish</a>
        </div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
    .quiz-result-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        background: #f7f9fc;
        font-family: 'Segoe UI', sans-serif;
    }

    .quiz-result-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        max-width: 600px;
        width: 100%;
        text-align: center;
        overflow: hidden;
    }

    .result-header {
        background: #0a2647;
        color: #fff;
        padding: 15px;
        font-size: 1.2rem;
        font-weight: bold;
    }

    .result-body {
        padding: 30px 20px;
    }

    .result-body h2 {
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .result-body p {
        color: #555;
        margin-bottom: 15px;
    }

    /* Circular Score */
    .score-circle {
        width: 120px;
        height: 120px;
        margin: 20px auto;
        border-radius: 50%;
        border: 8px solid #0a2647;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 2rem;
        font-weight: bold;
        color: #0a2647;
        background: #f0faff;
    }

    .pass-message {
        margin-top: 10px;
        font-weight: 500;
        color: #333;
    }

    /* Buttons */
    .result-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
        padding: 20px;
    }

    .btn-retake, .btn-finish {
        text-decoration: none;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: bold;
        border: 2px solid #0a2647;
        transition: 0.3s ease;
    }

   
 

    .btn-finish {
        background: #0a2647;
        color: #fff;
    }
    .btn-finish:hover {
        background: #0a2647;
    }
</style>
@endsection
