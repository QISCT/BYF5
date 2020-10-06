<?php


namespace App\Traits;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

trait HasSchema
{
    public static function getPossibleEnumValues($field_name)
    {
        $default_connection = Config::get('database.default');
        $table_prefix = Config::get('database.connections.'.$default_connection.'.prefix');

        $instance = new static(); // create an instance of the model to be able to get the table name
        $connectionName = $instance->getConnectionName();
        $type = DB::connection($connectionName)->select(DB::raw('SHOW COLUMNS FROM `'.$table_prefix.$instance->getTable().'` WHERE Field = "'.$field_name.'"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = [];
        foreach (explode(',', $matches[1]) as $value) {
            $enum[] = trim($value, "'");
        }

        return $enum;
    }

    public static function getEnumValuesAsAssociativeArray($field_name)
    {
        $instance = new static();
        $enum_values = $instance->getPossibleEnumValues($field_name);

        $array = array_flip($enum_values);

        foreach ($array as $key => $value) {
            $array[$key] = $key;
        }

        return $array;
    }

    public static function isColumnNullable($column_name)
    {
        // create an instance of the model to be able to get the table name
        $instance = new static();

        $conn = DB::connection($instance->getConnectionName());
        $table = Config::get('database.connections.'.Config::get('database.default').'.prefix').$instance->getTable();

        // MongoDB columns are alway nullable
        if ($conn->getConfig()['driver'] === 'mongodb') {
            return true;
        }

        // register the enum, json and jsonb column type, because Doctrine doesn't support it
        $conn->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $conn->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('json', 'json_array');
        $conn->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('jsonb', 'json_array');
        try {
            //check if column exists in database
            $conn->getDoctrineColumn($table, $column_name);

            return ! $conn->getDoctrineColumn($table, $column_name)->getNotnull();
        } catch (\Exception $e) {
            return true;
        }
    }
}