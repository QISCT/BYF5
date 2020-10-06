<?php

namespace App\Http\Livewire\Firm;

use App\Models\Firm;
use Livewire\Component;
use Livewire\WithPagination;

class FirmBrowse extends Component
{
    use WithPagination;
    const PAGE_LEN = 6;

    protected function getFirms()
    {
        $query = Firm::query();

        // Apply filtering here

        return $query->paginate(self::PAGE_LEN);
    }

    public function render()
    {
        return view('livewire.firm.firm-browse', [
            'firms' => $this->getFirms(),
        ]);
    }
}
