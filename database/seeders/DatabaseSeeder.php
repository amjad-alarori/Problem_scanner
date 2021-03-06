<?php

namespace Database\Seeders;

use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\ConnectRelationshipsSeeder;
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
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(EmailTranslationsSeeder::class);
        $this->call(ConnectRelationshipsSeeder::class);
        $this->call(AppConfigSeeder::class);
        $this->call(EmailComponentSeeder::class);
        $this->call(UsersTableSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
