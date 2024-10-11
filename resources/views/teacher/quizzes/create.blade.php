@extends('layouts.app')

@section('title', 'Create Quiz - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="header">
        <h1>Create a New Quiz</h1>
        <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-secondary">Cancel</a>
    </div>

    <!-- Form to create a new quiz -->
    <form action="{{ route('teacher.quizzes.store') }}" method="POST">
        @csrf

        <!-- Lesson selection -->
        <div class="form-group mt-3">
            <label for="lesson_id">Lesson</label>
            <select class="form-control" id="lesson_id" name="lesson_id" required>
                <option value="" disabled selected>Select a lesson</option>
                @foreach($lessons as $lesson)
                <option value="{{ $lesson->id }}">
                    {{ $lesson->title }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Quiz Title input -->
        <div class="form-group mt-3">
            <label for="title">Quiz Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <!-- Quiz Description input -->
        <div class="form-group mt-3">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <div id="questions-container">
            <!-- New questions will be added here -->
        </div>

        <button type="button" class="add-question btn btn-secondary  mt-4">Add Question</button>

        <!-- Container for the Submit button -->
        <div class="mt-4">
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Create Quiz</button>
        </div>
    </form>
</div>
@endsection
