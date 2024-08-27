@extends('layouts.app')

@section('title', 'Lessons - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>Lessons</h1>

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
                        <td>{{ $lesson->course->name }}</td>
                        <td>{{ $lesson->module ? $lesson->module->name : 'N/A' }}</td>
                        <td>{{ $lesson->section ? $lesson->section->name : 'N/A' }}</td>
                        <td>
                            <!-- View Button -->
                            <a href="{{ route('student.lessons.show', $lesson->id) }}" class="btn btn-info btn-sm">View</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
