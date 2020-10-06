<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Firm;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Firm::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'type' => $faker->randomElements(['Professional', 'Platinum', 'Email', 'File Sharing', 'BizPayO', 'Test'], 1)[0],
    ];
});
