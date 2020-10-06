<?php

namespace App\Http\Livewire\Firm;

use App\Models\Firm;
use Livewire\Component;

class FirmUpdate extends FirmCreate
{
    public Firm $firm;

    public function mount()
    {
        parent::mount();

        $this->firm = (func_get_args()[0] instanceof Firm) ? func_get_args()[0] : new Firm();
        foreach(array_keys($this->rules) as $field)
            if($this->hasProperty($field))
                $this->$field = $this->firm->$field;
    }

    public function save()
    {
        $this->validate();

        foreach(array_keys($this->rules) as $field)
            if($this->hasProperty($field) && $this->firm->$field !== $this->$field)
                $this->firm->$field = $this->$field;

        $this->firm->saveOrFail();

        return redirect()->to(route('firms.show', $this->firm));
    }
}
