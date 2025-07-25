@extends('layouts.app')

@section('title', 'Quiz - MetaSchool')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-body p-5">
                    <h1 class="fw-bold mb-3" style="color: #7C3AED;"><i class="fas fa-question-circle me-2"></i>{{ $quiz->title }}</h1>
                    <p class="text-secondary mb-4">{{ $quiz->description }}</p>
                    @php
                        // On ne garde que les questions QCM réelles
                        $qcmQuestions = $quiz->questions->filter(function($q) {
                            return $q->type === 'multiple_choice' && !str_contains($q->question_text, 'What is your opinion') && !str_contains($q->question_text, 'feature of');
                        });
                    @endphp

                    @if($qcmQuestions->count() > 0)
                        <div class="mb-4 p-4 rounded-4" style="background: #F3F4F6; border: 1px solid #E5E7EB;">
                            <h4 class="fw-bold mb-3" style="color: #4F46E5;"><i class="fas fa-info-circle me-2"></i>Résumé des QCM</h4>
                            <ul class="list-group list-group-flush">
                                @foreach($qcmQuestions as $question)
                                    <li class="list-group-item bg-transparent border-0 mb-2">
                                        <div class="fw-semibold mb-1">{{ $question->question_text }}</div>
                                        <ul class="ps-3">
                                            @foreach($question->answers as $answer)
                                                <li>{{ $answer->answer_text }}
                                                    @if($answer->is_correct)
                                                        <span class="badge bg-success ms-2">Bonne réponse</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($qcmQuestions->count() > 0)
                        <form id="quizForm" method="POST" action="{{ route('student.quizzes.submit', $quiz->id) }}">
                            @csrf
                            <div class="mb-4">
                                <h4 class="mb-3" style="color: #4F46E5;"><i class="fas fa-list-ol me-2"></i>Questions QCM</h4>
                                @foreach($qcmQuestions as $question)
                                    <div class="mb-4 p-3 rounded-3" style="background: #F8F9FB;">
                                        <h5 class="fw-bold mb-2"><i class="fa fa-question text-primary me-2"></i>{{ $question->question_text }}</h5>
                                        @if($question->answers && $question->answers->count() > 0)
                                            @foreach($question->answers as $answer)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="questions[{{ $question->id }}]" id="answer_{{ $answer->id }}" value="{{ $answer->id }}" required>
                                                    <label class="form-check-label" for="answer_{{ $answer->id }}">
                                                        {{ $answer->answer_text }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-danger small">Aucune proposition de réponse n'est disponible pour cette question.</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 fw-bold">
                                    <i class="fas fa-paper-plane me-2"></i>Soumettre le quiz
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info">Aucune question QCM réelle pour ce quiz.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
