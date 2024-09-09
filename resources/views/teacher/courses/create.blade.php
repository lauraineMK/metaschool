@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
<div class="container">
    <div class="header">
        <h1>Create a New Course</h1>
        <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary">Cancel</a>
    </div>

    <!-- Form to create a new course -->
    <form action="{{ route('teacher.courses.store') }}" method="POST">
        @csrf

        <!-- Course Details -->
        <div class="form-section">
            <h2>Course Details</h2>

            <div class="form-group">
                <label for="course_name">Course Name:</label>
                <input type="text" id="course_name" name="name" class="form-control" required>
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

        <!-- Toggle to show/hide sections and modules -->
        <div class="form-group">
            <label for="include_sections">
                <input type="checkbox" id="include_sections" name="include_sections"> Include Sections and Modules
            </label>
        </div>

        <!-- Section Details -->
        <div id="section-container" style="display: none;">
            <!-- Sections will be added here -->
        </div>

        <!-- Module Details -->
        <div id="module-container">
            <!-- Standalone Modules will be added here -->
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button type="button" class="btn btn-secondary" id="add-section-btn" style="display: none;">Add Section</button>
            <button type="button" class="btn btn-secondary" id="add-module-btn">Add Module</button>
            <button type="submit" class="btn btn-primary">Create Course</button>
        </div>
    </form>
</div>
@endsection
