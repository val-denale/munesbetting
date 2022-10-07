<?php

namespace Database\Seeders;

use App\Models\Sport;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'admin' => true
        ]);

        \App\Models\Sport::create([
            'name' => 'Tennis',
        ]);

        \App\Models\Sport::create([
            'name' => 'Esport',
        ]);


        \App\Models\Plan::create([
            'name' => 'Free',
            'slug' => 'free',
            'description' => 'Free',
            'price' => 0,
            'buyable' => 0,
            'display_cycle' => 'Gratuit',
            'stripe_id' => null,
        ]);

        \App\Models\Plan::create([
            'name' => '1 mois',
            'slug' => '1-mois',
            'description' => 'Pack Sonego',
            'price' => 999,
            'buyable' => 1,
            'display_cycle' => 'Mensuel',
            'stripe_id' => 'price_1L03OcJ7yLDEwD6vnactIlQb',
        ]);

        \App\Models\Plan::create([
            'name' => '3 mois',
            'description' => 'Pack Kyrgios',
            'slug' => '3-mois',
            'price' => 1999,
            'buyable' => 1,
            'display_cycle' => 'Trimestriel',

            'stripe_id' => 'price_1L03OcJ7yLDEwD6vEYYXlMUU',
        ]);

        \App\Models\Plan::create([
            'name' => '6 mois',
            'description' => 'Pack Nadal',
            'slug' => '6-mois',
            'price' => 3499,
            'buyable' => 1,
            'display_cycle' => 'Semestre',
            'stripe_id' => 'price_1L03OcJ7yLDEwD6vNcHOvjgd',
        ]);

        \App\Models\Plan::create([
            'name' => '1 an',
            'description' => 'Pack Djokovic',
            'slug' => '1-an',
            'price' => 5999,
            'buyable' => 1,
            'display_cycle' => 'Annuel',
            'stripe_id' => 'price_1L03OcJ7yLDEwD6vnYvhk950',
        ]);
    }
}
