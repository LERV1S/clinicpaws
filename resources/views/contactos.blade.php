<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- resources/views/acerca-de.blade.php -->
    @extends('layouts.app2') <!-- Extiende el layout app.blade.php -->

    @section('title', 'Contactos de ClinicPaws') <!-- Define el título para esta página -->

    @section('content') <!-- Sección de contenido específico de la página -->
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold mb-4">Contactos de ClinicPaws</h1>
        <p>Estamos ubicados en: <strong>Calle Ficticia 123, Guadalajara, Jalisco</strong></p>
        <p>Teléfono: <strong>(33) 1234-5678</strong></p>
        <p>Email: <strong>contacto@clinicpaws.com</strong></p>

        
    </div>

    @endsection

</body>

</html>