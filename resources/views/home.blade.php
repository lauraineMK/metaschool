<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - My Application</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Welcome to My Application</h1>
        <div class="buttons">
            <a href="{{ url('/teachers/dashboard') }}">Teacher access</a>
            <a href="{{ url('/students/dashboard') }}">Student access</a>
        </div>
    </div>
</body>
</html>
