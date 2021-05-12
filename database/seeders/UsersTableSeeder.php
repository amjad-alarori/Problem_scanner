<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = config('roles.models.role')::where('name', '=', 'User')->first();
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $companyRole = config('roles.models.role')::where('name', '=', 'Company')->first();
        $employeeRole = config('roles.models.role')::where('name', '=', 'Employee')->first();
        $permissions = config('roles.models.permission')::all();
        $employeePermissions = config('roles.models.role')::where('slug', '=', 'view.users')->first();

        /*
         * Add Users
         *
         */
        if (config('roles.models.defaultUser')::where('email', '=', 'admin@admin.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'company@company.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name' => 'Company',
                'email' => 'company@company.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]);

            $newUser->attachRole($companyRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'employee@employee.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name' => 'Employee',
                'email' => 'employee@employee.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]);

            $newUser;
            $newUser->attachRole($employeeRole);
            $newUser->attachPermission($employeePermissions);
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'user@user.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name' => 'User',
                'email' => 'user@user.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]);

            $newUser;
            $newUser->attachRole($userRole);
        }

//        $faker = Factory::create();
//        $pass = bcrypt('password');
//
//        for ($int = 0; $int < 50_000; $int++) {
//            try {
//                $user = User::create([
//                    'name' => $faker->name,
//                    'email' => $faker->safeEmail,
//                    'password' => $pass,
//                ]);
//                $user->attachRole($userRole);
//            } catch (\Exception $e) {
//                // ignored
//            }
//        }
    }
}
