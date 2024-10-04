<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\User;
use App\Models\Veterinarian;

class AppointmentManager extends Component
{
    public $payment_method, $credit_card_number, $credit_card_expiry, $credit_card_cvv, $paypal_email, $payment_amount = 0, $payment_reference;
    public $appointments;
    public $pet_id, $veterinarian_id, $appointment_date, $status, $notes;
    public $is_payment_required = false;
    public $payment_status;
    public $selectedAppointmentId;
    public $searchPetTerm = '';
    public $petSuggestions = [];
    public $veterinarians;
    public $isPaymentModalOpen = false;

    public function mount()
    {
        $this->loadAppointments(); // Cargar las citas al montar el componente
        $this->veterinarians = Veterinarian::with('user')->get(); // Cargar veterinarios

        if ($this->veterinarians->isNotEmpty()) {
            $this->veterinarian_id = request('veterinarian_id') ?? null;
            $this->appointment_date = request('appointment_date') ?? null;
        } else {
            $this->veterinarian_id = null;
            $this->appointment_date = null;
        }
    }

    public function openPaymentModal()
    {
        $this->isPaymentModalOpen = true;
    }

    public function closePaymentModal()
    {
        $this->isPaymentModalOpen = false;
    }

    public function savePayment()
    {        
        $this->validate([
            'payment_method' => 'required',
            'payment_amount' => 'required|numeric',
        ]);

        $this->isPaymentModalOpen = false;
    }

    public function updatedSearchPetTerm()
    {
        $this->loadAppointments();
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
        // Validar los campos básicos primero
        $this->validate([
            'pet_id' => 'required',
            'veterinarian_id' => 'required',  
            'appointment_date' => 'required|date',
        ]);
    
        // Obtener el veterinario por su id de la tabla veterinarians
        $veterinarian = Veterinarian::find($this->veterinarian_id);
        if (!$veterinarian) {
            session()->flash('error', 'Veterinario no encontrado.');
            return;
        }
    
        // Verificar si el veterinario trabaja el día de la cita
        $appointmentDayOfWeek = (new \DateTime($this->appointment_date))->format('N'); // 1 (Lunes) - 7 (Domingo)
        $worksOnDay = $this->veterinarianWorksOnDay($veterinarian, $appointmentDayOfWeek);
    
        if (!$worksOnDay) {
            session()->flash('error', 'El veterinario no trabaja en el día seleccionado.');
            return;
        }
    
        $userId = $veterinarian->user_id;
    
        // Verificar si ya existe una cita con el mismo veterinario (user_id) y la misma fecha/hora
        $existingAppointment = Appointment::where('veterinarian_id', $userId)
            ->where('appointment_date', $this->appointment_date)
            ->first();
    
        if ($existingAppointment && (!$this->selectedAppointmentId || $existingAppointment->id != $this->selectedAppointmentId)) {
            session()->flash('error', 'Este veterinario ya tiene una cita a esa hora.');
            return;
        }
    
        // Asignar el status basado en el payment_amount
        $this->status = ($this->payment_amount == 50) ? 'Pagado' : 'En proceso';
    
        // Si estamos editando una cita existente, actualizamos
        if ($this->selectedAppointmentId) {
            $appointment = Appointment::find($this->selectedAppointmentId);
            $appointment->update([
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $userId,
                'appointment_date' => $this->appointment_date,
                'status' => $this->status,
                'notes' => $this->notes,
                'is_payment_required' => $this->is_payment_required,
                'payment_status' => $this->is_payment_required ? 'pending' : null,
                'payment_method' => $this->payment_method,
                'payment_amount' => $this->payment_amount,
                'payment_reference' => $this->payment_reference,
            ]);
        } else {
            // Si es una cita nueva, la creamos
            Appointment::create([
                'pet_id' => $this->pet_id,
                'veterinarian_id' => $userId,
                'appointment_date' => $this->appointment_date,
                'status' => $this->status,
                'notes' => $this->notes,
                'is_payment_required' => $this->is_payment_required,
                'payment_status' => $this->is_payment_required ? 'pending' : null,
                'payment_method' => $this->payment_method,
                'payment_amount' => $this->payment_amount,
                'payment_reference' => $this->payment_reference,
            ]);
        }
    
        $this->resetInputFields();
        $this->loadAppointments(); 
        session()->flash('message', $this->selectedAppointmentId ? 'Cita actualizada exitosamente.' : 'Cita añadida exitosamente.');
    }
    
    // Función para verificar si el veterinario trabaja en el día seleccionado
    private function veterinarianWorksOnDay($veterinarian, $dayOfWeek)
    {
        switch ($dayOfWeek) {
            case 1:
                return $veterinarian->works_on_monday;
            case 2:
                return $veterinarian->works_on_tuesday;
            case 3:
                return $veterinarian->works_on_wednesday;
            case 4:
                return $veterinarian->works_on_thursday;
            case 5:
                return $veterinarian->works_on_friday;
            case 6:
                return $veterinarian->works_on_saturday;
            case 7:
                return $veterinarian->works_on_sunday;
            default:
                return false;
        }
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
        $this->loadAppointments();
    }

    // Función para resetear los campos
    private function resetInputFields()
    {
        $this->pet_id = '';
        $this->veterinarian_id = '';
        $this->appointment_date = '';
        $this->status = '';
        $this->notes = '';
        $this->is_payment_required = false;
        $this->payment_method = '';
        $this->payment_amount = '';
        $this->payment_reference = '';
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
