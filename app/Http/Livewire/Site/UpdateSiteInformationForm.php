<?php

namespace App\Http\Livewire\Site;

use App\Models\Site;
use Livewire\Component;

class UpdateSiteInformationForm extends Component
{
    public $name;
    public $status;
    public $site;

    protected $rules = [
        'name' => 'required',
        'status' => 'required|integer',
    ];

    /**
     * Prepare the component.
     *
     * @param Site $site
     * @return void
     */
    public function mount(Site $site)
    {
        $this->site = $site;
        $this->name = $this->site->name;
        $this->status = $this->site->status;
    }

    public function save()
    {
        $this->validate();

        $this->site->update([
            'name' => $this->name,
            'status' => $this->status,
        ]);

        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.site.information-form', ['status_options' => Site::$STATUS_CODES]);
    }
}
