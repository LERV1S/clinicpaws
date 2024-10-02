<div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Appointments</h1>
<!-- Mostrar mensajes de éxito o error -->
@if (session()->has('message'))
    <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
        {{ session('message') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
        {{ session('error') }}
    </div>
@endif
    <!-- Formulario para agregar o editar una cita -->
    <form wire:submit.prevent="saveAppointment" class="space-y-4">
        <!-- Agrupación de inputs en una grid de 3 columnas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Campo de búsqueda de mascotas (dentro del formulario para seleccionar una mascota) -->
            <div class="relative">
                <input type="text" wire:model.lazy="searchPetTerm" class="input-field" placeholder="Search Pet..." required>
                @if(!empty($petSuggestions))
                    <ul class="absolute bg-white border border-gray-300 w-full z-10">
                        @foreach($petSuggestions as $pet)
                            <li 
                                wire:click="selectPet({{ $pet->id }})" 
                                class="cursor-pointer p-2 hover:bg-gray-200"
                            >
                                {{ $pet->name }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Select de veterinario -->
            <div>
                <select wire:model="veterinarian_id" class="input-field" required>
                    <option value="">Select Veterinarian</option>
                    @foreach($veterinarians as $vet)
                        <option value="{{ $vet->id }}">
                            {{ $vet->user ? $vet->user->name : 'User not found' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Campo de fecha de cita -->
            <div>
                <input id="appointment_date" 
                       type="datetime-local" 
                       wire:model="appointment_date" 
                       min="{{ now()->format('Y-m-d\T08:00') }}" 
                       max="{{ now()->addDays(7)->format('Y-m-d\T17:00') }}" 
                       class="input-field" 
                       required>
            </div>      
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var appointmentDateInput = document.getElementById('appointment_date');
            
                    // Listener para ajustar solo los minutos a 00 y validar el rango de horas
                    appointmentDateInput.addEventListener('change', function() {
                        var value = appointmentDateInput.value;
            
                        // Convertir la fecha seleccionada a un objeto Date
                        var selectedDate = new Date(value.replace('T', ' ') + ':00');
            
                        // Ajustar los minutos automáticamente a 00
                        selectedDate.setMinutes(0);
            
                        // Verificar si la hora está dentro del horario laboral (8 AM a 5 PM)
                        var selectedHour = selectedDate.getHours();
                        if (selectedHour < 8) {
                            selectedDate.setHours(8); // Ajustar a 8 AM si es menor
                        } else if (selectedHour >= 18) {
                            selectedDate.setHours(18); // Ajustar a 5 PM si es mayor
                        }
            
                        // Verificar si la fecha es mayor a 7 días desde la fecha actual
                        var now = new Date();
                        var maxDate = new Date(now.getTime() + (7 * 24 * 60 * 60 * 1000)); // 7 días desde hoy
            
                        if (selectedDate > maxDate) {
                            selectedDate = maxDate; // Si es mayor a 7 días, ajustarlo
                        }
            
                        // Formatear la fecha y hora a 'YYYY-MM-DDTHH:00'
                        var year = selectedDate.getFullYear();
                        var month = ('0' + (selectedDate.getMonth() + 1)).slice(-2); // Mes en formato MM
                        var day = ('0' + selectedDate.getDate()).slice(-2); // Día en formato DD
                        var hours = ('0' + selectedDate.getHours()).slice(-2); // Hora en formato HH
                        var minutes = ('0' + selectedDate.getMinutes()).slice(-2); // Minutos en formato MM
            
                        // Asignar la fecha ajustada al input
                        var adjustedDate = `${year}-${month}-${day}T${hours}:${minutes}`;
                        appointmentDateInput.value = adjustedDate;
            
                        // Validar en Livewire si es necesario
                        appointmentDateInput.dispatchEvent(new Event('input'));
                    });
                });
            </script>
            
            
            

            <!-- Campo de estado -->
            <div>
                <input type="text" wire:model="status" class="input-field" placeholder="Status" required>
            </div>

            <!-- Campo de notas -->
            <div class="col-span-3">
                <textarea wire:model="notes" class="input-field" placeholder="Notes"></textarea>
            </div>
        </div>

        <div class="flex justify-start mt-4">
            <button type="submit" class="cta-button">{{ $selectedAppointmentId ? 'Update Appointment' : 'Add Appointment' }}</button>
        </div>
    </form>

    <!-- Campo de búsqueda para filtrar citas por nombre de mascota -->
    <div class="mt-6">
        <input 
            type="text" 
            wire:model.lazy="searchPetTerm" 
            class="input-field" 
            placeholder="Search by pet name..."
        />
    </div>

    <!-- Listado de citas -->
    <div class="mt-6">
        <ul class="space-y-4">
            @foreach ($appointments as $appointment)
            <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                <div>
                    <p class="text-lg font-semibold">Pet: {{ $appointment->pet->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Veterinarian: {{ $appointment->veterinarian && $appointment->veterinarian->user ? $appointment->veterinarian->user->name : 'No Veterinarian Assigned' }} - Date: {{ $appointment->appointment_date }}
                    </p>
                </div>
                <div class="flex space-x-4">
                    <button wire:click="editAppointment({{ $appointment->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                    <button wire:click="deleteAppointment({{ $appointment->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                    <a href="{{ route('appointments.download', $appointment->id) }}" class="cta-button bg-green-500 hover:bg-green-600">Download PDF</a>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>


