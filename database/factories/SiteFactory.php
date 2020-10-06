<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Site;
use Faker\Generator as Faker;
use Illuminate\Support\Collection;

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


$factory->define(Site::class, function (Faker $faker) {
    $name = $faker->company;
    while(strlen($name) > 24)
        $name = $faker->company;
    $account = preg_replace('/[^a-z]/', '', strtolower($name));
    return [
        'name' => $name,
        'domains' => [['name' => $account . '.' . $faker->tld, 'cat' => 'primary'], ['name' => $faker->domainName, 'cat' => 'redirect']],
        'account' => $account,
        'status' => $faker->randomElements([10, 20, 38, 50, 60, 70, 97], 1)[0],
        'contacts' => collect(array_fill(0, $faker->numberBetween(1, 3), 0))->map(function () use ($faker) {
            return ['name' => $faker->name, 'email' => $faker->email, 'phone' => $faker->e164PhoneNumber];
        }),
    ];
});
