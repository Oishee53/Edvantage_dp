<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Result - {{ $submission->assignment->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f9fafb;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Header Card */
        .result-header {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            text-align: center;
        }

        .assignment-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0E1B33;
            margin-bottom: 0.375rem;
        }

        .result-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 700;
            margin: 0.75rem 0;
            border: 2px solid;
        }

        .result-pass {
            background: #f0fdf4;
            color: #166534;
            border-color: #bbf7d0;
        }

        .result-fail {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fecaca;
        }

        /* Score Grid */
        .score-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin: 1rem 0;
        }

        .score-item {
            text-align: center;
            padding: 0.875rem;
            background: #f9fafb;
            border-radius: 6px;
            border: 1px solid #f3f4f6;
        }

        .score-label {
            font-size: 0.7rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 0.375rem;
        }

        .score-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0E1B33;
        }

        /* Action Button */
        .actions-card {
            background: white;
            border-radius: 8px;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .btn-primary {
            display: block;
            width: 100%;
            padding: 0.95rem 1rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.95rem;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
            background: #0E1B33;
            color: white;
            border: 2px solid #0E1B33;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #1a2645;
            border-color: #1a2645;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(14, 27, 51, 0.15);
        }

        @media (max-width: 768px) {
            .score-grid {
                grid-template-columns: 1fr;
            }
            .container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

@php
    $marks = $submission->assignment->marks ?? 0;
    $score = $submission->score ?? 0;

    $percentage = $marks > 0
        ? round(($score / $marks) * 100, 2)
        : 0;
@endphp

    <div class="container">

        <!-- Result Header Card -->
        <div class="result-header">
            <h1 class="assignment-title">{{ $submission->assignment->title }}</h1>

            @if($percentage >= 50)
                <div class="result-badge result-pass">PASSED</div>
            @else
                <div class="result-badge result-fail">FAILED</div>
            @endif

            <!-- Score Grid -->
            <div class="score-grid">
                <div class="score-item">
                    <div class="score-label">Your Score</div>
                    <div class="score-value">{{ $score }}/{{ $marks }}</div>
                </div>
                <div class="score-item">
                    <div class="score-label">Percentage</div>
                    <div class="score-value">{{ $percentage }}%</div>
                </div>
                <div class="score-item">
                    <div class="score-label">Passing</div>
                    <div class="score-value">50%</div>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="actions-card">
            <a href="javascript:history.back()" class="btn-primary">
                Back to Course
            </a>
        </div>

    </div>

</body>
</html>