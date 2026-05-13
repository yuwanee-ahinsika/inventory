<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Page</title>
    <link rel="icon" href="data:,">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:300,400,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            /* Soft gradient matching the provided image */
            background: linear-gradient(to bottom right, #f8fcd4, #a0d8e2, #2c8599, #e0aeb9);
            background-attachment: fixed;
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center relative m-0 p-0">

    <div class="w-full flex justify-center px-4 mt-8">
        {{ $slot }}
    </div>

</body>
</html>
