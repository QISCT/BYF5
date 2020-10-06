<?php

namespace App\Http\Livewire\Page;

use App\Models\Page;
use Livewire\Component;

class PageCreate extends Component
{
    public $name;
    public $slug;

    public $site;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required',
    ];

    public function mount($site)
    {
        $this->site = $site;
    }

    public function updated($propName)
    {
        $this->validateOnly($propName, $this->rules);
    }

    public function save()
    {
        $this->validate();

        $page = $this->site->pages()->create([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        return redirect()->to(route('sites.pages.show', [$page->site, $page]));
    }


    public function render()
    {
        return view('livewire.page.page-form');
    }
}
