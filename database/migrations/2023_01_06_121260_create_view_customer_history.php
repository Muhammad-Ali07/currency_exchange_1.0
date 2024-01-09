<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW `view_customer_history` AS
        SELECT
          `products`.`id` AS `id`,
          `products`.`code` AS `code`,
          `products`.`name` AS `name`,
          `sales`.`code` AS `sale_code`,
          `sales`.`product_id` AS `product_id`,
          `sales`.`customer_id` AS `customer_id`,
          `sales`.`sale_price` AS `sale_price`,
          `sales`.`booked_price` AS `booked_price`,
          `sales`.`sale_discount` AS `sale_discount`,
          `sales`.`property_payment_mode_id` AS `property_payment_mode_id`,
          `property_payment_modes`.`name` AS `payment_mode_name`,
          `sales`.`file_status_id` AS `file_status_id`,
          `booking_file_status`.`name` AS `file_status_name`
        FROM
          (
            (
              (
                `products`
                LEFT JOIN `sales`
                  ON (
                    `products`.`id` = `sales`.`product_id`
                  )
              )
              LEFT JOIN `property_payment_modes`
                ON (
                  `sales`.`property_payment_mode_id` = `property_payment_modes`.`id`
                )
            )
            LEFT JOIN `booking_file_status`
              ON (
                `sales`.`file_status_id` = `booking_file_status`.`id`
              )
          )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //DB::statement('DROP VIEW IF EXISTS viewcustomerhistory');
    }
};
