<?php

namespace App\Http\Livewire\Page;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;

class PageBrowse extends Component
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

    protected function getPages()
    {
        $query = ($this->model && $this->relationship) ? $this->model->{$this->relationship}()->getQuery() : Page::query();
        // Apply filtering here
        return $query->paginate(self::PAGE_LEN);
    }
    public function render()
    {
        return view('livewire.page.page-browse', [
            'pages' => $this->getPages()
        ]);
    }
}
