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
                <td>{{ $course->title }}</td>
                <td>{{ $course->description }}</td>
                <td>
                    <!-- View Button -->
                    <a href="{{ route('teacher.courses.show', $course->id) }}" class="btn btn-info btn-sm">View</a>

                    <!-- Edit Button -->
                    <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('teacher.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
