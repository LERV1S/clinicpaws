<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\User;

class AppointmentManager extends Component
{
    public $appointments;
    public $pet_id, $veterinarian_id, $appointment_date, $status, $notes;
    public $selectedAppointmentId;

    public function mount()
    {
        $this->appointments = Appointment::all();
    }

    public function saveAppointment()
    {
        $this->validate([
            'pet_id' => 'required',
            'veterinarian_id' => 'required',
            'appointment_date' => 'required|date',
            'status' => 'required',
        ]);

        if ($this->selectedAppointmentId) {
            $appointment = Appointment::find($this->selectedAppointmentId);
            $appointment->update([
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $this->veterinarian_id,
                'appointment_date' => $this->appointment_date,
                'status' => $this->status,
                'notes' => $this->notes,
            ]);
        } else {
            Appointment::create([
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $this->veterinarian_id,
                'appointment_date' => $this->appointment_date,
                'status' => $this->status,
                'notes' => $this->notes,
            ]);
        }

        $this->resetInputFields();
        $this->appointments = Appointment::all();
    }

    public function editAppointment($id)
    {
        $appointment = Appointment::find($id);
        $this->selectedAppointmentId = $appointment->id;
        $this->pet_id = $appointment->pet_id;
        $this->veterinarian_id = $appointment->veterinarian_id;
        $this->appointment_date = $appointment->appointment_date;
        $this->status = $appointment->status;
        $this->notes = $appointment->notes;
    }

    public function deleteAppointment($id)
    {
        Appointment::find($id)->delete();
        $this->appointments = Appointment::all();
    }

    private function resetInputFields()
    {
        $this->pet_id = '';
        $this->veterinarian_id = '';
        $this->appointment_date = '';
        $this->status = '';
        $this->notes = '';
        $this->selectedAppointmentId = null;
    }

    public function render()
    {
        $pets = Pet::all();
        $veterinarians = User::role('Veterinario')->get();
        return view('livewire.appointment-manager', compact('pets', 'veterinarians'));
    }
}
