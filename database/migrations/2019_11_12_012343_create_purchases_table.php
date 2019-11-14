<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company');
            $table->string('ref_no')->nullable();
            $table->text('supplier');
            $table->string('term')->nullable();
            $table->date('delivery_date');
            $table->date('po_valid');
            $table->string('ship_to');
            $table->string('location');
            $table->string('remarks');
            $table->string('preparedBy');
            $table->string('notedBy');
            $table->string('approvedBy');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
