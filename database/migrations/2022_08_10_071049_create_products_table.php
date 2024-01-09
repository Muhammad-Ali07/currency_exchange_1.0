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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('name');
            $table->string('code');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->boolean('is_purchase_able')->nullable()->default(0);
            $table->boolean('is_taxable')->nullable()->default(0);
            $table->boolean('status')->nullable()->default(0);
            $table->bigInteger('default_sale_price')->nullable()->default(0);
            $table->bigInteger('default_purchase_price')->nullable()->default(0);
            $table->bigInteger('stock_on_hand_units')->nullable()->default(0);
            $table->bigInteger('stock_on_hand_packages')->nullable()->default(0);
            $table->bigInteger('sold_in_quantity')->nullable()->default(0);
            $table->bigInteger('sell_by_package_only')->nullable()->default(0);

            $table->foreign('supplier_id')->references('id')->on('suppliers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('brand_id')->references('id')->on('brands')
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
        Schema::dropIfExists('products');
    }
};
