<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOmnilifeEntrepreneurTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'omnilife_entrepreneur';

    /**
     * Run the migrations.
     * @table omnilife_entrepreneur
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('eo_id');
            $table->unsignedInteger('country_id');
            $table->string('names', 100);
            $table->string('last_name', 100);
            $table->string('mothers_last_name', 100)->nullable()->default(null);
            $table->string('email', 100);
            $table->string('gender', 15);
            $table->date('birthday');
            $table->string('phone', 15);
            $table->string('sponsor', 15)->nullable()->default(null);
            $table->unsignedInteger('security_question_id');
            $table->string('answer_security_question', 50)->nullable()->default(null);
            $table->enum('user_type', ['EO', 'ADMIRABLE_CUSTOMER'])->nullable()->default(null);
            $table->tinyInteger('estatus')->default('1');

            $table->index(["security_question_id"], 'omnilife_entrepreneur_fk1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('security_question_id', 'omnilife_entrepreneur_fk1_idx')
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
