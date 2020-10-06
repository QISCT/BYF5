<?php

namespace App\Http\Livewire\Site;

use App\Models\Site;
use Livewire\Component;

class UpdateContactsForm extends Component
{
    public $contacts = [];
    public $site;

    /**
     * Prepare the component.
     *
     * @param Site $site
     * @return void
     */
    public function mount(Site $site)
    {
        $this->contacts = $this->site->contacts;
        $this->site = $site;
    }

    public function save()
    {
        $this->validate();

        $this->site->update([
            'contacts' => $this->contacts,
        ]);

        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.site.contacts-form');
    }
}
