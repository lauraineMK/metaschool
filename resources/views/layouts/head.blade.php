<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'My Application')</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stack('styles')
