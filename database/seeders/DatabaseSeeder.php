<?php

namespace Database\Seeders;

use App\Models\ApiService;
use App\Models\BankService;
use App\Models\LawService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);

        $apiService = ApiService::create([
            'name' => 'SalesForce',
            'slug' => 'sf',
        ]);

        BankService::create([
            'name' => 'SalesForce',
            'slug' => 'sf',
            'api_service_id' => $apiService->id,
        ]);

        LawService::create([
            'name' => 'SalesForce',
            'slug' => 'sf',
            'api_service_id' => $apiService->id,
        ]);
    }
}
