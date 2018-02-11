<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecurityQuestionLanguageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'security_question_language';

    /**
     * Run the migrations.
     * @table security_question_language
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('security_question_language_id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('security_question_id');
            $table->mediumText('question');
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["security_question_id"], 'security_question_ibfk_20_idx');

            $table->index(["language_id"], 'security_question_ibfk_10_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('language_id', 'security_question_ibfk_10_idx')
                ->references('language_id')->on('language')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('security_question_id', 'security_question_ibfk_20_idx')
                ->references('security_question_id')->on('security_question')
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
