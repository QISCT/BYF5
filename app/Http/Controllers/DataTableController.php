<?php

namespace App\Http\Controllers;

use App\DataTables\DataTableResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class DataTableController
 * @package App\Http\Controllers\DataTableController
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DataTableController extends Controller
{
    public function index($model, Request $request)
    {
        ini_set('memory_limit', '256M');
        $request = $request->all();

        $model = 'App\\Model\\' . $model;
        if (!class_exists($model))
            dd('Model not found at: ' . $model);

        $response = new DataTableResponse($model, $request);
        return $response->toJSON();
    }
}
