<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStateTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'state';

    /**
     * Run the migrations.
     * @table state
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('state_id');
            $table->unsignedInteger('country_id');
            $table->string('state', 30);
            $table->tinyInteger('estatus')->default('1');

            $table->index(["country_id"], 'state_fk_1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('country_id', 'state_fk_1_idx')
                ->references('country_id')->on('country')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
