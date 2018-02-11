<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerLanguageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'banner_language';

    /**
     * Run the migrations.
     * @table banner_language
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('banner_language_id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('banner_id');
            $table->string('main_image', 100);
            $table->string('name', 45);
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["language_id"], 'banner_language_ibfk_10_idx');

            $table->index(["banner_id"], 'banner_language_ibfk_20_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('language_id', 'banner_language_ibfk_10_idx')
                ->references('language_id')->on('language')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('banner_id', 'banner_language_ibfk_20_idx')
                ->references('banner_id')->on('banner')
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
