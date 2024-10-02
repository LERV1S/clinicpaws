<div>
    <h3 class="text-lg font-semibold">Calendario de Citas</h3>
    <div id="calendar"></div> <!-- Aquí estará el calendario -->

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
    </style>

    <!-- Incluir los estilos de Livewire -->

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
    
            if (calendarEl) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    height: 'auto',
                    contentHeight: 'auto',
                    events: function(fetchInfo, successCallback, failureCallback) {
                        // Llamada al endpoint /appointments-data para obtener los eventos
                        fetch('/appointments-data?start=' + fetchInfo.startStr + '&end=' + fetchInfo.endStr)
                            .then(response => response.json())
                            .then(data => {
                                console.log("Eventos recibidos:", data.appointments);
                                successCallback(data.appointments); // Cargar eventos en el calendario
                            })
                            .catch(error => {
                                console.error("Error al cargar los datos:", error);
                                failureCallback(error);
                            });
                    },
                    editable: false,
                    droppable: false,
    
                    // Cuando se da clic en una cita
                    eventClick: function(info) {
                    var veterinarianId = info.event.extendedProps.veterinarian_id;
                    
                    // Retrasar la hora 6 horas
                    var appointmentDate = new Date(info.event.start);
                    appointmentDate.setHours(appointmentDate.getHours() - 6); // Restar 6 horas

                    // Convertir a ISO string sin los segundos
                    var formattedDate = appointmentDate.toISOString().slice(0, 19); // YYYY-MM-DDTHH:mm:ss

                    // Redirigir a appointment-manager con los datos de la cita seleccionada
                    window.location.href = '/appointments?veterinarian_id=' + veterinarianId + '&appointment_date=' + formattedDate;
                }
                ,
                    eventContent: function(info) {
                        return {
                            html: `<span style="color: ${info.event.color};">●</span> ${info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} ${info.event.title}`
                        };
                    }
                });
                calendar.render();
            }
        });
    </script>
    
    

    <!-- Incluir los scripts de Livewire -->
</div>
