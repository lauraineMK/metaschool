@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <h1 class="mb-2">Bonjour, {{ auth()->user()->name }} !</h1>
                        <p class="text-secondary mb-0">Continuez votre parcours d'apprentissage</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section Cours en cours -->
    <div class="row">
        <div class="col-lg-8">
            <div class="dashboard-card mb-4">
                @php
                    $progress = isset($progress) ? max(0, min(100, $progress)) : 0;
                    $completedLessons = $completedLessons ?? 0;
                    $totalLessons = $totalLessons ?? 0;
                @endphp
                <h3 class="mb-3">Votre cours en cours</h3>
                @if($currentCourse)
                    <div class="card h-100 mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-start gap-3">
                                <div class="course-thumbnail bg-primary rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px;">
                                    <i class="fas fa-book text-white"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-1">{{ $currentCourse->name }}</h6>
                                    <p class="text-muted small mb-2">{{ $currentCourse->author->firstname ?? '' }} {{ $currentCourse->author->lastname ?? '' }}</p>
                                    <div class="mb-2">
                                        <span class="badge bg-success">{{ $completedLessons }} leçon(s) terminée(s) / {{ $totalLessons }} au total</span>
                                    </div>
                                    <div class="progress mb-3" style="height: 10px;">
                                        <div class="progress-bar {{ $progress === 0 ? 'bg-secondary' : 'bg-primary' }}" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="small text-muted mb-2">Progression : {{ $progress }}%</div>
                                    <a href="{{ url('/students/courses/'.$currentCourse->id) }}" class="btn btn-sm btn-primary w-100">Continuer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">Vous n'avez pas encore commencé de cours. <a href="{{ url('/courses/browse') }}">Découvrir les cours</a></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bars
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.transition = 'width 1s ease-in-out';
            bar.style.width = width;
        }, 500);
    });
});
</script>
@endpush
