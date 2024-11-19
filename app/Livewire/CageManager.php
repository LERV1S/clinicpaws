<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cage;

class CageManager extends Component
{
    public $cages;
    public $cage_number, $size, $is_occupied;
    public $selectedCageId;

    public function mount()
    {
        $this->cages = Cage::all();
    }

    public function saveCage()
    {
        $this->validate([
            'cage_number' => 'required',
            'size' => 'required',
            'is_occupied' => 'boolean',
        ]);

        if ($this->selectedCageId) {
            $cage = Cage::find($this->selectedCageId);
            $cage->update([
                'cage_number' => $this->cage_number,
                'size' => $this->size,
                'is_occupied' => $this->is_occupied,
            ]);
        } else {
            Cage::create([
                'cage_number' => $this->cage_number,
                'size' => $this->size,
                'is_occupied' => $this->is_occupied,
            ]);
        }

        $this->resetInputFields();
        $this->cages = Cage::all();
    }

    public function editCage($id)
    {
        $cage = Cage::find($id);
        $this->selectedCageId = $cage->id;
        $this->cage_number = $cage->cage_number;
        $this->size = $cage->size;
        $this->is_occupied = $cage->is_occupied;
    }

    public function deleteCage($id)
    {
        Cage::find($id)->delete();
        $this->cages = Cage::all();
    }

    private function resetInputFields()
    {
        $this->cage_number = '';
        $this->size = '';
        $this->is_occupied = false;
        $this->selectedCageId = null;
    }

    public function render()
    {
        return view('livewire.cage-manager');
    }
}
