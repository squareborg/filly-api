<?php

use App\Models\ProgramCategory;
use Illuminate\Database\Seeder;
use App\Models\Merchant;

class MerchantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Models\Merchant::class, 30)->create(
        //     [
        //         'user_id' => function () {
        //             return factory(App\Models\User::class)->create()->id;
        //         },
        //     ]
        // );

        $fashionId = ProgramCategory::where('name', 'Fashion')->first()->id;

        $merchants = [
            [
                'name' => 'asos',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/a1/Asos-logo.jpg',
                'category_id' => $fashionId,
            ],
            [
                'name' => 'boohoo',
                'logo' => 'https://res-1.cloudinary.com/crunchbase-production/image/upload/c_lpad,h_256,w_256,f_auto,q_auto:eco/v1483985202/elsnc8kcyigmskyx0wzm.png',
                'category_id' => $fashionId,
            ]
            ];

        foreach($merchants as $merchant) {
            Merchant::create([
                'name' => $merchant['name'],
                'logo' => $merchant['logo'],
                'user_id' => factory(App\Models\User::class)->create()->id,
                'category_id' => $merchant['category_id'],
            ]);
        }
    }

}
