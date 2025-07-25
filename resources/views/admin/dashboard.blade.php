@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #7C3AED; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Supervision globale (Admin)</h1>
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.courses.index') }}" class="text-decoration-none">
                <div class="card shadow rounded-4 border-0 p-4 text-center h-100 hover-card" style="background: linear-gradient(90deg,#ede9fe 60%,#e9e6fc 100%);">
                    <div class="fw-bold fs-2" style="color:#4F46E5;">{{ $coursesCount }}</div>
                    <div class="text-muted">Gestion des cours</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card shadow rounded-4 border-0 p-4 text-center h-100 hover-card" style="background: linear-gradient(90deg,#f7f7fa 60%,#e9e6fc 100%);">
                    <div class="fw-bold fs-2" style="color:#4F46E5;">{{ $usersCount ?? '-' }}</div>
                    <div class="text-muted">Utilisateurs</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.lessons.index') }}" class="text-decoration-none">
                <div class="card shadow rounded-4 border-0 p-4 text-center h-100 hover-card" style="background: linear-gradient(90deg,#ede9fe 60%,#e9e6fc 100%);">
                    <div class="fw-bold fs-2" style="color:#4F46E5;">{{ $lessonsCount }}</div>
                    <div class="text-muted">Leçons</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.quizzes.index') }}" class="text-decoration-none">
                <div class="card shadow rounded-4 border-0 p-4 text-center h-100 hover-card" style="background: linear-gradient(90deg,#f7f7fa 60%,#e9e6fc 100%);">
                    <div class="fw-bold fs-2" style="color:#4F46E5;">{{ $quizzesCount }}</div>
                    <div class="text-muted">Quiz</div>
                </div>
            </a>
        </div>
    </div>
    <h3 class="fw-bold mb-4 mt-5" style="color:#4F46E5;">Professeurs et leurs cours</h3>
    <div class="accordion" id="accordionTeachers">
        @foreach($teachers as $teacher)
            <div class="accordion-item mb-3 rounded-4 shadow-sm border-0">
                <h2 class="accordion-header" id="heading{{ $teacher->id }}">
                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $teacher->id }}" aria-expanded="true" aria-controls="collapse{{ $teacher->id }}">
                        {{ $teacher->firstname }} {{ $teacher->lastname }} <span class="badge bg-primary ms-2">{{ $teacher->email }}</span>
                    </button>
                </h2>
                <div id="collapse{{ $teacher->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $teacher->id }}" data-bs-parent="#accordionTeachers">
                    <div class="accordion-body">
                        <h5 class="fw-semibold mb-3" style="color:#7C3AED;">Cours de l'enseignant</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle bg-white rounded-4 shadow-sm">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Titre</th>
                                        <th>Status</th>
                                        <th>Nb étudiants</th>
                                        <th>Quiz</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teacher->courses as $course)
                                        <tr>
                                            <td>{{ $course->id }}</td>
                                            <td>{{ $course->name }}</td>
                                            <td>
                                                @if($course->status === 'pending')
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                @elseif($course->status === 'validated')
                                                    <span class="badge bg-success">Validé</span>
                                                @elseif($course->status === 'rejected')
                                                    <span class="badge bg-danger">Rejeté</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $course->status }}</span>
                                                @endif
                                            </td>
                                            <td>—</td>
                                            <td>
                                                @foreach($course->lessons as $lesson)
                                                    @if($lesson->quiz)
                                                        <span class="badge bg-info text-dark mb-1">{{ $lesson->quiz->title }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">Voir</a>
                                                @if($course->status === 'pending')
                                                    <form action="{{ route('admin.courses.validate', $course->id) }}" method="POST" class="d-inline ms-1">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success rounded-pill">Valider</button>
                                                    </form>
                                                    <form action="{{ route('admin.courses.reject', $course->id) }}" method="POST" class="d-inline ms-1">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill">Rejeter</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
