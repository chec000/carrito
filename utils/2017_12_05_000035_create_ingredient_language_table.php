<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientLanguageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'ingredient_language';

    /**
     * Run the migrations.
     * @table ingredient_language
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('ingredient_language_id');
            $table->unsignedInteger('ingredient_id');
            $table->unsignedInteger('language_id');
            $table->string('ingredient', 45);
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["language_id"], 'ingredient_fk_2_idx');

            $table->index(["ingredient_id"], 'ingredient_fk_10_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('ingredient_id', 'ingredient_fk_10_idx')
                ->references('ingredient_id')->on('ingredient')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('language_id', 'ingredient_fk_2_idx')
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
