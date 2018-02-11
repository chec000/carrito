<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecurityQuestionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'security_question';

    /**
     * Run the migrations.
     * @table security_question
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('security_question_id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('country_id');
            $table->mediumText('question');
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["language_id"], 'security_question_ibfk_2_idx');

            $table->index(["country_id"], 'id_pais');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('country_id', 'id_pais')
                ->references('country_id')->on('country')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('language_id', 'security_question_ibfk_2_idx')
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
