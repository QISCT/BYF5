<?php

use App\Schemas\Blueprints\ExtendedBlueprint;
use App\Schemas\Grammars\ExtendedGrammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::connection()->setSchemaGrammar(new ExtendedGrammar());
        $schema = DB::connection()->getSchemaBuilder();
        $schema->blueprintResolver(function($table, $callback) {
            return new ExtendedBlueprint($table, $callback);
        });

        $schema->create('sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('firm_id')->unsigned();
            $table->string('name');
            $table->string('account')->nullable();
            $table->safeJson('domains')->nullable();
            $table->integer('status')->unsigned();
            $table->safeJson('contacts')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}
