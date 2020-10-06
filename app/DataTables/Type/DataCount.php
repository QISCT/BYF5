<?php


namespace App\DataTables\Type;

use App\DataTables\DataTableCell;
use Illuminate\Database\Eloquent\Model;
use App\DataTables\Type\DataTypeInterface;
use Illuminate\Support\Collection;

class DataCount extends DataTableCell implements DataTypeInterface
{

	public function render(Model $item)
	{
		return '<span class="badge badge-mw badge-dark">' .
			$this->data->count() .
			'</span>';
	}

	public function value()
	{
		return $this->data->count();
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
