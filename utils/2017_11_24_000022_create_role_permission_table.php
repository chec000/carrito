<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'role_permission';

    /**
     * Run the migrations.
     * @table role_permission
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('role_permission_id');
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('modified_by');
            $table->tinyInteger('estatus')->default('1');

            $table->index(["role_id"], 'rel_rol_perfil_ibfk_2_idx');

            $table->index(["permission_id"], 'id_perfil');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('permission_id', 'id_perfil')
                ->references('permission_id')->on('permission')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('role_id', 'rel_rol_perfil_ibfk_2_idx')
                ->references('role_id')->on('role')
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
