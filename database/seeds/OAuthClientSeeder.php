<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'name' => 'xfil Personal Access Client',
            'secret' => env('PASSPORT_PGC_SECRET'),
            'redirect' => env('APP_URL'),
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => 1,
        ]);

        DB::table('oauth_clients')->insert([
            'name' => 'xfil Password Grant Client',
            'secret' => env('PASSPORT_PGC_SECRET'),
            'redirect' => env('APP_URL'),
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}