<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductLabelsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'product_labels';

    /**
     * Run the migrations.
     * @table product_labels
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('product_labels_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('label_id');
            $table->timestamp('crrated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->tinyInteger('estatus');

            $table->index(["product_id"], 'product_labels_fk_1_idx');

            $table->index(["label_id"], 'product_labels_fk_2_idx');
            $table->softDeletes();


            $table->foreign('product_id', 'product_labels_fk_1_idx')
                ->references('product_id')->on('product')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('label_id', 'product_labels_fk_2_idx')
                ->references('label_id')->on('labels')
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
