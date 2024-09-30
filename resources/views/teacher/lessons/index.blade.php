@extends('layouts.app')

@section('title', 'Lessons - MetaSchool')

@section('content')
<div class="container mt-5 lessons-view">
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
                <th class="hide-on-small-mobile">Content</th>
                <th>Course</th>
                <th class="hide-on-mobile">Section</th>
                <th class="hide-on-mobile">Module</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lessons as $lesson)
            <tr>
                <td>{{ $lesson->id }}</td>
                <td>{{ $lesson->title }}</td>
                <td class="hide-on-small-mobile">{{ Str::limit($lesson->content, 50) }}</td>
                <td>{{ $lesson->course->name }}</td>
                <td class="hide-on-mobile">{{ $lesson->section ? $lesson->section->name : 'N/A' }}</td>
                <td class="hide-on-mobile">{{ $lesson->module ? $lesson->module->name : 'N/A' }}</td>
                <td>
                    <div class="btn-container">
                        <!-- View Button -->
                        <a href="{{ route('teacher.lessons.show', $lesson->id) }}" class="btn btn-info btn-sm btn-view">
                            <span class="text-view">View</span>
                            <i class="fas fa-eye"></i> <!-- Eye icon -->
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('teacher.lessons.edit', $lesson->id) }}" class="btn btn-warning btn-sm btn-edit">
                            <span class="text-edit">Edit</span>
                            <i class="fas fa-edit"></i> <!-- Pencil icon -->
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('teacher.lessons.destroy', $lesson->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this lesson?')">
                                <span class="text-delete">Delete</span>
                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
