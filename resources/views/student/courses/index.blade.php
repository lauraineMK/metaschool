@extends('layouts.app')

@section('title', 'Courses - MetaSchool')

@section('content')
<div class="container mt-5">
    <h1>Courses</h1>



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
                            <!-- View Button -->
                            <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-info btn-sm">View</a>


                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
