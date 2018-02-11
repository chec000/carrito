<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductLanguageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'product_language';

    /**
     * Run the migrations.
     * @table product_language
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('product_language_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('language_id');
            $table->string('name', 80);
            $table->text('description');
            $table->text('short_description');
            $table->mediumText('consupsion_tips');
            $table->string('nutritional_table', 100);
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["product_id"], 'id_producto');

            $table->index(["language_id"], 'id_idioma');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('product_id', 'id_producto')
                ->references('product_id')->on('product')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('language_id', 'id_idioma')
                ->references('language_id')->on('language')
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
