<div>
    <h1>Manage Employees</h1>

    <!-- Formulario para agregar o editar un empleado -->
    <form wire:submit.prevent="saveEmployee">
        <select wire:model="user_id" required>
            <option value="">Select User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        <input type="text" wire:model="position" placeholder="Position">
        <button type="submit">{{ $selectedEmployeeId ? 'Update Employee' : 'Add Employee' }}</button>
    </form>

    <!-- Listado de empleados -->
    <ul>
        @foreach ($employees as $employee)
            <li>
                User: {{ $employee->user->name }} - Position: {{ $employee->position }}
                <button wire:click="editEmployee({{ $employee->id }})">Edit</button>
                <button wire:click="deleteEmployee({{ $employee->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
