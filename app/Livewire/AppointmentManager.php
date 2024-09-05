<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\User;
use App\Models\Veterinarian;

class AppointmentManager extends Component
{
    public $appointments;
    public $pet_id, $veterinarian_id, $appointment_date, $status, $notes;
    public $selectedAppointmentId;
    public $searchPetTerm = '';
    public $petSuggestions = [];
    public $veterinarians;

    public function mount()
    {
        $this->loadAppointments(); // Cargar las citas al montar el componente
        $this->veterinarians = Veterinarian::with('user')->get(); // Cargar veterinarios
    }

    public function updatedSearchPetTerm()
    {
        $this->loadAppointments(); // Filtrar citas cuando cambie el término de búsqueda
        $this->petSuggestions = Pet::where('name', 'like', '%' . $this->searchPetTerm . '%')->get();
    }

    public function loadAppointments()
    {
        $this->appointments = Appointment::whereHas('pet', function ($query) {
            $query->where('name', 'like', '%' . $this->searchPetTerm . '%');
        })->with(['pet', 'veterinarian.user'])->get();
    }

    public function selectPet($petId)
    {
        $this->pet_id = $petId;
        $this->searchPetTerm = Pet::find($petId)->name;
        $this->petSuggestions = [];
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
        $this->loadAppointments(); // Refrescar la lista de citas
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
        $this->loadAppointments(); // Refrescar la lista de citas
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
        return view('livewire.appointment-manager', [
            'appointments' => $this->appointments,
            'veterinarians' => $this->veterinarians,
        ]);
    }
}
