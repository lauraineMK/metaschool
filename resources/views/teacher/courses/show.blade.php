@extends('layouts.app')

@section('title', 'Course Details - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>{{ $course->name }}</h1>

    <!-- Course Description -->
    <p>{{ $course->description }}</p>

    <!-- Button to edit the course -->
    <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning mb-3">Edit Course</a>

    <!-- Button to delete the course -->
    <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mb-3" onclick="return confirm('Are you sure you want to delete this course?')">Delete Course</button>
    </form>

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
