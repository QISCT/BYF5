<?php

function DataCellFactory($col, $model = false)
{
	$type = 'App\\DataTables\\Type\\Data' . ucfirst(strtolower(trim($col['type'])));

	if($model)
		return new $type($col, $model);
	else
		return $type;
}