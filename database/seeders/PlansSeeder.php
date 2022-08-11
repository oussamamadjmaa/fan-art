<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            'free_trial' => [
                'key' => 'free_trial',
                'name' => 'الباقة التجريبية',
                'short_description' => 'الباقة التجريبية',
                'description' => 'الباقة التجريبية',
                'features' => [],
                'price' => 0,
            ],
            'paid' => [
                'key' => 'paid',
                'name' => 'الباقة الأساسية',
                'short_description' => 'الباقة الأساسية',
                'description' => 'الباقة الأساسية',
                'features' => [],
                'price' => 2300*100,
            ],
        ];

        foreach ($plans as $key => $plan) {
            Plan::firstOrCreate(['key' => $plan['key']], $plan);
        }
    }
}
