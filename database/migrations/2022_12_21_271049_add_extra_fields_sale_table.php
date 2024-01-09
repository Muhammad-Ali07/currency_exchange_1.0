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
        Schema::table('sales', function (Blueprint $table) {
            $table->float('down_payment')->nullable()->after('currency_note_no');
            $table->float('on_balloting')->nullable()->after('down_payment');
            $table->float('no_of_bi_annual')->nullable()->after('on_balloting');
            $table->float('installment_bi_annual')->nullable()->after('no_of_bi_annual');
            $table->float('no_of_month')->nullable()->after('installment_bi_annual');
            $table->float('installment_amount_monthly')->nullable()->after('no_of_month');
            $table->float('on_possession')->nullable()->after('installment_amount_monthly');
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
