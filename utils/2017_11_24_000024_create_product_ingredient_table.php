<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductIngredientTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'product_ingredient';

    /**
     * Run the migrations.
     * @table product_ingredient
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('product_ingredient_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('ingredient_id');
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["product_id"], 'product_ingredient_fk_2_idx');

            $table->index(["ingredient_id"], 'product_ingredient_fk_1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('ingredient_id', 'product_ingredient_fk_1_idx')
                ->references('ingredient_id')->on('ingredient')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('product_id', 'product_ingredient_fk_2_idx')
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
