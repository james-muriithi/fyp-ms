<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#25274d">
    <meta name="description" content="A final year project management system for pwani university">
    <meta name="author" content="James Muriitih">
    <meta name="keywords" content="fyp,fypms, final year project">
    <meta property="og:site_name" content="google.com">
    <meta property="og:title" content="Final Year Project Management System" />
    <meta property="og:description" content="A final year project management system for pwani university made by james muriithi" />
    <meta property="og:image:url" itemprop="image" content="https://james-muriithi.github.io/fyp-ms/assets/images/logo-lg.png">
    <meta property="og:image" content="https://james-muriithi.github.io/fyp-ms/assets/images/logo-lg.png" />
    <meta property="og:image:url" content="https://james-muriithi.github.io/fyp-ms/assets/images/logo-lg.png" />
    <meta property="og:image:secure_url" content="https://james-muriithi.github.io/fyp-ms/assets/images/logo-lg.png" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="400" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:type" content="website" />

    <title>{{config('app.name', 'Laravel') }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

</head>
<body class="antialiased">
    @yield('content')
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
