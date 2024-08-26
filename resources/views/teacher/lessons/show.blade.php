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
        <a href="{{ route('teacher.courses.show', $lesson->course->id) }}">{{ $lesson->course->title }}</a>
    </div>

    @if($lesson->module)
    <div class="mb-3">
        <strong>Module:</strong> {{ $lesson->module->title }}
    </div>
    @endif

    @if($lesson->section)
    <div class="mb-3">
        <strong>Section:</strong> {{ $lesson->section->title }}
    </div>
    @endif

    <div class="mt-4">
        <!-- Button to edit the lesson -->
        <a href="{{ route('teacher.lessons.edit', $lesson->id) }}" class="btn btn-warning mb-3">Edit Lesson</a>

        <!-- Button to delete the lesson -->
        <form action="{{ route('teacher.lessons.destroy', $lesson->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mb-3" onclick="return confirm('Are you sure you want to delete this lesson?')">Delete Lesson</button>
        </form>

        <!-- Button to go back to lessons course details -->

        <a href="{{ route('teacher.lessons.index') }}" class="btn btn-secondary mb-3">Back to Lessons</a>
        <a href="{{ route('teacher.courses.show', $lesson->course->id) }}" class="btn btn-secondary mb-3">Back to Course</a>
    </div>

</div>
@endsection
