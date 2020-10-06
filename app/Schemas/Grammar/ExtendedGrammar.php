<?php

namespace App\Schemas\Grammars;

use Illuminate\Database\Schema\Grammars\MySqlGrammar;
use Illuminate\Support\Fluent;

/**
 * Extended version of MySqlGrammar with
 * support of 'set' data type
 */
class ExtendedGrammar extends MySqlGrammar
{

    /**
     * Create the column definition for an 'set' type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeSafeJson(Fluent $column)
    {
        return "set('" . implode("', '", $column->allowed) . "')";
    }

}
