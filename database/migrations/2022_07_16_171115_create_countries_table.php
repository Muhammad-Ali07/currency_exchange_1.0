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
        Schema::create('countries', function (Blueprint $table) {

            $table->id();
            $table->string('uuid');
            $table->string('name')->unique();
            $table->boolean('default_country')->default(0);
            $table->boolean('country_status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /** TblDefiCountry
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_defi_country');
    }
};
