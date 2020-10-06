<?php


namespace App\DataTables\Type;

use App\DataTables\DataTableCell;
use Illuminate\Database\Eloquent\Model;
use App\DataTables\Type\DataTypeInterface;
use Illuminate\Support\Collection;

class DataBtn extends DataTableCell implements DataTypeInterface
{

	public function render(Model $item)
	{
		return "<a href=\"{$this->getThroughModel($col['data'], $item)}\" " .
			"class=\"{$col['classes']}\">" .
			$col['icon'] . " " . $col['text'] .
			"</a>";
	}

	public function value()
	{
		return 'btn';
	}

	public static function search()
	{
		return function(Collection $collection, $needle) {
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
