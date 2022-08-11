<?php

namespace Database\Seeders\Fake;

use App\Models\Page;
use Database\Factories\PageFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::factory(25)->create();
    }
}
