<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body>

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

    @vite(['resources/js/app.js'])

    @stack('scripts')
</body>

</html>
