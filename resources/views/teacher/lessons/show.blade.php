@extends('layouts.app')

@section('title', 'Lesson Details - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>{{ $lesson->title }}</h1>

    <!-- Lesson Content -->
    <p>{{ $lesson->content }}</p>

    <!-- Lesson Information -->
    <div class="mb-3">
        <strong>Course:</strong>
        <a href="{{ route('teacher.courses.show', $lesson->course->id) }}">{{ $lesson->course->name }}</a>
    </div>

    @if($lesson->section)
    <div class="mb-3">
        <strong>Section:</strong> {{ $lesson->section->name }}
    </div>
    @endif

    @if($lesson->module)
    <div class="mb-3">
        <strong>Module:</strong> {{ $lesson->module->name }}
    </div>
    @endif

    <!-- Lesson Videos -->
    @if($videos->count() > 0)
    <div class="mt-4">
        <h3>Videos</h3>
        @foreach($videos as $video)
        <div class="mb-3">
            <h5>{{ $video->title }}</h5>
            <p>{{ $video->description }}</p>

            @php
            $url = $video->url;
            $videoId = null;

            // Extract video ID for YouTube
            if (str_contains($url, 'youtube.com/watch?v=')) {
            parse_str(parse_url($url, PHP_URL_QUERY), $query);
            $videoId = $query['v'] ?? null;
            } elseif (str_contains($url, 'youtu.be/')) {
            $videoId = basename($url);
            }
            @endphp

            @if($videoId)
            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            @else
            <p>Unsupported video format or URL.</p>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="mt-4">
        <p>No videos available for this lesson.</p>
    </div>
    @endif

    <!-- Lesson Documents -->

    <div class="mt-4">
        <!-- Button to edit the lesson -->
        <a href="{{ route('teacher.lessons.edit', $lesson->id) }}" class="btn btn-warning mb-3">Edit Lesson</a>

        <!-- Button to delete the lesson -->
        <form action="{{ route('teacher.lessons.destroy', $lesson->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mb-3" onclick="return confirm('Are you sure you want to delete this lesson?')">Delete Lesson</button>
        </form>
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-4">
        @if ($previousLesson)
        <a href="{{ route('teacher.lessons.show', $previousLesson->id) }}" class="btn btn-primary">Previous Lesson</a>
        @endif

        @if ($nextLesson)
        <a href="{{ route('teacher.lessons.show', $nextLesson->id) }}" class="btn btn-primary">Next Lesson</a>
        @endif
    </div>

    <!-- Button to go back to lessons course details -->
    <div class="mt-4">
        <a href="{{ route('teacher.lessons.index') }}" class="btn btn-secondary mb-3">Back to Lessons</a>
        <a href="{{ route('teacher.courses.show', $lesson->course->id) }}" class="btn btn-secondary mb-3">Back to Course</a>
    </div>

</div>
@endsection
