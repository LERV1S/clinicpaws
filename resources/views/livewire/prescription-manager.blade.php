<div>
    <h1>Manage Prescriptions</h1>

    <!-- Formulario para agregar o editar una prescripción -->
    <form wire:submit.prevent="savePrescription">
        <input type="date" wire:model="date" placeholder="Date" required>

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

        <input type="text" wire:model="medicine_name" placeholder="Medicine Name" required>
        <input type="text" wire:model="dosage" placeholder="Dosage" required>
        <textarea wire:model="instructions" placeholder="Instructions"></textarea>

        <button type="submit">{{ $selectedPrescriptionId ? 'Update Prescription' : 'Add Prescription' }}</button>
    </form>

    <!-- Listado de prescripciones -->
    <ul>
        @foreach ($prescriptions as $prescription)
            <li>
                Date: {{ $prescription->date }} - Medicine: {{ $prescription->medicine_name }} - Pet: {{ $prescription->pet->name }} - Vet: {{ $prescription->veterinarian->user->name }}
                <button wire:click="editPrescription({{ $prescription->id }})">Edit</button>
                <button wire:click="deletePrescription({{ $prescription->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>

