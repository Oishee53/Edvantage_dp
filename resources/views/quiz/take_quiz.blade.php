@extends('layouts.app')

@section('title', 'Take Quiz - ' . $course->name)

@section('content')
<div class="quiz-container">
    <div class="quiz-header">
        <h2>{{ $course->name }}</h2>
        <h4>Module: {{ $moduleNumber }}</h4>
        <h5>{{ $quiz->title ?? 'Quiz' }}</h5>
    </div>

    @if($questions->count() > 0)
        <form action="{{ route('user.quiz.submit', ['course' => $course->id, 'moduleNumber' => $moduleNumber]) }}" method="POST">
            @csrf

            @foreach($questions as $index => $question)
                <div class="quiz-card">
                    <p class="quiz-question">
                        Q{{ $index + 1 }}. {{ $question->question_text }}
                    </p>

                    <div class="options-list">
                        @foreach($question->options as $option)
                            <label class="option-item">
                                <input type="radio" 
                                       name="answers[{{ $question->id }}]" 
                                       value="{{ $option->id }}" 
                                       required>
                                <span class="option-letter">
                                    {{ chr(65 + $loop->index) }}
                                </span>
                                <span class="option-text">{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="submit-btn">Submit Quiz</button>
        </form>
    @else
        <p class="no-questions">No questions found for this quiz.</p>
    @endif
</div>

{{-- Custom CSS --}}
<style>



    .quiz-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 20px;
        font-family: 'Segoe UI', sans-serif;
    }

    .quiz-header {
        text-align: center;
        margin-bottom: 25px;
    }
    .quiz-header h2 {
        color: #0a2647;
        font-weight: 700;
    }
    .quiz-header h4, .quiz-header h5 {
        color: #555;
        margin-top: 5px;
    }

    .quiz-card {
        background: #fff;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: 1px solid #e0e6ed;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .quiz-question {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #0a2647;
    }

   /* Default option */
.option-item {
    display: flex;
    align-items: center;
    background: #fff;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #dce3ed;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.2s ease;
}

/* Hover effect */
.option-item:hover {
    border-color: #007bff;
}

/* Hide the radio button */
.option-item input {
    display: none;
}

/* Option letter (A, B, C, D) */
.option-letter {
    background: #f0f4fa;
    color: #0a2647;
    font-weight: bold;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

/* Selected state */
.option-item:has(input:checked) {
    background: #eaf3ff;              /* fill with light blue */
    border: 2px solid #0a2647;        /* outline in blue */
}
.option-item:has(input:checked) .option-letter {
    background: #0a2647;
    color: #fff;
}
.option-item:has(input:checked) .option-text {
    color: #0a2647;
    font-weight: 600;
}


    .submit-btn {
        width: 17%;
        padding: 5px;
        background: #0a2647;
        color: white;
        font-size: 1.1rem;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
    }
    .submit-btn:hover {
        background: #0a2647;;
        transform: scale(1.02);
    }

    .no-questions {
        text-align: center;
        color: #c0392b;
        font-weight: bold;
        font-size: 1.1rem;
    }
</style>
@endsection
