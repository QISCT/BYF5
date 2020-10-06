<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Page;
use Faker\Generator as Faker;

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

$pages = ['Welcome', 'About', 'Contact', 'Services', 'FAQ', 'Testimonials', 'Blog', 'News', 'Events', 'Careers', 'Our Team'];

$factory->define(Page::class, function (Faker $faker) use ($pages) {
    $name = collect($pages)->random(1)->first();
    $permutation = new Permutations(12);
    $permutation->sets = $permutation->sets->reject(function ($set) {
        return count($set) > 4 || in_array(1, $set);
    });

    $body = $permutation->random(3)->map(function ($permutation) use ($faker) {
        $row = new StdClass();
        $row->cols = $permutation->map(function ($num) use ($faker) {
            $col = new StdClass();
            $col->content = '<div>' . $faker->paragraph($num, false) . '</div>';
            $col->grow = $num;
            return $col;
        });
        return $row;
    });

    return [
        'name' => ucwords($name),
        'slug' => preg_replace('/[^a-z\-]/', '', str_replace(' ', '-', strtolower($name))),
        'body' => $body->toJson(),
    ];
});

class Permutations
{
    public $sets = null;

    function __construct($sum)
    {
        $this->sets = collect([]);
        $this->findCombinationsUtil([], 0, $sum, $sum);
    }

    function random($length = 1)
    {
        return $this->sets->random($length)->map(function ($set) {
            return collect($set)->shuffle();
        });
    }

    function findCombinationsUtil($arr, $index, $num, $reducedNum)
    {
        // Base condition
        if ($reducedNum < 0)
            return;

        // If combination is
        // found, push it
        if ($reducedNum == 0) {
            $this->sets->push($arr);
            return;
        }

        // Find the previous number
        // stored in arr[] It helps
        // in maintaining increasing order
        $prev = ($index == 0) ? 1 : $arr[$index - 1];

        // note loop starts from previous
        // number i.e. at array location
        // index - 1
        for ($k = $prev; $k <= $num; $k++) {
            // next element of array is k
            $arr[$index] = $k;

            // call recursively with
            // reduced number
            $this->findCombinationsUtil($arr, $index + 1,
                $num, $reducedNum - $k);
        }
    }
}
