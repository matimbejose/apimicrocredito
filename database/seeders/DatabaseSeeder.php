<?php

namespace Database\Seeders;

use AccountTableSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Multitenancy\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Tenant::checkCurrent()
            ? $this->runTenantSpecificSeeders()
            : $this->runLandlordSpecificSeeders();
    }

    public function runTenantSpecificSeeders()
    {
        Artisan::call('db:seed', ['--class' => AccountTableSeeder::class]);
        Artisan::call('db:seed', ['--class' => RolePermissionsTableSeeder::class]);
    }

    public function runLandlordSpecificSeeders()
    {
        // run landlord specific seeders
    }
}