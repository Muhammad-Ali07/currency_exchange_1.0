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
        Schema::create('sale_sellers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sale_id");
            $table->integer("sale_sellerable_id");
            $table->string("sale_sellerable_type");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sale_id')->references('id')->on('sales')
                ->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_sellers');
    }
};
