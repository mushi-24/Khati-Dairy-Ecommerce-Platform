<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Default seeder is empty (no users).
 * Optional demo catalog: php artisan db:seed --class=DemoCatalogSeeder
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Intentionally empty — create admin via: php artisan khati:create-admin
        // Optional: $this->call(DemoCatalogSeeder::class);
    }
}
