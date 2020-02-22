<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call('RolesTableSeeder');
        $this->call('UsersTableSeeder');
        //$this->call('AdvertsTableSeeder');
        $this->call('OAuthClientSeeder');
        $this->call('SettingsTableSeeder');
        $this->call('ProgramCategoriesTableSeeder');
        $this->call('ProgramsTableSeeder');
        $this->call('MerchantsTableSeeder');
    }
}
