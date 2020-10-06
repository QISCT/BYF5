<?php
namespace App\DataTables;

use App\DataTables\DataTableCell;
use Illuminate\Support\Collection;
use function foo\func;

class DataTableRow
{
	public $cells, $id, $model, $cols;

	public function __construct($_model, $_cols)
	{
		$this->id = $_model->id;
		$this->model = $_model;
		$this->cols = $_cols;


		$this->cells = $this->cols->map(function($col) {
			return DataCellFactory($col, $this->model);
		});
	}

	public function getCell($key)
	{
		if(is_string($key))
			$this->getKeyByColName($key);

		return $this->cells[$key] ?? null;
	}

	protected function getKeyByColName (&$key){
		$key = $this->cols->where('name', $key)->keys()[0];
	}
}
