@extends('layouts.app')

@section('title', 'Course Details - MetaSchool')

@section('content')
<div class="container mt-5 teacher-section">
    <h1>{{ $course->title }}</h1>

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

    <!-- Course Content -->
    <h2 class="mt-5">Course Content</h2>

    <!-- Content display logic -->
    <!-- ... (rest of your content) -->
</div>
@endsection
