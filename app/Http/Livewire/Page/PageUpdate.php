<?php

namespace App\Http\Livewire\Page;

use App\Models\Site;

class PageUpdate extends PageCreate
{
    public $page;

    public function mount($page)
    {
        $this->page = $page;
        $this->site = $page->site;

        $this->name = $this->page->name;
        $this->slug = $this->page->slug;
    }

    public function save()
    {
        $this->validate();

        $this->page->update([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        return redirect()->to(route('sites.pages.show', [$this->page->site, $this->page]));
    }
}
