@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
    <div class="container">
        <h1>Create a New Course</h1>
        <form action="{{ route('teacher.courses.store') }}" method="POST">
            @csrf

            <!-- Course Details -->
            <label for="course_title">Course Title:</label>
            <input type="text" id="course_title" name="title" required>

            <label for="course_description">Course Description:</label>
            <textarea id="course_description" name="description"></textarea>

            <label for="course_price">Course Price:</label>
            <input type="number" id="course_price" name="price">

            <label for="course_creation_date">Creation Date:</label>
            <input type="date" id="course_creation_date" name="creation_date">

            <input type="hidden" name="author_id" value="{{ auth()->user()->id }}">

            <!-- Section Details -->
            <label for="section_title">Section Title (optional):</label>
            <input type="text" id="section_title" name="section_title">

            <label for="section_level">Section Level (optional):</label>
            <input type="number" id="section_level" name="section_level">

            <!-- Module Details -->
            <label for="module_title">Module Title (optional):</label>
            <input type="text" id="module_title" name="module_title">

            <label for="module_description">Module Description (optional):</label>
            <textarea id="module_description" name="module_description"></textarea>

            <label for="module_level">Module Level (optional):</label>
            <input type="number" id="module_level" name="module_level">

            <button type="submit">Create Course</button>
        </form>
    </div>
@endsection
