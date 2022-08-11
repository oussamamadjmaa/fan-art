<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Admin Information
         */
        $adminData = [
            'username'  => 'administrator',
            'name' => 'Administrator',
            'email'     => 'admin@arabrcrc.org',
            'password'  => bcrypt('fanart2022'),
            'status'    => true,
        ];

        /**
         * Store and verify admin's account
         */
        $admin = User::firstOrCreate([
            'username' => 'administrator'
        ], $adminData);

        $admin->assignRole('admin');
        $admin->markEmailAsVerified();
    }
}
