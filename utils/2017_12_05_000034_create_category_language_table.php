<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryLanguageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'category_language';

    /**
     * Run the migrations.
     * @table category_language
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('category_language_id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('category_id');
            $table->string('category', 60);
            $table->tinyInteger('estatus');

            $table->index(["language_id"], 'category_language_ibfk_1_idx');

            $table->index(["category_id"], 'category_language_ibfk_2_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('language_id', 'category_language_ibfk_1_idx')
                ->references('language_id')->on('language')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('category_id', 'category_language_ibfk_2_idx')
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
