        <!-- Imagen lateral izquierda -->
        
        <!-- Contenido principal -->
        <div class="welcome-container w-full lg:w-4/6">
            <h1 class="text-2xl text-blue-500 font-bold text-center">Bienvenido/a a ClinicPaws 🐾</h1>
            <p class="text-gray-700 mt-4 text-center">
                👋 ¡Hola <span class="highlight font-semibold">{{ e(auth()->user()->name)}}</span>!
            </p>
            <p class="text-gray-600 text-center">
                Gracias por elegir ClinicPaws, tu plataforma de gestión veterinaria confiable. Estamos aquí para simplificar tus tareas y asegurarnos de que cada mascota reciba el mejor cuidado posible.
            </p>
            
            <!-- Panel personalizado -->
            <h2 class="section-title text-xl text-blue-500 font-semibold mt-8">🌟 Panel Personalizado para Ti</h2>
            <p class="text-gray-600">
                Dependiendo de tu rol, aquí encontrarás herramientas diseñadas para facilitar tu experiencia:
            </p>
    
            <!-- Opciones para Clientes -->
            <h3 class="mt-4 text-lg font-semibold">Para Clientes:</h3>
            <ul class="list-disc ml-6 text-gray-700">
                <li><i class="fas fa-paw text-blue-500"></i> <strong>Información de tus Mascotas:</strong> Accede fácilmente al historial médico y actualizaciones de salud.</li>
                <li><i class="fas fa-calendar-alt text-blue-500"></i> <strong>Agenda tus Citas:</strong> Reserva en línea y gestiona las próximas visitas veterinarias.</li>
                <li><i class="fas fa-file-invoice text-blue-500"></i> <strong>Consulta Facturas:</strong> Revisa y descarga tus facturas y comprobantes.</li>
            </ul>
    
            <!-- Opciones para Trabajadores -->
            <h3 class="mt-4 text-lg font-semibold">Para Trabajadores:</h3>
            <ul class="list-disc ml-6 text-gray-700">
                <li><i class="fas fa-user-md text-blue-500"></i> <strong>Gestión de Pacientes y Citas:</strong> Organiza las consultas y mantén un control eficiente.</li>
                <li><i class="fas fa-box text-blue-500"></i> <strong>Control de Inventario:</strong> Lleva un seguimiento detallado de suministros y productos.</li>
                <li><i class="fas fa-notes-medical text-blue-500"></i> <strong>Historial Médico:</strong> Actualiza y revisa los registros médicos con rapidez.</li>
            </ul>
    
            <!-- Noticias y Actualizaciones -->
            <h2 class="section-title text-xl text-blue-500 font-semibold mt-8">📰 Noticias y Actualizaciones</h2>
            <ul class="list-disc ml-6 text-gray-700">
                <li><i class="fas fa-lightbulb text-blue-500"></i> <strong>Consejo del Mes:</strong> "Las revisiones periódicas son esenciales para prevenir enfermedades en tus mascotas."</li>
                <li><i class="fas fa-star text-blue-500"></i> <strong>Nueva Función:</strong> Hemos implementado recordatorios automáticos para vacunas y citas pendientes.</li>
                <li><i class="fas fa-rocket text-blue-500"></i> <strong>Próximamente:</strong> Lanzaremos un módulo para adopciones y refugios.</li>
            </ul>
    
            <!-- Contacto -->
            <h2 class="section-title text-xl text-blue-500 font-semibold mt-8">💡 Sugerencias y Soporte</h2>
            <p class="text-gray-600">
                Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos:
            </p>
            <ul class="list-disc ml-6 text-gray-700">
                <li><i class="fas fa-envelope text-blue-500"></i> Correo Electrónico: <a href="mailto:clinicpaws.site@gmail.com" class="highlight text-blue-600">clinicpaws.site@gmail.com</a></li>
                <li><i class="fas fa-phone text-blue-500"></i> Teléfono: <span class="highlight font-semibold">+52 55 1234 5678</span></li>
                <li><i class="fas fa-comments text-blue-500"></i> Chat en Línea: Disponible 24/7</li>
            </ul>
            <p class="text-gray-600 mt-6 text-center">
                🌟 Gracias por confiar en nosotros. Tu experiencia y la salud de las mascotas son nuestra prioridad.
            </p>
        </div>
        
