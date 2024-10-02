<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- <link rel="icon" href="{{ asset('/storage/prueba/C.png') }}" type="image/x-icon"> -->
    <link rel="icon" href="{{ asset('images/C.png')}}" type="image/png">
    <!-- <link rel="icon" href="{{ asset('icons/C.png')        }}?v=1" type="image/png"> -->





    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    
    
    @vite(['resources/css/app2.css', 'resources/js/app2.js']) <!-- Se incluyen los estilos y scripts en lugar del CSS inline -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- @vite(['resources/css/imagen.css']) -->

    @livewireStyles
</head>

<body class="font-sans antialiased">

    @include('components.nav-bar') <!-- Incluir el navbar -->


    <div class="flex w-full">
        <!-- imagen izquierda -->
        <div class="w-2/12 bg-gray-200 p-4 bg-image-container-left">
            <style>
                /* Imagen en el lado izquierdo */
                .bg-image-container-left {
                    background-image: url("images/ClinicPawscp.png");
                    background-repeat: repeat;
                    /* Repite verticalmente */
                    background-size: contain;
                    /* Escala la imagen al 100% del ancho y la repite verticalmente */
                    background-position: left top;
                    height: auto;
                    /* Cubre toda la altura de la pantalla */
                }

                /* Imagen en el lado derecho */
                .bg-image-container-right {
                    background-image: url("images//ClinicPaws.png");
                    background-repeat: repeat-y;
                    background-size: 100% auto;
                    background-position: right top;
                    height: auto;
                }
            </style>
        </div>
        <!-- parte centrar donde va todo el contenido -->
        <div class="container mx-auto px-16 py-8 bg-gray-100">
            @yield('content') <!-- El contenido específico se cargará aquí -->
            <div class="container mx-auto bg-gray-100 text-center">
                <hr class="my-6 border-gray-300 dark:border-gray-340" style="border-width: 1.5px;">
                <h2 class="contactos">Contactos de ClinicPaws</h2>
                <p>Estamos ubicados en: <strong>Calle Ficticia 123, Guadalajara, Jalisco</strong></p>
                <p>Teléfono: <strong>(33) 1234-5678</strong></p>
                <p>Email: <strong>contacto@clinicpaws.com</strong></p>
            </div>
        </div>
        <!-- imagen derecha -->
        <div class="w-2/12 bg-gray-200 p-4 bg-image-container-right"></div>
        <!-- <div class="w-2/12 bg-gray-200 p-4 bg-image-container"></div> -->
    </div>
    <!-- Incluir el componente de contactos -->
    <!-- @include('components.contactos')  -->
    @include('components.footer') <!-- Incluir el footer -->

    @livewireScripts
</body>

</html>