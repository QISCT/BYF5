<?php


namespace App\DataTables\Type;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface DataTypeInterface
{
	public function render(Model $item);

	public function value();

//	public static function search();
//
//	public static function sort();
}