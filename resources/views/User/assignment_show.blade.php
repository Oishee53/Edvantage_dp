@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <h2>{{ $assignment->title }}</h2>
    <p>{{ $assignment->description }}</p>

    <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($assignment->deadline)->format('M d, Y - g:i A') }}</p>

    <hr>

    <form action="{{ route('assignment.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

        <div class="mb-3">
            <label>Upload Your Answer</label>
            <input type="file" name="pdf" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Submit Assignment
        </button>
    </form>

</div>

@endsection