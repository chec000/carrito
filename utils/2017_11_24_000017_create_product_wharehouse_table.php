<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductWharehouseTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'product_wharehouse';

    /**
     * Run the migrations.
     * @table product_wharehouse
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('product_wharehouse_id');
            $table->unsignedInteger('wharehouse_id');
            $table->unsignedInteger('product_id');
            $table->integer('stock')->nullable()->default(null);
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["product_id"], 'id_producto');

            $table->index(["wharehouse_id"], 'id_almacen');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('wharehouse_id', 'id_almacen')
                ->references('wharehouse_id')->on('wharehouse')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('product_id', 'id_producto')
                ->references('product_id')->on('product')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
