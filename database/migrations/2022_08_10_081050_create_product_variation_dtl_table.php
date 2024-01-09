<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation_dtl', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('value_type');
            $table->unsignedBigInteger('product_variation_id');
            $table->unsignedBigInteger('buyable_type_id');
            $table->bigInteger('sr_no');
            $table->string('value')->nullable();

            $table->foreign('product_variation_id')->references('id')->on('product_variations')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('buyable_type_id')->references('id')->on('buyable_types')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation_dtl');
    }
};
