<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelsLanguageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'labels_language';

    /**
     * Run the migrations.
     * @table labels_language
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('labels_language_id');
            $table->unsignedInteger('label_id');
            $table->unsignedInteger('language_id');
            $table->string('name', 45);
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["label_id"], 'labels_language_idx');

            $table->index(["language_id"], 'labels_language ibfk_2');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('label_id', 'labels_language_idx')
                ->references('label_id')->on('labels')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('language_id', 'labels_language ibfk_2')
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
