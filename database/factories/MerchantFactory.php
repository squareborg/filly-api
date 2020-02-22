<?php

use Faker\Generator as Faker;
use Webpatser\Uuid\Uuid;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Merchant::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
    ];
});
