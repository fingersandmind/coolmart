<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_form', function (Blueprint $table) {
            $table->primary(['detail_id', 'form_id']);
            $table->unsignedBigInteger('detail_id');
            $table->unsignedBigInteger('form_id');
            $table->timestamps();

            $table->foreign('detail_id')->references('id')->on('details')->onDelete('cascade');
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_form');
    }
}
