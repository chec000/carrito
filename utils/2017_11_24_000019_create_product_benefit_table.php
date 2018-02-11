<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBenefitTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'product_benefit';

    /**
     * Run the migrations.
     * @table product_benefit
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('product_benefit_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('benefit_id');
            $table->tinyInteger('estatus')->default('1');
            $table->unsignedInteger('modified_by');

            $table->index(["benefit_id"], 'id_beneficio');

            $table->index(["product_id"], 'id_producto');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('product_id', 'id_producto')
                ->references('product_id')->on('product')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('benefit_id', 'id_beneficio')
                ->references('benefit_id')->on('benefit')
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
