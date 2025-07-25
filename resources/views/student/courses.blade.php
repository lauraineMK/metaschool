@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #7C3AED; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Mon cours en cours</h1>
    @if($enrolledCourses->count() > 0)
        @php $course = $enrolledCourses->first(); @endphp
        <div class="card shadow-lg rounded-4 border-0 mb-5 p-4 d-flex flex-column flex-md-row align-items-center gap-4" style="background: linear-gradient(90deg,#f7f7fa 60%,#e9e6fc 100%);">
            <div class="course-thumbnail bg-primary rounded-circle d-flex align-items-center justify-content-center me-3 shadow" style="width: 90px; height: 90px;">
                <i class="fas fa-book text-white fa-2x"></i>
            </div>
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-bold" style="font-size:1.5rem; color:#4F46E5;">{{ $course->name }}</h4>
                <span class="text-muted small">Instructeur : {{ $course->author->firstname ?? 'Instructeur inconnu' }} {{ $course->author->lastname ?? '' }}</span>
                <div class="mt-3">
                    @php
                        $total = $course->sections->flatMap(fn($section) => $section->modules->flatMap(fn($module) => $module->lessons))->count();
                        $completed = Auth::user()->lessons()->wherePivot('completed', true)
                            ->whereHas('module', function($q) use ($course) {
                                $q->whereHas('section', function($q2) use ($course) {
                                    $q2->where('course_id', $course->id);
                                });
                            })->count();
                        $progress = $total > 0 ? round(($completed / $total) * 100) : 0;
                        $progress = max(0, min(100, $progress));
                    @endphp
                    <div class="progress mb-2" style="height: 14px; background: #ede9fe; border-radius: 8px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%; background: linear-gradient(90deg,#7C3AED,#4F46E5); border-radius: 8px;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="badge bg-success me-2" style="font-size:1rem; border-radius: 1rem;">{{ $completed }} / {{ $total }} leçons terminées</span>
                    <span class="badge bg-primary" style="font-size:1rem; border-radius: 1rem;">{{ $progress }}% complété</span>
                </div>
            </div>
            <form method="POST" action="{{ route('student.courses.start', $course->id) }}" class="ms-md-4 mt-3 mt-md-0">
                @csrf
                <button type="submit" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm">
                    {{ $completed === $total && $total > 0 ? 'Revoir ce cours' : 'Continuer ce cours' }}
                </button>
            </form>
        </div>
        @php
            // Récupérer tous les quiz liés aux leçons du cours
            $quizzes = $course->sections->flatMap(fn($section) => $section->modules->flatMap(fn($module) => $module->lessons->flatMap(fn($lesson) => $lesson->quiz ? [$lesson->quiz] : [])));
        @endphp
        @if($quizzes->count() > 0)
            <div class="card shadow-lg rounded-4 border-0 mb-4 p-4" style="background: #fff;">
                <h4 class="fw-bold mb-4" style="color: #4F46E5;"><i class="fas fa-question-circle me-2"></i>Quiz QCM du cours</h4>
                <div class="row g-4">
                    @foreach($quizzes as $quiz)
                        @php
                            $qcmQuestions = $quiz->questions->where('type', 'multiple_choice');
                        @endphp
                        @if($qcmQuestions->count() > 0)
                            <div class="col-12 col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: #f7f7fa;">
                                    <h5 class="fw-semibold mb-3" style="color:#7C3AED;">{{ $quiz->title }}</h5>
                                    <ul class="list-group list-group-flush">
                                        @foreach($qcmQuestions as $question)
                                            <li class="list-group-item bg-transparent border-0 mb-2">
                                                <div class="fw-semibold mb-1" style="color:#1c1d1f;">{{ $question->question_text }}</div>
                                                @if($question->answers && $question->answers->count() > 0)
                                                    <form>
                                                        @foreach($question->answers as $answer)
                                                            <div class="form-check mb-1">
                                                                <input class="form-check-input" type="radio" name="qcm_{{ $question->id }}" id="qcm_{{ $question->id }}_{{ $answer->id }}" disabled>
                                                                <label class="form-check-label" for="qcm_{{ $question->id }}_{{ $answer->id }}">
                                                                    {{ $answer->answer_text }}
                                                                    @if($answer->is_correct)
                                                                        <span class="badge bg-success ms-2">Bonne réponse</span>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </form>
                                                @else
                                                    <div class="text-danger small">Aucune proposition de réponse n'est disponible pour cette question.</div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    @else
        <div class="alert alert-info shadow-sm rounded-4 p-4 text-center">Vous n'êtes inscrit à aucun cours. <a href="{{ url('/courses/browse') }}" class="fw-bold text-primary">Découvrir les cours</a></div>
    @endif
</div>
@endsection
