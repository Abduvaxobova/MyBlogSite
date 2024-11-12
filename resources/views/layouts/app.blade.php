<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title' ?? 'Blog Site')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">
    <!-- Navbar -->
    @include('partials.header')


    <!-- Main content -->
    @yield('content')

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
