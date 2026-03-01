@extends('layouts.app')

@section('content')

<h2>Assignments</h2>

@foreach($assignments as $assignment)

    @php
        $submission = \App\Models\AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', auth()->id())
            ->first();
    @endphp

    <div style="border:1px solid #ddd; padding:20px; margin-bottom:20px; border-radius:10px;">

        <h4>{{ $assignment->title }}</h4>
        <p>{{ $assignment->description }}</p>

        @if($submission && $submission->status == 'graded')

            @php
                $marks = $assignment->marks ?? 0;
                $score = $submission->score ?? 0;

                $percentage = $marks > 0
                    ? round(($score / $marks) * 100, 2)
                    : 0;
            @endphp

            <span style="padding:8px 15px; border-radius:20px; background:#d4edda; color:#155724;">
                {{ $percentage >= 50 ? 'Passed' : 'Failed' }} · {{ $percentage }}%
            </span>

            <a href="{{ route('assignment.result', $submission->id) }}"
               style="margin-left:15px; padding:8px 15px; background:#1d6f6f; color:white; text-decoration:none; border-radius:5px;">
               View Results
            </a>

        @elseif($submission)

            <span style="padding:8px 15px; border-radius:20px; background:#fff3cd; color:#856404;">
                Submitted · Waiting for grading
            </span>

        @else

            <a href="{{ route('assignment.show', $assignment->id) }}"
               style="padding:8px 15px; background:#007bff; color:white; text-decoration:none; border-radius:5px;">
               Submit Assignment
            </a>

        @endif

    </div>

@endforeach

@endsection