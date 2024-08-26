@extends('layouts.app')

@section('title', 'Course Details - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>{{ $course->name }}</h1>

    <!-- Course Description -->
    <p>{{ $course->description }}</p>

    <!-- Lessons associated with this course -->
    <h2 class="mt-5">Lessons</h2>

    @if ($course->lessons->isEmpty())
    <p>No lessons available for this course.</p>
    @else
    <ul class="list-group">
        @foreach ($course->lessons as $lesson)
        <li class="list-group-item">
            <a href="{{ route('teacher.lessons.show', $lesson->id) }}">{{ $lesson->title }}</a>
        </li>
        @endforeach
    </ul>
    <!-- Button to go back to the courses list -->
    <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary">Back to Courses</a>
    @endif
</div>
@endsection
