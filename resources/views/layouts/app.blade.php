<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'ClinicPaws') }}</title> -->
    <!-- Aquí configuramos el título -->
    <title>@yield('title', 'ClinicPaws')</title>
    <link rel="icon" href="{{ asset('images/C.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- FullCalendar CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css' rel='stylesheet' />

    <!-- FullCalendar JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js'></script>

    <!-- Scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
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
            width: 250px;
            position: fixed;
            top: 0;
            bottom: 0;
            height: 100%;
            transition: transform 0.4s ease-in-out;
            /* Ajuste en la duración y tipo de transición */
            z-index: 1000;
        }

        .sidebar.hidden {
            transform: translateX(-250px);
            /* Mueve la sidebar completamente fuera de la vista */
        }

        /* Estilos para los enlaces del menú lateral */
        .sidebar a {
            display: block;
            padding: 15px;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid #394963;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        /* Estilos para enlaces activos */
        .sidebar a.active {
            background-color: #63b3ed;
            /* Cambia el color de fondo cuando el enlace está activo */
            color: white;
            border-color: #63b3ed;
        }

        .sidebar a:hover,
        .sidebar a.active:hover {
            background-color: #4a5568;
            border-color: #63b3ed;
        }

        /* Header */
        .header {
            background-color: #1a202c;
            color: white;
            height: 4rem;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1001;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Content */
        .content {
            padding: 20px;
            margin-left: 250px;
            margin-top: 4rem;
            min-height: calc(100vh - 4rem);
            transition: margin-left 0.4s ease-in-out, width 0.4s ease-in-out;
            /* Transición más suave */
        }

        .content.expanded {
            margin-left: 0;
            width: calc(100% - 0px);
            /* Ancho completo al ocultar la barra */
        }

        /* Estilos del botón para alternar Sidebar */
        .toggle-sidebar-btn {
            position: fixed;
            top: 1rem;
            left: 270px;
            /* Ajustado para que no se encime sobre la barra lateral */
            background-color: #4a5568;
            color: white;
            padding: 10px;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: background-color 0.3s ease, left 0.4s ease-in-out, transform 0.4s ease-in-out;
            /* Ajuste en las transiciones */
            z-index: 1002;
        }

        .toggle-sidebar-btn.moved {
            transform: translateX(-250px);
            /* Mueve el botón a la izquierda con la barra */
        }

        .toggle-sidebar-btn:hover {
            background-color: #2d3748;
        }

        /* Estilos para tablas internas */
        .table-container {
            overflow-x: auto;
            padding: 10px;
            background-color: #1a202c;
            border-radius: 0.375rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #2d3748;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f3f4f6;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }

            .content {
                margin-left: 0;
            }

            .toggle-sidebar-btn {
                left: 20px;
            }

            .toggle-sidebar-btn.moved {
                transform: translateX(0);
                /* El botón no debe moverse en pantallas pequeñas */
            }

            #calendar {
        min-height: 500px;
    }
        }

        .text-lg {
    color: rgb(255, 255, 255);
}
.fixed2 {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #3182ce;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }
        .fixed2:hover {
            background-color: #1d4ed8;
        }

    </style>
</head>

<body class="font-sans antialiased">

    <div x-data="{ sidebarVisible: true }" class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Esto llama a la barra de navegación de Livewire -->
        <livewire:layout.navigation />

        <!-- Sidebar -->
        <nav :class="sidebarVisible ? 'sidebar' : 'sidebar hidden'" class="sidebar">
            <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>

            @role('Administrador|Veterinario|Empleado|Cliente')
            <a href="{{ route('calendar') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('calendar') ? 'active' : '' }}">Calendar</a>
            @endrole

            @role('Administrador|Veterinario|Empleado|Cliente')
            <a href="{{ route('pets.index') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('pets.index') ? 'active' : '' }}">Pets</a>
            @endrole

            @role('Administrador|Veterinario|Empleado|Cliente')
            <a href="{{ route('appointments.index') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('appointments.index') ? 'active' : '' }}">Appointments</a>
            @endrole

            @role('Administrador|Veterinario|Empleado')
            <a href="{{ route('inventories.index') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('inventories.index') ? 'active' : '' }}">Inventory</a>
            @endrole

            @role('Administrador|Veterinario|Cliente')
            <a href="{{ route('medical_records.index') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('medical_records.index') ? 'active' : '' }}">MedicalRecord</a>
            @endrole

            @role('Administrador|Empleado|Cliente')
            <a href="{{ route('invoices.index') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('invoices.index') ? 'active' : '' }}">Invoices</a>
            @endrole

            @role('Administrador|Cliente|Empleado')
            <a href="{{ route('tickets.index') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('tickets.index') ? 'active' : '' }}">Tickets</a>
            @endrole

            @role('Administrador|Veterinario|Empleado|Cliente')
            <a href="{{ route('prescriptions.index') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('prescriptions.index') ? 'active' : '' }}">Prescriptions</a>
            @endrole

            @role('Administrador')
            <a href="{{ route('employees.index') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('employees.index') ? 'active' : '' }}">Employee's</a>
            @endrole

            @role('Administrador')
            <a href="{{ route('veterinarians.index') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('veterinarians.index') ? 'active' : '' }}">Veterinarian's</a>
            @endrole
            @role('Administrador|Empleado|Veterinario')
            <a href="{{ route('medicines.index') }}" class="block py-2.5 px-4 transition-colors {{ request()->routeIs('medicines.index') ? 'active' : '' }}">Medicines</a>
            @endrole

        </nav>

        <!-- Main Content -->
        <div :class="sidebarVisible ? 'content' : 'content expanded'" class="content">
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

        <!-- Botón para alternar Sidebar -->
        <button @click="sidebarVisible = !sidebarVisible" :class="!sidebarVisible ? 'toggle-sidebar-btn moved' : 'toggle-sidebar-btn'">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Botón flotante para hacer scroll hacia arriba -->
        <button class="fixed2" onclick="scrollToTop()">
            <i class="fas fa-arrow-up"></i>
        </button>
        <!-- JavaScript para el scroll al inicio -->
        <script>
            function scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        </script>
        </v>



        @livewireScripts
</body>

</html>
