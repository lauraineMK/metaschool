@extends('layouts.app')

@section('title', 'Courses - My Application')

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
                            <a href="{{ route('teacher.courses.show', $course->id) }}" class="btn btn-info btn-sm">View</a>
                            <!-- Ajoutez des boutons d'action supplémentaires ici, par exemple Modifier, Supprimer -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
