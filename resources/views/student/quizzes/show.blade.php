@extends('layouts.app')

@section('title', 'Quiz Details - MetaSchool')

@section('content')
<div class="container mt-5">
    <div class="wrapper">
        <!-- Main content for quiz details -->
        <div class="content">
            <h1>{{ $quiz->title }}</h1>

            <!-- Quiz description -->
            <p>{{ $quiz->description }}</p>

            <!-- Form to answer the quiz -->
            @if($quiz->questions->count() > 0)
            <form id="quizForm" method="POST" action="{{ route('student.quizzes.submit', $quiz->id) }}">
                @csrf
                <div class="mt-4">
                    <h3>Questions</h3>
                    @foreach($quiz->questions as $question)
                    <div class="mb-3 question-container">
                        <input type="hidden" class="question-type" value="{{ $question->type }}">
                        <h5>{{ $question->question_text }}</h5>

                        @if($question->type === 'open')
                        <!-- Text area for open questions -->
                        <textarea class="form-control" name="questions[{{ $question->id }}]" rows="3" placeholder="Your answer..."></textarea>
                        @else
                        <!-- Radio buttons for multiple choice questions -->
                        @foreach($question->answers as $answer)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[{{ $question->id }}]" id="answer_{{ $answer->id }}" value="{{ $answer->id }}">
                            <label class="form-check-label" for="answer_{{ $answer->id }}">
                                {{ $answer->answer_text }}
                            </label>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    @endforeach
                </div>

                <!-- Button to submit the quiz -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Submit Quiz</button>
                </div>
            </form>
            @else
            <div class="mt-4">
                <p>No questions available for this quiz.</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
