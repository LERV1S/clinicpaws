<div> 
<div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Manage Appointments</h1>

    <!-- Formulario para agregar o editar una cita -->
    <form wire:submit.prevent="saveAppointment" class="space-y-4">
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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @role('Administrador|Veterinario|Empleado')

            <!-- Campo de búsqueda de mascotas -->
            <div class="relative">

                <input type="text" wire:model.lazy="searchPetTerm" class="input-field" placeholder="Search Pet..." required>
                @if(!empty($petSuggestions))
                    <ul class="absolute bg-white border border-gray-300 w-full z-10">
                        @foreach($petSuggestions as $pet)
                            <li wire:click="selectPet({{ $pet->id }})" class="cursor-pointer p-2 hover:bg-gray-200">
                                {{ $pet->name }}
                            </li>
                        @endforeach
                    </ul>
                @endif  
            </div>
                @endrole

            @role('Cliente')
            <!-- Mostrar solo las mascotas del cliente -->
            <div class="relative" required>
                <div>
                    <select wire:model="pet_id" class="input-field w-full" required>
                        <option value="">Selecciona tu mascota</option>
                        @foreach(Auth::user()->pets as $pet)
                            <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    @endrole
           
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
                <input id="appointment_date" type="datetime-local" wire:model="appointment_date"
                    min="{{ now()->format('Y-m-d\T08:00') }}" max="{{ now()->addDays(7)->format('Y-m-d\T17:00') }}"
                    class="input-field" required>
            </div>

            <!-- Campo de notas -->
            <div class="col-span-3">
                <textarea wire:model="notes" class="input-field" placeholder="Notes"></textarea>
            </div>

            <!-- Botón para abrir el modal de pago -->
            <div class="col-span-3">
                <button type="button" class="cta-button bg-blue-500 hover:bg-blue-600" wire:click="openPaymentModal">
                    Payment method
                </button>
            </div>
        </div>

        <div class="flex justify-start mt-4">
            <button type="submit" class="cta-button">{{ $selectedAppointmentId ? 'Update Appointment' : 'Add Appointment' }}</button>
        </div>
    </form>

    <!-- Campo de búsqueda para filtrar citas por nombre de mascota -->
<!-- Campo de búsqueda para filtrar citas por nombre de mascota -->
    <div class="mt-6">
        <input type="text" wire:model.lazy="searchAppointmentTerm" class="input-field" placeholder="Search by pet name...">
    </div>

    <!-- Listado de citas -->
     <div class="mt-6">
        <ul class="space-y-4">
            @foreach ($appointments as $appointment)
            <li class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow flex justify-between items-center">
                <div>
                    <p class="text-lg font-semibold">Pet: {{ $appointment->pet->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
<<<<<<< HEAD
                        Veterinarian: 
=======
                        <!-- Mostrar nombre del veterinario correctamente utilizando el user_id -->
                        Veterinarian:
>>>>>>> 88da841ce5828a659963f7d482d64961845b5806
                        @php
                            $veterinarian = \App\Models\Veterinarian::where('user_id', $appointment->veterinarian_id)->first();
                        @endphp
                        {{ $veterinarian && $veterinarian->user ? $veterinarian->user->name : 'No Veterinarian Assigned' }} - Date: {{ $appointment->appointment_date }}
                    </p>
                </div>
                <div class="flex space-x-4">
                    @role('Administrador|Veterinario|Empleado')
                    <button wire:click="editAppointment({{ $appointment->id }})" class="cta-button bg-yellow-500 hover:bg-yellow-600">Edit</button>
                    <button wire:click="deleteAppointment({{ $appointment->id }})" class="cta-button bg-red-500 hover:bg-red-600">Delete</button>
                    @endrole
                    <a href="{{ route('appointments.download', $appointment->id) }}" class="cta-button bg-green-500 hover:bg-green-600">Download PDF</a>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
    <!-- Modal para introducir los datos de pago -->
    @if($isPaymentModalOpen)
    <div class="fixed inset-0 flex items-center justify-center  bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="font-bold mb-4">Datos de Pago</h2>

            <!-- Select del método de pago -->
            <div class="mb-4">
                <select wire:model.lazy="payment_method" class="input-field" required>
                    <option value="">Selecciona el método de pago</option>
                    <option value="credit_card">Tarjeta de Crédito</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>

            <!-- Mostrar campos si el método de pago es tarjeta de crédito -->
            @if($payment_method === 'credit_card')
            <div class="mb-4">
                <input type="text" wire:model.lazy="credit_card_number" class="input-field" placeholder="Número de Tarjeta" required>
            </div>
            <div class="mb-4">
                <input type="text" wire:model.lazy="credit_card_expiry" class="input-field" placeholder="Fecha de Expiración (MM/AA)" required>
            </div>
            <div class="mb-4">
                <input type="text" wire:model.lazy="credit_card_cvv" class="input-field" placeholder="CVV" required>
            </div>
            @endif

            <!-- Mostrar campos si el método de pago es PayPal -->
            @if($payment_method === 'paypal')
            <div class="mb-4">
                <input type="email" wire:model.lazy="paypal_email" class="input-field" placeholder="Correo Electrónico de PayPal" required>
            </div>
            @endif

            <!-- Cantidad a pagar (select entre 0 y 50 pesos) -->
            <div class="mb-4">
                <select wire:model.lazy="payment_amount" class="input-field" required>
                    <option value="0">0 - En proceso</option>
                    <option value="50">50 - Pagado</option>
                </select>
            </div>

            <!-- Referencia de pago -->
            <div class="mb-4">
                <input type="text" wire:model.lazy="payment_reference" class="input-field" placeholder="Referencia de Pago (opcional)">
            </div>

            <!-- Botones para guardar o cancelar -->
            <div class="flex justify-end space-x-4">
                <button class="cta-button bg-gray-500 hover:bg-gray-600" wire:click="closePaymentModal">Cancelar</button>
                <button class="cta-button bg-blue-500 hover:bg-blue-600" wire:click="savePayment">Guardar Pago</button>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var appointmentDateInput = document.getElementById('appointment_date');
        appointmentDateInput.addEventListener('change', function() {
            var value = appointmentDateInput.value;
            var selectedDate = new Date(value.replace('T', ' ') + ':00');
            selectedDate.setMinutes(0);
            var selectedHour = selectedDate.getHours();
            if (selectedHour < 8) {
                selectedDate.setHours(8);
            } else if (selectedHour >= 18) {
                selectedDate.setHours(18);
            }

            var now = new Date();
            var maxDate = new Date(now.getTime() + (7 * 24 * 60 * 60 * 1000));
            if (selectedDate > maxDate) {
                selectedDate = maxDate;
            }

            var year = selectedDate.getFullYear();
            var month = ('0' + (selectedDate.getMonth() + 1)).slice(-2);
            var day = ('0' + selectedDate.getDate()).slice(-2);
            var hours = ('0' + selectedDate.getHours()).slice(-2);
            var minutes = ('0' + selectedDate.getMinutes()).slice(-2);

            var adjustedDate = `${year}-${month}-${day}T${hours}:${minutes}`;
            appointmentDateInput.value = adjustedDate;
            appointmentDateInput.dispatchEvent(new Event('input'));
        });
    });
</script>
