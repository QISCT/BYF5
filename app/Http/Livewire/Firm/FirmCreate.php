<?php

namespace App\Http\Livewire\Firm;

use App\Models\Firm;
use Livewire\Component;

class FirmCreate extends Component
{
    public $name;
    public $type;
    public $options;

    protected $rules = [
        'name' => 'required|min:6',
        'type' => 'required',
    ];

    public function mount()
    {
        $this->options = Firm::$TYPES;
    }

    public function updated($propName)
    {
        $this->validateOnly($propName, $this->rules);
    }

    public function save()
    {
        $this->validate();

        $firm = Firm::create([
            'name' => $this->name,
            'type' => $this->type,
        ]);

        return redirect()->to(route('firms.show', $firm));
    }

    public function render()
    {
        return view('livewire.firm.firm-form');
    }
}
