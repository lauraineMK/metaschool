@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
<div class="container">
    <h1>Create a New Course</h1>

    <!-- Form to create a new course -->
    <form action="{{ route('teacher.courses.store') }}" method="POST">
        @csrf

        <!-- Course Details -->
        <div class="form-section">
            <h2>Course Details</h2>

            <div class="form-group">
                <label for="course_title">Course Name:</label>
                <input type="text" id="course_title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="course_description">Course Description:</label>
                <textarea id="course_description" name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="course_price">Course Price:</label>
                <input type="number" id="course_price" name="price" class="form-control">
            </div>

            <div class="form-group">
                <label for="course_creation_date">Creation Date:</label>
                <input type="date" id="course_creation_date" name="creation_date" class="form-control">
            </div>

            <input type="hidden" name="author_id" value="{{ auth()->user()->id }}">
        </div>

        <!-- Section Details -->
        <div class="form-section">
            <h2>Section Details (Optional)</h2>

            <div class="form-group">
                <label for="section_title">Section Name:</label>
                <input type="text" id="section_title" name="section_title" class="form-control">
            </div>

            <div class="form-group">
                <label for="section_level">Section Level:</label>
                <input type="number" id="section_level" name="section_level" class="form-control">
            </div>
        </div>

        <!-- Module Details -->
        <div class="form-section">
            <h2>Module Details (Optional)</h2>

            <div class="form-group">
                <label for="module_title">Module Name:</label>
                <input type="text" id="module_title" name="module_title" class="form-control">
            </div>

            <div class="form-group">
                <label for="module_description">Module Description:</label>
                <textarea id="module_description" name="module_description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="module_level">Module Level:</label>
                <input type="number" id="module_level" name="module_level" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Create Course</button>
    </form>
</div>
@endsection
