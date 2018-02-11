<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenefitLanguageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'benefit_language';

    /**
     * Run the migrations.
     * @table benefit_language
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('benefit_language_id');
            $table->unsignedInteger('benefit_id');
            $table->unsignedInteger('language_id');
            $table->string('benefit', 100);
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["benefit_id"], 'cat_benefit_language_id_fk1_idx');

            $table->index(["language_id"], 'cat_benefit_language_id_fk_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('language_id', 'cat_benefit_language_id_fk_idx')
                ->references('language_id')->on('language')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('benefit_id', 'cat_benefit_language_id_fk1_idx')
                ->references('benefit_id')->on('benefit')
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
