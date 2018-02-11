<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'order_status';

    /**
     * Run the migrations.
     * @table order_status
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('order_status_id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('language_id');
            $table->string('order_status', 45);
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["country_id"], 'id_pais');

            $table->index(["language_id"], 'order_status_ibfk_1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('country_id', 'id_pais')
                ->references('country_id')->on('country')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('language_id', 'order_status_ibfk_1_idx')
                ->references('language_id')->on('language')
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
