<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

    <h1>Manage Appointments</h1>

    <!-- Formulario para agregar o editar una cita -->
    <form wire:submit.prevent="saveAppointment">
        <select wire:model="pet_id" required>
            <option value="">Select Pet</option>
            @foreach($pets as $pet)
                <option value="{{ $pet->id }}">{{ $pet->name }}</option>
            @endforeach
        </select>

        <select wire:model="veterinarian_id" required>
            <option value="">Select Veterinarian</option>
            @foreach($veterinarians as $vet)
                <option value="{{ $vet->id }}">{{ $vet->name }}</option>
            @endforeach
        </select>

        <input type="datetime-local" wire:model="appointment_date" required>
        <input type="text" wire:model="status" placeholder="Status" required>
        <textarea wire:model="notes" placeholder="Notes"></textarea>
        <button type="submit">{{ $selectedAppointmentId ? 'Update Appointment' : 'Add Appointment' }}</button>
    </form>

    <!-- Listado de citas -->
    <ul>
        @foreach ($appointments as $appointment)
            <li>
                Pet: {{ $appointment->pet->name }} - Veterinarian: {{ $appointment->veterinarian->name }} - Date: {{ $appointment->appointment_date }}
                <button wire:click="editAppointment({{ $appointment->id }})">Edit</button>
                <button wire:click="deleteAppointment({{ $appointment->id }})">Delete</button>
            </li>
        @endforeach
    </ul>

</div>
