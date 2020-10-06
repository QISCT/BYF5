<?php

namespace Database\Seeders;

use App\Models\Firm;
use App\Models\Page;
use App\Models\Site;
use App\Models\User;
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
        factory(User::class, 10)->create();
        factory(Firm::class, 8)->create()
            ->each(function ($firm) {
                $firm->sites()->createMany(factory(Site::class, mt_rand(1, 2))->make()->toArray())
                    ->each(function ($site) {
                        $site->pages()->createMany(factory(Page::class, mt_rand(4, 8))->make()->toArray());
                    });
            });
        User::create(['name' => 'Andrew', 'email' => 'andrew@quasars.com', 'password' => \Illuminate\Support\Facades\Hash::make('password'), 'email_verified_at' => now()]);
    }
}
