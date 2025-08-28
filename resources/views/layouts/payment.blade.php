<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - NusaTripNow</title>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Font Awesome for icons -->
</head>
<body>
    <div class="container">
        <div class="main-card">
            <div class="card-header">
                <h1>@yield('title')</h1>
            </div>
            <div class="card-body">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>