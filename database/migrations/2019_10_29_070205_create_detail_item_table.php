<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_item', function (Blueprint $table) {
            $table->primary(['detail_id', 'item_id']);
            $table->unsignedBigInteger('detail_id');
            $table->unsignedBigInteger('item_id');

            $table->foreign('detail_id')->references('id')->on('details')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_item');
    }
}
