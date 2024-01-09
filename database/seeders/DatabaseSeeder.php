<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(LocationSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PaymentModeSeeder::class);
        $this->call(UserPermissionSeeder::class);
        $this->call(ChartOfAccountSeeder::class);
        $this->call(BookingFileStatusSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
