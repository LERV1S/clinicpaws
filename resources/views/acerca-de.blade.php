<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicPaws | Acerca de</title>
    <link rel="icon" href="{{ asset('images/C.png') }}" type="image/x-icon">
</head>

<body>
    <!-- resources/views/acerca-de.blade.php -->
    @extends('layouts.app2')

    @section('title', 'Acerca de ClinicPaws')

    @section('content')

    <h1 class="text-4xl font-bold mb-4 py-4">Acerca de ClinicPaws</h1>
    <p class="texto-grande">
        <strong>ClinicPaws:</strong> La Solución Integral para Clínicas Veterinarias.
        <br>
        ClinicPaws es una plataforma innovadora diseñada para optimizar la gestión de clínicas veterinarias,
        ofreciendo una amplia gama de herramientas que abarcan desde la administración de citas y el historial médico hasta la gestión de inventarios y facturación.

        <strong>Nuestra misión</strong> es brindar la mejor atención a las mascotas y facilitar el trabajo diario de los profesionales veterinarios mediante soluciones tecnológicas
        que no solo mejoran la eficiencia operativa, sino que también incrementan la satisfacción de los clientes.
        <br><br>

        En ClinicPaws, entendemos la <strong>importancia</strong> de un manejo efectivo de cada aspecto de la clínica.
        Por eso, hemos desarrollado herramientas innovadoras que permiten a los veterinarios concentrarse en <em>lo que mejor saben hacer: cuidar de sus pacientes.</em>
        <!-- <br> -->
        Nuestra plataforma se adapta a las necesidades de cada clínica, garantizando un flujo de trabajo optimizado y una gestión integral de la atención veterinaria.

        <!-- <br><br>
            ClinicPaws es una solución integral para la gestión de clínicas veterinarias,
            ofreciendo una amplia gama de herramientas para administrar citas, historial médico,
            inventarios, facturación y mucho más. -->
    </p>
    <br><br>
    <p class="texto-grande">
        <strong>Características Destacadas:</strong> Una de las características más sobresalientes de ClinicPaws es su sistema de
        <strong>recordatorios automáticos para citas</strong>, que ayuda a reducir la tasa de no presentaciones y asegura que cada mascota
        reciba la atención que necesita a tiempo. Además, contamos con un módulo de
        <!-- duda en este punto -->
        <strong>gestión de recetas electrónicas</strong>, que simplifica el proceso de prescripción, permitiendo a los veterinarios enviar recetas directamente a las farmacias asociadas, lo que ahorra tiempo tanto para el profesional como para el propietario de la mascota.
        También ofrecemos
        <!-- duda en esta parte -->
        un módulo de <strong>atención al cliente</strong>, que permite a las clínicas gestionar consultas y solicitudes de los dueños de mascotas de manera eficiente, mejorando la comunicación y la experiencia del cliente.
    </p>
    <br>
    <p class="texto-grande">
        <strong>Impacto en el Bienestar Animal:</strong> La plataforma ClinicPaws no solo optimiza la gestión administrativa,
        sino que también se compromete con el bienestar de los animales.
        Nuestra herramienta de <strong>seguimiento de tratamientos</strong> permite a los veterinarios <strong>registrar</strong> y <strong>monitorear</strong> la evolución de cada paciente,
        asegurando que se sigan los protocolos adecuados y que las mascotas reciban el cuidado necesario en cada etapa de su tratamiento.
        Además, la gestión del <strong>historial médico</strong> garantiza que la información relevante sobre la salud de las mascotas esté siempre accesible y organizada,
        facilitando diagnósticos más precisos y un seguimiento más efectivo.
    </p>
    <br>
    <p class="texto-grande">
        <strong>Soporte y Capacitación:</strong> Entendemos que la transición a una nueva plataforma puede ser un desafío, por lo que en ClinicPaws ofrecemos un <strong>soporte técnico </strong>
        dedicado que está disponible para resolver cualquier duda o inconveniente que pueda surgir. Además, proporcionamos capacitación integral a los usuarios, asegurando
        que cada miembro del equipo de la clínica <strong>se sienta cómodo y competente</strong> al utilizar todas las funciones de la plataforma. Este enfoque no solo minimiza el tiempo de adaptación,
        sino que también maximiza el potencial de ClinicPaws para transformar la práctica veterinaria.
    </p>
    <!-- <p class="texto-grande">

            Nuestra misión es brindar la mejor atención a las mascotas y facilitar la gestión diaria
            de los profesionales de la veterinaria con herramientas innovadoras y eficientes.
        </p> -->
    <br>
    <!-- <h1>Acerca de ClinicPaws</h1> -->
    <!-- <br><br> -->
    <!-- <p class="texto-grande">
            ClinicPaws es una plataforma innovadora diseñada para optimizar la gestión de clínicas veterinarias, mejorando la eficiencia operativa y la satisfacción de los clientes. Nuestra misión es proporcionar soluciones tecnológicas que faciliten el trabajo de los veterinarios y el cuidado de los pacientes (mascotas), asegurando que cada aspecto de la clínica funcione de manera efectiva.
        </p> -->
    <!-- <br> -->
    <p class="texto-grande">
        <strong>Visión:</strong> Nuestra aspiración es ser la solución líder en la gestión integral de clínicas veterinarias, impulsando la modernización del
        sector a través de tecnologías avanzadas. Buscamos transformar la experiencia tanto para los profesionales como para los dueños de mascotas, asegurando
        que cada visita al veterinario sea eficiente y gratificante.
    </p>
    <br>
    <p class="texto-grande">
        En un mundo donde la tecnología juega un papel crucial, ClinicPaws se compromete a estar a la vanguardia, ofreciendo actualizaciones constantes y soporte técnico dedicado. Al elegir ClinicPaws, no solo eliges una herramienta de gestión; eliges un socio estratégico que se preocupa por el bienestar de las mascotas y la excelencia en el servicio veterinario.
    </p>

    <br>
    <hr class="my-6 border-gray-300 dark:border-gray-340" style="border-width: 3px;">
    <!-- <br> -->
    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem; padding: 1px" class="text-center">
        Integrantes del Equipo Proyecto Modular
    </h2>

    <div class="features-columns">
        <div class="features-column">
            <h3 class="text-xl font-semibold mb-4">Miguel Angel Sandoval Chavez</h3>
            <p>
                INNI/INFO <br>
                miguel.sandoval9282@alumnos.udg.mx <br>
                codigo: 220792825
            </p>
        </div>
        <div class="features-column">
            <h3 class="text-xl font-semibold mb-4">Luis Enrique Rivera Vargas</h3>
            <p>
                INNI/INFO <br>
                luis.rivera2887@alumnos.udg.mx <br>
                codigo: 220288701
            </p>
        </div>
        <div class="features-column">
            <h3 class="text-xl font-semibold mb-4">Alan Vidal Ocampo Orozco</h3>
            <p>
                INNI/INFO <br>
                alan.ocampo4510@alumno.udg.mx <br>
                codigo: 217451073
            </p>
        </div>
    </div>
    <!-- </div> -->
    @endsection
</body>

</html>