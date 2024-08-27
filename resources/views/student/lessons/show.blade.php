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
        <a href="{{ route('student.courses.show', $lesson->course->id) }}">{{ $lesson->course->title }}</a>
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

    <div class="mt-4">

        <!-- Button to go back to lessons course details -->

        <a href="{{ route('student.lessons.index') }}" class="btn btn-secondary mb-3">Back to Lessons</a>
        <a href="{{ route('student.courses.show', $lesson->course->id) }}" class="btn btn-secondary mb-3">Back to Course</a>
    </div>

</div>
@endsection
