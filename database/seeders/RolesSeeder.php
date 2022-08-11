<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Roles List
         *
         * @array
         */
        $roles = [
            'admin',
            'financial',
            'artist',
            'artist-sponsor',
            'store',
            //'partner',
        ];

        /**
         * Store Roles on Database
         */
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
