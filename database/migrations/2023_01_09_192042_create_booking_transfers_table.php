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
        Schema::create('booking_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('code');
            $table->date('date');

            // new member info
            $table->unsignedBigInteger('nm_customer_id');
            $table->string('nm_customer_name');
            $table->string('nm_registration_no')->nullable();
            $table->string('nm_membership_no')->nullable();
            $table->string('nm_mobile_no')->nullable();
            $table->string('nm_cnic_no')->nullable();
            $table->string('nm_image')->nullable();
            $table->string('nm_nominee_no')->nullable();
            $table->string('nm_nominee_name')->nullable();
            $table->string('nm_nominee_parent_name')->nullable();
            $table->string('nm_nominee_relation')->nullable();
            $table->string('nm_nominee_cnic_no')->nullable();
            $table->string('nm_nominee_contact_no')->nullable();

            // old member info
            $table->unsignedBigInteger('om_customer_id');
            $table->string('om_customer_name');
            $table->string('om_registration_no')->nullable();
            $table->string('om_membership_no')->nullable();
            $table->string('om_mobile_no')->nullable();
            $table->string('om_cnic_no')->nullable();
            $table->string('om_image')->nullable();
            $table->string('om_nominee_no')->nullable();
            $table->string('om_nominee_name')->nullable();
            $table->string('om_nominee_parent_name')->nullable();
            $table->string('om_nominee_relation')->nullable();
            $table->string('om_nominee_cnic_no')->nullable();
            $table->string('om_nominee_contact_no')->nullable();

            // booking detail
            $table->unsignedBigInteger('booking_id');
            $table->string('booking_code');
            $table->unsignedBigInteger('product_id');
            $table->string('product_name');
            $table->unsignedBigInteger('file_status_id');

            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('booking_transfers');
    }
};
