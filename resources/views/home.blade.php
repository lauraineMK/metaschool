@extends('layouts.app')

@section('title', 'Home - My Application')

@section('content')
    <div class="container">
        <h1>Welcome to My Application</h1>
        <div class="buttons">
            <a href="{{ url('/teachers/dashboard') }}" class="btn btn-primary">Teacher Access</a>
            <a href="{{ url('/students/dashboard') }}" class="btn btn-secondary">Student Access</a>
        </div>
    </div>
@endsection
