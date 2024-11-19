<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\User;

class EmployeeManager extends Component
{
    public $employees;
    public $user_id, $position;
    public $selectedEmployeeId;
    public $searchUserTerm = ''; // Para manejar el término de búsqueda de usuario
    public $searchEmployeeTerm = ''; // Para manejar el término de búsqueda de empleado
    public $userSuggestions = []; // Para almacenar las sugerencias de usuarios

    public function mount()
    {
        $this->loadEmployees(); // Cargar empleados cuando el componente se monta
    }

    // Cargar empleados filtrados por nombre de usuario
    public function loadEmployees()
    {
        $this->employees = Employee::whereHas('user', function ($query) {
            $query->where('name', 'like', '%' . $this->searchEmployeeTerm . '%');
        })->get();
    }

    // Escuchar cambios en el término de búsqueda de empleados
    public function updatedSearchEmployeeTerm()
    {
        $this->loadEmployees(); // Recargar empleados al cambiar el término de búsqueda
    }

    // Autocompletar usuario en el formulario
    public function updatedSearchUserTerm()
    {
        $this->userSuggestions = User::where('name', 'like', '%' . $this->searchUserTerm . '%')->get();
    }

    public function selectUser($userId)
    {
        $this->user_id = $userId;
        $this->searchUserTerm = User::find($userId)->name;
        $this->userSuggestions = [];
    }

    public function saveEmployee()
    {
        // Validar que se haya seleccionado un usuario
        $this->validate([
            'user_id' => 'required',
        ]);

        // Verificar si el usuario ya está registrado como empleado
        $existingEmployee = Employee::where('user_id', $this->user_id)->first();
        if ($existingEmployee && !$this->selectedEmployeeId) {
            // Si ya existe y no es una edición, devolver un error
            session()->flash('error', 'This user is already an employee.');
            return;
        }

        if ($this->selectedEmployeeId) {
            // Editar empleado existente
            $employee = Employee::find($this->selectedEmployeeId);
            $employee->update([
                'user_id' => $this->user_id,
                'position' => $this->position,
            ]);
            session()->flash('message', 'Employee updated successfully.');
        } else {
            // Crear un nuevo empleado
            Employee::create([
                'user_id' => $this->user_id,
                'position' => $this->position,
            ]);
            session()->flash('message', 'Employee added successfully.');
        }

        // Actualizar el rol en la tabla model_has_roles
        \DB::table('model_has_roles')
            ->updateOrInsert(
                ['model_id' => $this->user_id, 'model_type' => 'App\Models\User'],
                ['role_id' => 3] // Role de empleado es 3
            );

        $this->resetInputFields();
        $this->loadEmployees(); // Recargar la lista de empleados después de guardar
    }

    
    public function editEmployee($id)
    {
        $employee = Employee::find($id);
        $this->selectedEmployeeId = $employee->id;
        $this->user_id = $employee->user_id;
        $this->position = $employee->position;
    
        // Mostrar el nombre del usuario en el input de búsqueda
        $this->searchUserTerm = User::find($employee->user_id)->name;
    
    }

    public function deleteEmployee($id)
    {
        Employee::find($id)->delete();
        $this->loadEmployees(); // Recargar la lista de empleados después de eliminar
    }

    private function resetInputFields()
    {
        $this->user_id = '';
        $this->position = '';
        $this->selectedEmployeeId = null;
        $this->searchUserTerm = ''; // Resetear el término de búsqueda de usuario
        $this->userSuggestions = []; // Resetear las sugerencias de usuarios
    }

    public function render()
    {
        return view('livewire.employee-manager', [
            'employees' => $this->employees,
        ]);
    }
}
