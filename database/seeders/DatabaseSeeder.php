<?php

namespace Database\Seeders;

use App\Models\ExternalClient;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ExternalClient::factory()->create();
    }
}
