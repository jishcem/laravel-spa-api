<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        \DB::table('users')->delete();

        factory(\App\User::class, 1)->create();

        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
