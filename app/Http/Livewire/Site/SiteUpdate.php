<?php

namespace App\Http\Livewire\Site;

use App\Models\Site;
use Livewire\Component;

class SiteUpdate extends SiteCreate
{
    public $site;

    public function mount($site)
    {
        $this->site = $site;
        $this->firm = $site->firm;
        $this->status_options = Site::$STATUS_CODES;

        $this->name = $this->site->name;
        $this->status = $this->site->status;
        $this->domains = $this->site->domains;
        $this->contacts = $this->site->contacts;
    }

    public function save()
    {
        $this->validate();

        $this->site->update([
            'name' => $this->name,
            'status' => $this->status,
            'domains' => $this->domains,
            'contacts' => $this->contacts,
        ]);

        return redirect()->to(route('sites.show', $this->site));
    }
}
