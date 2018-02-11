<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'product_category';

    /**
     * Run the migrations.
     * @table product_category
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('product_category_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["product_id"], 'product_category_fk1_idx');

            $table->index(["category_id"], 'product_category_fk2_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('product_id', 'product_category_fk1_idx')
                ->references('product_id')->on('product')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('category_id', 'product_category_fk2_idx')
                ->references('category_id')->on('category')
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
