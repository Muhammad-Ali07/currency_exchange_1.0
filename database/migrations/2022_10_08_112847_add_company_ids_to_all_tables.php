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
        Schema::table('brands', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });

        Schema::table('buyable_types', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('category_type_id');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('category_types', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('chart_of_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('region_id');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('country_status');
            $table->boolean('status')->default(0)->after('default_country');
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('dealers', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('departments', function (Blueprint $table){
            $table->boolean('status')->default(0)->after('name');
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('manufacturers', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('payment_modes', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('sell_by_package_only');
            $table->unsignedBigInteger('user_id')->nullable()->after('company_id');
        });
        Schema::table('product_variations', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('value_type');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('product_variation_dtl', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('value');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('projects', function (Blueprint $table){
            $table->dropForeign('projects_country_id_foreign');
            $table->dropForeign('projects_region_id_foreign');
            $table->dropForeign('projects_city_id_foreign');
            $table->dropColumn('country_id');
            $table->dropColumn('region_id');
            $table->dropColumn('city_id');
            $table->dropColumn('address');
            $table->unsignedBigInteger('user_id')->nullable()->after('company_id');
        });
        Schema::table('property_variations', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('value');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('regions', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('country_id');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });;
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('booked_price');
            $table->unsignedBigInteger('user_id')->nullable()->after('company_id');
        });
        Schema::table('staffs', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('department_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('company_id');
        });
        Schema::table('suppliers', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('status');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('uuid')->after('id');
            $table->unsignedBigInteger('company_id')->nullable()->after('remember_token');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
        });
        Schema::table('vouchers', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('invoice_no');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('project_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
