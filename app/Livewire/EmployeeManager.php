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

    public function mount()
    {
        $this->employees = Employee::all();
    }

    public function saveEmployee()
    {
        $this->validate([
            'user_id' => 'required',
        ]);

        if ($this->selectedEmployeeId) {
            $employee = Employee::find($this->selectedEmployeeId);
            $employee->update([
                'user_id' => $this->user_id,
                'position' => $this->position,
            ]);
        } else {
            Employee::create([
                'user_id' => $this->user_id,
                'position' => $this->position,
            ]);
        }

        $this->resetInputFields();
        $this->employees = Employee::all();
    }

    public function editEmployee($id)
    {
        $employee = Employee::find($id);
        $this->selectedEmployeeId = $employee->id;
        $this->user_id = $employee->user_id;
        $this->position = $employee->position;
    }

    public function deleteEmployee($id)
    {
        Employee::find($id)->delete();
        $this->employees = Employee::all();
    }

    private function resetInputFields()
    {
        $this->user_id = '';
        $this->position = '';
        $this->selectedEmployeeId = null;
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.employee-manager', compact('users'));
    }
}
