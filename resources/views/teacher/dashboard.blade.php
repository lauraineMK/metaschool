@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 p-4 d-flex flex-column flex-md-row align-items-center gap-4" style="background: linear-gradient(90deg,#7C3AED 60%,#4F46E5 100%); color: #fff;">
                <div class="d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: #fff2; border-radius: 50%;">
                    <i class="fas fa-chalkboard-teacher fa-3x"></i>
                </div>
                <div class="flex-grow-1">
                    <h1 class="fw-bold mb-1">Bienvenue, {{ Auth::user()->firstname }} !</h1>
                    <p class="mb-0">Votre espace enseignant centralisé pour piloter vos cours, leçons et quiz.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="card shadow border-0 rounded-4 text-center py-4 h-100">
                        <div class="mb-2"><i class="fas fa-book fa-2x text-primary"></i></div>
                        <div class="fw-bold fs-4">{{ $courses_count ?? 0 }}</div>
                        <div class="text-muted">Cours créés</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card shadow border-0 rounded-4 text-center py-4 h-100">
                        <div class="mb-2"><i class="fas fa-users fa-2x text-success"></i></div>
                        <div class="fw-bold fs-4">
                            {{ collect($courses_stats ?? [])->sum('students_count') }}
                        </div>
                        <div class="text-muted">Étudiants inscrits (total)</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card shadow border-0 rounded-4 text-center py-4 h-100">
                        <div class="mb-2"><i class="fas fa-question-circle fa-2x text-warning"></i></div>
                        <div class="fw-bold fs-4">{{ $quizzes_count ?? 0 }}</div>
                        <div class="text-muted">Quiz créés</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-4 p-4">
                <h4 class="fw-bold mb-3" style="color: #4F46E5;"><i class="fas fa-chart-bar me-2"></i>Statistiques par cours</h4>
                @if(!empty($courses_stats))
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" style="font-family: 'Inter', sans-serif;">
                            <thead class="table-light">
                                <tr>
                                    <th>Cours</th>
                                    <th>Étudiants inscrits</th>
                                    <th>Progression moyenne</th>
                                    <th>Ont commencé</th>
                                    <th>Pas commencé</th>
                                    <th>Progression</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses_stats as $stat)
                                <tr>
                                    <td class="fw-semibold" style="color:#2563eb;">{{ $stat['course']->name }}</td>
                                    <td>{{ $stat['students_count'] }}</td>
                                    <td>{{ $stat['avg_progress'] }}%</td>
                                    <td><span class="badge bg-success">{{ $stat['started'] }}</span></td>
                                    <td><span class="badge bg-secondary">{{ $stat['not_started'] }}</span></td>
                                    <td style="min-width:120px;">
                                        <div class="progress" style="height: 12px; background: #ede9fe; border-radius: 8px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $stat['avg_progress'] }}%; background: linear-gradient(90deg,#7C3AED,#4F46E5); border-radius: 8px;" aria-valuenow="{{ $stat['avg_progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">Aucun cours à afficher.</div>
                @endif
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 rounded-4 p-4">
                <h4 class="fw-bold mb-3" style="color: #4F46E5;"><i class="fas fa-bolt me-2"></i>Accès rapide</h4>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ url('/teachers/courses') }}" class="btn btn-outline-primary rounded-pill px-4"><i class="fas fa-book me-2"></i>Gérer mes cours</a>
                    <a href="{{ url('/teachers/lessons') }}" class="btn btn-outline-success rounded-pill px-4"><i class="fas fa-play-circle me-2"></i>Gérer mes leçons</a>
                    <a href="{{ url('/teachers/quizzes') }}" class="btn btn-outline-warning rounded-pill px-4"><i class="fas fa-question-circle me-2"></i>Gérer mes quiz</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
