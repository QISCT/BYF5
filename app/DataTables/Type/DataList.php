<?php


namespace App\DataTables\Type;

use App\DataTables\DataTableCell;
use Illuminate\Database\Eloquent\Model;
use App\DataTables\Type\DataTypeInterface;
use Illuminate\Support\Collection;

class DataList extends DataTableCell implements DataTypeInterface
{

	public function render(Model $item)
	{
		$value = '';
		foreach ($this->data as $li)
			$value .= trim($li->{$this->col['key']} ?? null) . '<br />';
		return $value;
	}

	public function value()
	{
		return collect($this->data)->pluck($this->col['key']);
	}

	public static function search()
	{
		return function (Collection $collection, $needle) {
			return $collection->filter(function ($value, $key) use ($needle) {
				if (strpos($needle, $value) !== false)
					return true;
				elseif ($needle == $value)
					return true;
				else
					return false;
			});
		};
	}

	public static function sort()
	{
		return function (Collection $collection) {
			return $collection->sort();
		};
	}
}
