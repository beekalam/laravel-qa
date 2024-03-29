<?php

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->delete();
        DB::table('users')->delete();
        DB::table('questions')->delete();
        DB::table('favorites')->delete();
        DB::table('votables')->delete();

        factory('App\User')->create([
            'email'    => 'beekalam@gmail.com',
            'password' => bcrypt('secret')
        ]);

        factory('App\User', 3)->create()->each(function ($user) {
            $user->questions()
                 ->saveMany(factory('App\Question', rand(1, 5))->make())
                 ->each(function ($q) {
                     $q->answers()->saveMany(factory(Answer::class, rand(1, 5))->make());
                 });
        });

        $users = User::pluck('id')->all();
        $numberOfUsers = count($users);
        foreach (Question::all() as $question) {
            for ($i = 0; $i < rand(0, $numberOfUsers); $i++) {
                $user = $users[$i];
                $question->favorites()->attach($user);
            }
        }


        $users = User::all();
        $numberOfUsers = $users->count();
        $votes = [-1, 1];
        foreach (Question::all() as $question) {
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                $user = $users[$i];
                $user->voteQuestion($question, $votes[rand(0, 1)]);
            }
        }
        foreach (Answer::all() as $answer) {
            for ($i = 0; $i < rand(1, $numberOfUsers); $i++) {
                $user = $users[$i];
                $user->voteAnswer($answer, $votes[rand(0, 1)]);
            }
        }

    }
}
