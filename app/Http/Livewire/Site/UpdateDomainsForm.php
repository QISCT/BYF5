<?php

namespace App\Http\Livewire\Site;

use App\Models\Site;
use Livewire\Component;

class UpdateDomainsForm extends Component
{

    public $domains = [];
    public $site;

    /**
     * Prepare the component.
     *
     * @param Site $site
     * @return void
     */
    public function mount(Site $site)
    {
        $this->domains = $this->site->domains;
        $this->site = $site;
    }

    public function save()
    {
        $this->validate();

        $this->site->update([
            'domains' => $this->domains,
        ]);

        $this->emit('saved');
    }


    public function render()
    {
        return view('livewire.site.domains-form');
    }
}
