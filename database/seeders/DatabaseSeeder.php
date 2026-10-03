<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ProfileSeeder::class,
            BanomSeeder::class,
            OrganizationStructureSeeder::class,
            MemberSeeder::class,
            KtaSeeder::class,
            PostSeeder::class,
            EventSeeder::class,
            AspirationSeeder::class,
        ]);
    }
}
