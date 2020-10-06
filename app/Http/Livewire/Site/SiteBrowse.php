<?php

namespace App\Http\Livewire\Site;

use App\Models\Firm;
use App\Models\Site;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;
use Livewire\WithPagination;

class SiteBrowse extends Component
{
    use WithPagination;
    const PAGE_LEN = 4;
    public $model = null;
    public $relationship = null;

    public function mount($scope = null)
    {
        if($scope)
            [$this->model, $this->relationship] = $scope;
    }

    protected function getSites()
    {
        $query = ($this->model && $this->relationship) ? $this->model->{$this->relationship}()->getQuery() : Site::query();

        // Apply filtering here

        return $query->paginate(self::PAGE_LEN);
    }

    public function render()
    {
        return view('livewire.site.site-browse', [
            'sites' => $this->getSites()
        ]);
    }
}
