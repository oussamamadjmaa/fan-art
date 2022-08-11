<?php

namespace Database\Seeders;

use Database\Seeders\Fake\PagesSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PagesSeeder::class,
        ]);
    }
}
