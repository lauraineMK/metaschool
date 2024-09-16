@extends('layouts.app')

@section('title', 'Courses - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>Courses</h1>

    <!-- Button to create a new course -->
    <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary mb-3">Create New Course</a>

    @if ($courses->isEmpty())
    <p>No courses available.</p>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Course Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->description }}</td>
                <td>
                    <div class="btn-container">
                        <!-- View Button -->
                        <a href="{{ route('teacher.courses.show', $course->id) }}" class="btn btn-info btn-sm btn-view">
                            <span class="text-view">View</span>
                            <i class="fas fa-eye"></i> <!-- Eye icon -->
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning btn-sm btn-edit">
                            <span class="text-edit">Edit</span>
                            <i class="fas fa-edit"></i> <!-- Pencil icon -->
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this course?')">
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
