<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Loan Maker')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
    @if (isset($logoSettings) && $logoSettings->favicon)
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $logoSettings->favicon) }}">
    @endif
</head>
<body class="bg-gray-100">
    @yield('content')
    @stack('scripts')
</body>
</html>
