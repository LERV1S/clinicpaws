<div>
    <h1>Manage Medical Records</h1>

    <!-- Formulario para agregar o editar un registro médico -->
    <form wire:submit.prevent="saveMedicalRecord">
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

        <input type="date" wire:model="record_date" required>
        <textarea wire:model="diagnosis" placeholder="Diagnosis" required></textarea>
        <textarea wire:model="treatment" placeholder="Treatment" required></textarea>
        <button type="submit">{{ $selectedMedicalRecordId ? 'Update Record' : 'Add Record' }}</button>
    </form>

    <!-- Listado de registros médicos -->
    <ul>
        @foreach ($medicalRecords as $record)
            <li>
                Pet: {{ $record->pet->name }} - Veterinarian: {{ $record->veterinarian->name }} - Date: {{ $record->record_date }}
                <button wire:click="editMedicalRecord({{ $record->id }})">Edit</button>
                <button wire:click="deleteMedicalRecord({{ $record->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
