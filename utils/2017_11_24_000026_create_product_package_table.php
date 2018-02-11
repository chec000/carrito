<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPackageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'product_package';

    /**
     * Run the migrations.
     * @table product_package
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('product_package_id');
            $table->unsignedInteger('package_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["package_id"], 'id_combo');

            $table->index(["product_id"], 'id_producto');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('package_id', 'id_combo')
                ->references('package_id')->on('package')
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
