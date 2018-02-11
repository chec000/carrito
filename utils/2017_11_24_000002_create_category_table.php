<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'category';

    /**
     * Run the migrations.
     * @table category
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('category_id');
            $table->unsignedInteger('country_id');
            $table->tinyInteger('is_main_category')->default('0');
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');
            $table->integer('list_order')->nullable()->default('0');

            $table->index(["country_id"], 'id_pais');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('country_id', 'id_pais')
                ->references('country_id')->on('country')
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
