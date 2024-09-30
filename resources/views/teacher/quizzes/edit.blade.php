@extends('layouts.app')

@section('title', 'Edit Quiz - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="header">
        <h1>Edit Quiz</h1>
        <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-secondary">Cancel</a>
    </div>

    <!-- Form to edit an existing quiz -->
    <form action="{{ route('teacher.quizzes.update', $quiz->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Add this to specify the PUT method for updating -->

        <!-- Lesson selection -->
        <div class="form-group mt-3">
            <label for="lesson_id">Lesson</label>
            <select class="form-control" id="lesson_id" name="lesson_id" required>
                <option value="" disabled>Select a lesson</option>
                @foreach($lessons as $lesson)
                <option value="{{ $lesson->id }}" {{ $lesson->id == $quiz->lesson_id ? 'selected' : '' }}>
                    {{ $lesson->title }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Quiz Title input -->
        <div class="form-group mt-3">
            <label for="title">Quiz Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $quiz->title) }}" required>
        </div>

        <!-- Quiz Description input -->
        <div class="form-group mt-3">
            <label for="description">Quiz Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $quiz->description) }}</textarea>
        </div>

        <div id="questions-container">
            <!-- Display existing questions -->
            @foreach ($quiz->questions as $question)
                <div class="form-group mt-3">
                    <label for="question_{{ $question->id }}">Question</label>
                    <input type="text" class="form-control" id="question_{{ $question->id }}" name="questions[{{ $question->id }}]" value="{{ old('questions.' . $question->id, $question->text) }}" required>
                </div>
            @endforeach
            <!-- New questions will be added here -->
        </div>

        <button type="button" class="add-question btn btn-secondary mt-4">Add Question</button>

        <!-- Container for the Submit button -->
        <div class="mt-4">
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Update Quiz</button>
        </div>
    </form>
</div>
@endsection
