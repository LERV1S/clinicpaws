<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/C.png') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<!-- <body class="font-sans text-gray-900 antialiased"> -->

<!-- <body class="font-sans text-gray-900 antialiased"> -->
<body>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-400 dark:bg-gray-900">
    <!-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-300"> -->

        <!-- este div es para la imagen logo de clinicpaws que ya quedo configurada en proporcion al log in en tamano -->
        <div>
            <a href="/" wire:navigate>
                <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->
                <img src="{{ asset('images/ClinicPaws-H.png') }}" alt="Logo" class="w-350 h-40 mx-auto">
            </a>
        </div>

        <!-- en este div es para el coso de email password el la caja -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-700 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>