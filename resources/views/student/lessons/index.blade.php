@extends('layouts.app')

@section('title', 'Lessons - MetaSchool')

@section('content')
<div class="container mt-5 lessons-view">
    <h1>Lessons</h1>

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
                    <!-- View Button -->
                    <a href="{{ route('student.lessons.show', $lesson->id) }}" class="btn btn-info btn-sm btn-view">
                        <span class="text-view">View</span>
                        <i class="fas fa-eye"></i> <!-- Eye icon -->
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
