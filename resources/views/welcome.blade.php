<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <title>ClinicPaws | Inicio</title>
    
    <link rel="icon" href="{{ asset('/storage/prueba/C.png') }}" type="image/x-icon">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero-bg {
            background-image: url('https://images.unsplash.com/photo-1450778869180-41d0601e046e?q=80&w=1586&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            filter: brightness(0.7);
            height: 100vh;
            position: relative;
        }

        .buttons-container {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .cta-btn {
            background-color: #FF2D20;
            border-radius: 50px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .cta-btn:hover {
            background-color: #D0261A;
        }

        .secondary-btn {
            border: 2px solid white;
            border-radius: 50px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
        }

        .secondary-btn:hover {
            background-color: white;
            color: #FF2D20;
        }

        .hero-text-lg {
            font-size: 3.5rem;
            font-weight: bold;
            position: absolute;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            z-index: 1;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .hero-text-md,
        .hero-text-sm {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .hero-text-md {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .hero-text-sm {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .text-background {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 5px;
            border-radius: 5px;
            display: inline-block;
        }

        footer {
            background-color: #6c757d;
            padding: 3px 0;
            color: #fff;
        }

        .features-columns {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .features-column {
            background-color: #4a5568;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(33.333% - 40px);
            max-width: calc(33.333% - 40px);
        }

        @media (max-width: 768px) {
            .features-column {
                flex: 1 1 100%;
                max-width: 100%;
            }

            .hero-text-lg {
                font-size: 2rem;
                top: 80px;
            }

            .hero-text-md {
                font-size: 1.5rem;
            }

            .hero-text-sm {
                font-size: 1rem;
            }

            .cta-btn,
            .secondary-btn {
                padding: 8px 20px;
                font-size: 0.875rem;
            }

            .navbar {
                width: 100%;
                left: 0;
                top: 0;
                border-radius: 0;
                flex-direction: column;
            }

            .buttons-container {
                position: relative;
                top: auto;
                right: auto;
                margin-top: 20px;
                display: flex;
                justify-content: center;
                flex-direction: column;
                align-items: center;
            }

            .cta-btn,
            .secondary-btn {
                width: 100%;
                max-width: 200px;
                text-align: center;
            }
        }

        /* Navbar Styles */
        .navbar {
            background-color: #2d3748;
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* padding: 5px 5px; */
            flex-wrap: wrap;
            position: relative;
            z-index: 9999;
            width: 100%;
        }

        .navbar a {
            display: block;
            color: white;
            text-align: center;
            padding: 15px 20px;
            text-decoration: none;
            font-weight: bold;
            flex-grow: 1;
            border-bottom: 0.5px solid #4a5568;
            /* Añadimos una línea de separación */
        }

        /* aqui no se le muevas */
        .navbar a:hover {
            background-color: #4a5568;
            color: white;
        }

        /* Estilo para pantallas pequeñas */
        /* actualizacion, no se que paso pero funciona */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar a {
                width: 100%;
                /* text-align: left; */
            }
        }

        /* estilos para la imagen logo clinicpaws */
        .navbar img.logo {
            height: 35px;
            /* width: 280; */
            /* Ajusta la altura de la imagen para que encaje en la barra */
            display: inline-block;
        }
    </style>

</head>

<body class="antialiased font-sans bg-gray-900 text-white">

    <!-- Parte del navbar en tu archivo principal -->
    <div class="navbar">
        <!-- <p><strong>ClinicPaws</strong></p> -->
        <a href="{{ route('welcome') }}">
            <img src="/storage/prueba/ClinicPaws-H.png" alt="ClinicPaws Logo" class="logo">
        </a>
        <!-- <a href="{{ route('welcome') }}">Inicio</a> -->
        <a href="{{ route('about') }}">Acerca de</a> <!-- Enlace a la página de Acerca de -->
        <a href="{{ route('services') }}">Servicios</a>
        <!-- <a href="{{ route('contacts') }}">Contacto</a> -->
        <a href="{{route('faqs')}}">FAQ</a>
    </div>


    <div class="hero-bg min-h-screen flex flex-col justify-center items-center relative">
        <!-- <div class="absolute inset-0 bg-black opacity-50"></div> -->
        <div class="buttons-container">
            <a href="{{ route('register') }}" class="cta-btn">Regístrate Gratis</a>
            <a href="{{ route('login') }}" class="secondary-btn">Iniciar Sesión</a>
        </div>
        <h1 class="hero-text-lg text-background">Bienvenido a ClinicPaws</h1>
        <div class="relative z-10 text-center max-w-3xl mt-32">
            <p class="hero-text-md text-background">¡Cuidamos a tus Mascotas con Amor y Profesionalismo!</p>
            <p class="hero-text-sm text-background">En ClinicPaws, tu mascota recibe la mejor atención veterinaria en un ambiente cálido y acogedor.</p>


            <p class="hero-text-sm text-background">Descubre cómo ClinicPaws puede ayudar a tu clínica a ser más eficiente y mejorar la experiencia de tus clientes.</p>
        </div>
    </div>

    <div class="bg-gray-900 text-center">
        <!-- <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 1.5rem;">Características Principales</h2> -->
        <!-- <p class="text-lg mb-12 text-gray-300">Descubre cómo ClinicPaws puede ayudar a tu clínica a ser más eficiente y mejorar la experiencia de tus clientes.</p> -->
        <!-- <div class="features-columns">
            <div class="features-column">
                <h3 class="text-xl font-semibold mb-4">Gestión de Citas</h3>
                <p class="text-gray-400">
                    Organiza y gestiona las citas de tus pacientes con facilidad.
                </p>
            </div>
            <div class="features-column">
                <h3 class="text-xl font-semibold mb-4">Historial Médico</h3>
                <p class="text-gray-400">
                    Mantén un registro detallado del historial médico de cada mascota.
                </p>
            </div>
            <div class="features-column">
                <h3 class="text-xl font-semibold mb-4">Facturación Automatizada</h3>
                <p class="text-gray-400">
                    Simplifica la facturación con nuestro sistema automatizado.
                </p>
            </div>
        </div> -->
        <!-- <br> -->
        <h2 style="font-size: 24px;">Contactos de ClinicPaws</h2>
        <br>
        <p>Estamos ubicados en: <strong>Calle Ficticia 123, Guadalajara, Jalisco</strong></p>
        <p>Teléfono: <strong>(33) 1234-5678</strong></p>
        <p>Email: <strong>contacto@clinicpaws.com</strong></p>

    </div>
    <footer class="text-center">
        © 2024 ClinicPaws. Todos los derechos reservados.
    </footer>
</body>

</html>