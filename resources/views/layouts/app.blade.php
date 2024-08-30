<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Estilos para los campos de entrada */
        .input-field {
            background-color: #ffffff;
            border: 1px solid #cbd5e0;
            border-radius: 0.375rem;
            padding: 10px 15px;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-field:focus {
            border-color: #3182ce;
            box-shadow: 0 4px 8px rgba(49, 130, 206, 0.3);
            outline: none;
        }

        /* Botón estilizado */
        .cta-button {
            background-color: #2563eb;
            color: white;
            padding: 10px 20px;
            border-radius: 0.375rem;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
            cursor: pointer;
        }

        .cta-button:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
        }

        /* Sidebar */
        .sidebar {
            background-color: #2d3748;
            color: white;
            min-height: 100vh;
            padding: 20px;
            width: 250px;
            flex-shrink: 0; /* Prevent the sidebar from shrinking */
            position: fixed; /* Make sidebar fixed on the left */
            left: 0; /* Align to the left edge */
            top: 0;
            bottom: 0;
        }

        .sidebar a {
            display: block;
            color: #a0aec0;
            padding: 10px 15px;
            border-radius: 0.375rem;
            transition: background-color 0.3s, color 0.3s;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #4a5568;
            color: white;
        }

        /* Content */
        .content {
            flex-grow: 1;
            padding: 20px;
            margin-left: 270px; /* Offset content by the width of the sidebar */
            min-width: 0; /* Prevent content from shrinking on smaller screens */
        }

        /* Container */
        .container {
            display: flex;
            flex-wrap: nowrap; /* Ensure the content doesn't wrap */
            height: 100%; /* Ensure full height */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%; /* Full width on small screens */
                min-height: auto; /* Adjust height */
                position: static; /* Remove fixed position */
                order: 1; /* Sidebar appears first */
            }
            .content {
                width: 100%; /* Full width for the content as well */
                order: 2; /* Content appears below the sidebar */
                margin-left: 0; /* Remove margin offset */
                padding: 10px; /* Adjust padding */
            }
            .container {
                flex-wrap: wrap; /* Allow wrapping on smaller screens */
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <livewire:layout.navigation />

        <!-- Container with Sidebar and Main Content -->
        <div class="container max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Sidebar -->
            <nav class="sidebar">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('pets.index') }}">Manage Pets</a>
                <a href="{{ route('appointments.index') }}">Manage Appointments</a>
                <a href="{{ route('medical_records.index') }}">Manage Records</a>
                <!-- Add more routes as needed -->
            </nav>

            <!-- Main Content -->
            <div class="content">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow mb-6">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>
