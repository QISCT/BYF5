<?php
namespace App\DataTables;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class DataTableCell
{

	public $col, $data;

	public function __construct($_col, $_model)
	{
		$this->col = $_col;
		$this->data = $this->getThroughModel($this->col['data'], $_model);
	}

	protected function getThroughModel($accessors, $item)
	{
		if ($accessors == 'ignore')
			return null;
		foreach (explode('-', $accessors) as $accessor) {
			$item = $item->{$accessor} ?? null;
		}
		return $item;
	}
}
