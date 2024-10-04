<div>
    <h3 class="text-lg font-semibold">Appointment Calendar</h3>

 <!-- Aquí estará el calendario -->
 <div id='calendar' style="min-height: 600px;"></div>

    <!-- Estilos adicionales y inicialización de FullCalendar -->
    <style>
        .fc-timegrid-slot-label {
            color: black !important; /* Cambiar el color de las horas en la barra lateral */
        }
    
        #calendar {
            font-family: 'Arial', sans-serif;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            height: calc(100vh - 100px); /* Hacer que el calendario ocupe casi toda la pantalla */
            overflow-y: auto; /* Agregar desplazamiento vertical si es necesario */
        }
    
        .fc-event {
            border: 1px solid #1e3a8a; /* Añadir un borde alrededor de los eventos */
            border-radius: 4px;
            padding: 2px; /* Reducir el padding para eventos más pequeños */
            font-size: 10px; /* Ajustar tamaño de texto para que no se sobrecargue */
            color: black !important; /* Cambiar color de texto a negro */
            white-space: nowrap; /* Evitar que el texto se rompa en múltiples líneas */
            overflow: hidden; /* Esconder texto si es muy largo */
            text-overflow: ellipsis; /* Mostrar puntos suspensivos si el texto es muy largo */
        }
    
        .fc .fc-toolbar-title {
            font-size: 18px;
            color: #1e3a8a; /* Cambiar el color del título del mes */
        }
    
        .fc-daygrid-day-number {
            color: black !important; /* Cambiar el color del número del día */
            font-size: 14px; /* Ajustar el tamaño de la fuente del número del día */
            font-weight: bold; /* Asegurar que el número se vea destacado */
        }
            /* El estilo del modal */
    .modal {
        display: none; /* Oculto por defecto */
        position: fixed; /* Fijo en la pantalla */
        z-index: 1; /* Por encima del contenido */
        left: 0;
        top: 0;
        width: 100%; /* Ancho completo */
        height: 100%; /* Altura completa */
        background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
    }

    /* Contenido del modal */
    .modal-content {
        background-color: #101826;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 300px;
        text-align: center;
        border-radius: 8px;
    }

    /* El botón de cerrar */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    </style>
    <!-- Incluir los estilos de Livewire -->
    <script defer src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    
<script>
   document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var modal = document.getElementById("occupiedModal");
    var span = document.getElementsByClassName("close")[0];

    // Definir los veterinarios
    var veterinarians = []; // Aquí debes cargar los veterinarios desde tu JSON

    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            height: 'auto',
            contentHeight: 'auto',
            events: function(fetchInfo, successCallback, failureCallback) {
                fetch('/appointments-data?start=' + fetchInfo.startStr + '&end=' + fetchInfo.endStr)
                    .then(response => response.json())
                    .then(data => {
                        var now = new Date();
                        var filteredEvents = data.appointments.filter(function(event) {
                            return new Date(event.start) >= now;
                        });
                        // Guardamos los veterinarios obtenidos del JSON
                        veterinarians = data.veterinarians;
                        successCallback(filteredEvents);
                    })
                    .catch(error => {
                        console.error("Error al cargar los datos:", error);
                        failureCallback(error);
                    });
            },
            editable: false,
            droppable: false,

            eventClick: function(info) {
                // Verificar si la cita está ocupada por el color rojo
                if (info.event.backgroundColor === 'red') {
                    // Mostrar el modal en lugar de una alerta
                    modal.style.display = "block";
                } else {
                    // Obtener el user_id (que corresponde a veterinarian_id en tu JSON de eventos)
                    var userId = info.event.extendedProps.veterinarian_id;

                    // Buscar el `veterinarian_id` en los veterinarios usando el `user_id`
                    var veterinarian = veterinarians.find(vet => vet.user_id == userId);
                    if (veterinarian) {
                        var veterinarianId = veterinarian.id;

                        // Obtener la fecha de la cita
                        var appointmentDate = new Date(info.event.start);
                        appointmentDate.setHours(appointmentDate.getHours() - 6); // Ajusta según tu zona horaria
                        var formattedDate = appointmentDate.toISOString().slice(0, 19);

                        // Redirigir con el veterinarian_id correcto
                        window.location.href = '/appointments?veterinarian_id=' + veterinarianId + '&appointment_date=' + formattedDate;
                    } else {
                        console.error("No se encontró el veterinarian_id correspondiente.");
                    }
                }
            },

            eventContent: function(info) {
                return {
                    html: `<span style="color: ${info.event.color};">●</span> ${info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} ${info.event.title}`
                };
            }
        });
        calendar.render();
    }

    // Cerrar el modal cuando el usuario haga clic en la "X"
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Cerrar el modal cuando el usuario haga clic fuera del modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
</script>


    <!-- Incluir los scripts de Livewire -->
    <div id="occupiedModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Esta cita ya está ocupada. Por favor selecciona otra fecha/hora.</p>
        </div>
    </div>

</div>
