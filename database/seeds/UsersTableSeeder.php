<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $affilliateRole = Role::where('name', 'Affiliate')->first();
        // $merchantRole = Role::where('name', 'Merchant')->first();
        $adminRole = Role::where('name', 'Admin')->first();


        $adminUser = factory(App\Models\User::class)->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@filly.test',
            'password' => bcrypt('password'),
        ]);

        $adminUser->assignRole('admin');

    }
}
