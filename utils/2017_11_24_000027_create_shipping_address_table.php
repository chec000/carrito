<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingAddressTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'shipping_address';

    /**
     * Run the migrations.
     * @table shipping_address
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('shipping_address_id');
            $table->unsignedInteger('eo_id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('state_id');
            $table->string('address', 100);
            $table->string('external_number', 45)->nullable()->default(null);
            $table->string('internal_number', 45)->nullable()->default(null);
            $table->mediumText('references')->nullable()->default(null);
            $table->string('zip', 15);
            $table->string('suburb', 80);
            $table->string('city_key', 5);
            $table->string('city', 45);

            $table->index(["eo_id"], 'shipping_address_ibfk_3_idx');

            $table->index(["state_id"], 'id_estado');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('state_id', 'id_estado')
                ->references('state_id')->on('state')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('eo_id', 'shipping_address_ibfk_3_idx')
                ->references('eo_id')->on('omnilife_entrepreneur')
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
