@extends('layouts.app')

@section('title', 'Lessons - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>Lessons</h1>

    <!-- Button to create a new lesson -->
    <a href="{{ route('teacher.lessons.create') }}" class="btn btn-primary mb-3">Create New Lesson</a>

    @if ($lessons->isEmpty())
        <p>No lessons available.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lesson Title</th>
                    <th>Content</th>
                    <th>Course</th>
                    <th>Module</th>
                    <th>Section</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->id }}</td>
                        <td>{{ $lesson->title }}</td>
                        <td>{{ Str::limit($lesson->content, 50) }}</td>
                        <td>{{ $lesson->course->title }}</td>
                        <td>{{ $lesson->module ? $lesson->module->title : 'N/A' }}</td>
                        <td>{{ $lesson->section ? $lesson->section->title : 'N/A' }}</td>
                        <td>
                            <!-- View Button -->
                            <a href="{{ route('teacher.lessons.show', $lesson->id) }}" class="btn btn-info btn-sm">View</a>

                            <!-- Edit Button -->
                            <a href="{{ route('teacher.lessons.edit', $lesson->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Delete Button -->
                            <form action="{{ route('teacher.lessons.destroy', $lesson->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this lesson?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
