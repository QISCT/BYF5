<?php

namespace App\Http\Livewire\Site;

use App\Models\Site;
use Livewire\Component;

class SiteCreate extends Component
{
    public $name;
    public $status;
    public $status_options;
    public $contacts = [[]];
    public $domains = [['cat' => 'primary']];
    public $firm;

    protected $listeners = ['addContactRow', 'removeContactRow'];
    protected $rules = [
        'name' => 'required',
        'status' => 'required|integer',
    ];

    public function mount($firm)
    {
        $this->firm = $firm;
        $this->status_options = Site::$STATUS_CODES;
    }

    function addContactRow()
    {
        $this->contacts[] = [];
    }

    function removeContactRow($i)
    {
        $this->contacts = collect($this->contacts)->forget($i)->values()->all();
    }

    public function updated($propName)
    {
        $this->validateOnly($propName, $this->rules);
    }

    public function save()
    {
        $this->validate();

        $site = $this->firm->sites()->create([
            'name' => $this->name,
            'status' => $this->status,
            'domains' => $this->domains,
            'contacts' => $this->contacts,
        ]);

        return redirect()->to(route('firms.sites.show', $site));
    }


    public function render()
    {
        return view('livewire.site.site-form');
    }
}
