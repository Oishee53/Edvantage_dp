<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Courses</title>
</head>
<body>
    @auth
    <h2>Manage Resources</h2>

    @if($courses->isEmpty())
        <p>No courses available.</p>
    @else
        <table border="1" cellpadding="8">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Videos</th>
                <th>Video Length</th>
                <th>Total Duration</th>
                <th>Price (৳)</th>
                <th>Added</th>
            </tr>

            @foreach($courses as $course)
            <tr>
                <td>
                    <a href="/admin_panel/manage_resources/{{ $course->id }}/view">{{ $course->title }}</a>
                </td>
                <td>{{ $course->description }}</td>
                <td>{{ $course->video_count }}</td>
                <td>{{ $course->approx_video_length }} mins</td>
                <td>{{ $course->total_duration }} hrs</td>
                <td>{{ $course->price }}</td>
                <td>{{ $course->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </table>
    @endif

    <br>
    @if(auth()->user()->role === 2)
    <a href="/admin_panel/manage_resources">← Back to Home Page</a>
    @elseif(auth()->user()->role === 3)
        <a href="/instructor/manage_resources">← Back to Home Page</a>
    @endif
    @else
        <p>You are not logged in. <a href="/">Go to Login</a></p>
@endauth
</body>
</html>
