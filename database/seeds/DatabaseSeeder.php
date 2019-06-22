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

        factory('App\User')->create([
            'email' => 'beekalam@gmail.com',
            'password' => bcrypt('secret')
        ]);

        factory('App\User', 3)->create()->each(function ($user) {
            $user->questions()
                 ->saveMany(factory('App\Question', rand(1, 5))->make());
        });


        // factory('App\User',3)->create();
        // factory('App\Question',10)->create();
    }
}
