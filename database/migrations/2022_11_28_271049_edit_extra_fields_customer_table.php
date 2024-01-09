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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('mobile_no')->nullable()->change();
            $table->string('father_name')->nullable()->change();
            $table->string('husband_name')->nullable()->change();
            $table->string('registration_no')->nullable()->change();
            $table->string('membership_no')->nullable()->change();
            $table->string('nominee_no')->nullable()->change();
            $table->string('nominee_name')->nullable()->change();
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
