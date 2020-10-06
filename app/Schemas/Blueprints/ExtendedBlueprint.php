<?php

namespace App\Schemas\Blueprints;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use PDO;

/**
 * Extended version of Blueprint with
 * support of 'safeJson' data type
 */
class ExtendedBlueprint extends Blueprint
{

    /**
     * Create a new 'set' column on the table.
     *
     * @param string $column
     * @param array $allowed
     * @return Fluent
     */
    public function safeJson($column)
    {
        if ((DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') && version_compare(DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.8', 'ge'))
            return parent::json($column);
        else
            return parent::text($column);
    }

}
