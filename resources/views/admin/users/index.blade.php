@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4" style="color: #7C3AED; font-family: 'Inter', sans-serif; letter-spacing: 1px;">Gestion des utilisateurs</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white rounded-4 shadow-sm">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <select name="role" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()" @if($user->role==='admin') disabled @endif>
                                <option value="student" @if($user->role==='student') selected @endif>Étudiant</option>
                                <option value="teacher" @if($user->role==='teacher') selected @endif>Enseignant</option>
                                <option value="admin" @if($user->role==='admin') selected @endif>Admin</option>
                            </select>
                        </form>
                    </td>
                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '—' }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">Voir</a>
                        @if($user->role!=='admin')
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger rounded-pill">Supprimer</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
