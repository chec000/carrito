<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestimonyTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'testimony';

    /**
     * Run the migrations.
     * @table testimony
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('testimony_id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('product_id');
            $table->string('name', 45);
            $table->string('photo', 45)->nullable()->default(null);
            $table->text('testimony');
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["language_id"], 'cat_tipo_producto_ibfk_2_idx');

            $table->index(["country_id"], 'id_pais');

            $table->index(["product_id"], 'cat_tipo_producto_ibfk_3_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('country_id', 'id_pais')
                ->references('country_id')->on('country')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('language_id', 'cat_tipo_producto_ibfk_2_idx')
                ->references('language_id')->on('language')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('product_id', 'cat_tipo_producto_ibfk_3_idx')
                ->references('product_id')->on('product')
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
