<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageLanguageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'package_language';

    /**
     * Run the migrations.
     * @table package_language
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('package_language_id');
            $table->unsignedInteger('package_id');
            $table->unsignedInteger('language_id');
            $table->string('name', 100);
            $table->text('description');
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["package_id"], 'id_combo');

            $table->index(["language_id"], 'id_idioma');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('package_id', 'id_combo')
                ->references('package_id')->on('package')
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
