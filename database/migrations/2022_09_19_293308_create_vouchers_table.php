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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('voucher_id');
            $table->date('date');
            $table->string('type');
            $table->string('voucher_no');
            $table->bigInteger('sr_no');
            $table->unsignedBigInteger("chart_account_id");
            $table->string('chart_account_name');
            $table->string('chart_account_code');
            $table->unsignedBigInteger('payment_mode_id');
            $table->double('debit',15,3)->default(0);
            $table->double('credit',15,3)->default(0);
            $table->string('description')->nullable();
            $table->string('remarks')->nullable();
            $table->double('tax_perc',15,3)->nullable();
            $table->double('tax_amount',15,3)->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('cheque_no')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->string('invoice_no')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('chart_account_id')->references('id')->on('chart_of_accounts')
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
