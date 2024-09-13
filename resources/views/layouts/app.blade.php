<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body class="{{ Route::currentRouteName() == 'teacher.courses.create' ? 'create-mode' : (Route::currentRouteName() == 'teacher.courses.edit' ? 'edit-mode' : '') }}">

    @include('partials.header')


    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </div>

    @include('partials.footer')

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @vite(['resources/js/app.js'])

    @stack('scripts')
</body>

</html>
