@extends('layouts.app')

@section('content')
<style>
/* Suppression des flèches de tri Bootstrap/DataTables */
.table th.sorting:after,
.table th.sorting:before,
.table th.sorting_asc:after,
.table th.sorting_asc:before,
.table th.sorting_desc:after,
.table th.sorting_desc:before {
    display: none !important;
}
/* Suppression de la pagination (flèches) sous la table */
/* .pagination {
    display: none !important;
} */
/* Design MetaSchool premium */
.metacard {
    background: linear-gradient(135deg, #f3f0ff 0%, #e9d5ff 100%);
    border-radius: 1.5rem;
    box-shadow: 0 4px 24px rgba(124,58,237,0.08);
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    border: none;
}
.metacard .btn {
    font-weight: 600;
    letter-spacing: 0.5px;
}
.table.metatable {
    border-radius: 1.2rem;
    overflow: hidden;
    font-family: 'Inter', sans-serif;
    font-size: 1.05rem;
}
.table.metatable td, .table.metatable th {
    white-space: nowrap;
    vertical-align: middle;
    border: none;
    background: transparent;
}
.table.metatable thead th {
    background: #ede9fe;
    color: #7C3AED;
    font-weight: 700;
    font-size: 1.08rem;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #c4b5fd;
}
.table.metatable tbody tr {
    transition: background 0.2s;
}
.table.metatable tbody tr:hover {
    background: #f5f3ff;
}
.badge-status {
    font-size: 0.98em;
    padding: 0.5em 1em;
    border-radius: 1em;
    font-weight: 600;
}
.badge-status.pending {
    background: #fbbf24;
    color: #7c3aed;
}
.badge-status.validated {
    background: #34d399;
    color: #fff;
}
.badge-status.rejected {
    background: #f87171;
    color: #fff;
}
.btn-meta {
    background: #7C3AED;
    color: #fff;
    border-radius: 2em;
    font-weight: 600;
    padding: 0.4em 1.2em;
    transition: background 0.2s;
}
.btn-meta:hover {
    background: #5b21b6;
    color: #fff;
}
/* Pagination MetaSchool : masquer tout sauf Previous et Next */
.pagination .page-item:not(.previous):not(.next) {
    display: none !important;
}
.pagination .page-item .page-link[aria-label="Next"],
.pagination .page-item .page-link[aria-label="Previous"],
.pagination .page-item .page-link svg,
.pagination .page-item .page-link i {
    display: none !important;
}
</style>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0" style="color: #7C3AED; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Gestion des leçons</h1>
        <a href="{{ route('admin.lessons.create') }}" class="btn btn-meta shadow-sm">+ Nouvelle leçon</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    <div class="metacard">
        <div class="table-responsive">
            <table class="table metatable align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Cours</th>
                        <th>Status</th>
                        <th>Date création</th>
                        <th>Valider/Rejeter (enseignant)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lessons as $lesson)
                    <tr>
                        <td class="fw-bold text-secondary">{{ $lesson->id }}</td>
                        <td class="fw-semibold">{{ $lesson->title }}</td>
                        <td><span class="text-dark">{{ $lesson->module->section->course->name ?? 'N/A' }}</span></td>
                        <td>
                            <span class="badge-status {{ $lesson->status }}">
                                @if($lesson->status === 'pending') En attente
                                @elseif($lesson->status === 'validated') Validée
                                @elseif($lesson->status === 'rejected') Rejetée
                                @else {{ $lesson->status }} @endif
                            </span>
                        </td>
                        <td>{{ $lesson->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="fw-bold text-primary">{{ $lesson->module->section->course->author->firstname ?? 'Inconnu' }} {{ $lesson->module->section->course->author->lastname ?? '' }}</span>
                            @if($lesson->status === 'pending')
                                <form action="{{ route('admin.lessons.validate', $lesson->id) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success rounded-circle" title="Valider" style="width:2.2em;height:2.2em;display:inline-flex;align-items:center;justify-content:center;"><span style="font-size:1.2em;">✔️</span></button>
                                </form>
                                <form action="{{ route('admin.lessons.reject', $lesson->id) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Rejeter" style="width:2.2em;height:2.2em;display:inline-flex;align-items:center;justify-content:center;"><span style="font-size:1.2em;">✖️</span></button>
                                </form>
                            @else
                                <span class="text-muted ms-2">—</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.lessons.show', $lesson->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">Voir</a>
                            <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="btn btn-sm btn-warning rounded-pill ms-1">Éditer</a>
                            <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Supprimer cette leçon ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded-pill">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted" style="font-size:1.2rem; font-family:'Inter',sans-serif;">Aucune leçon trouvée pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $lessons->links() }}
        </div>
    </div>
</div>
@endsection
