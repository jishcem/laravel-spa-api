<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        \DB::table('tasks')->delete();

        $tasks = [
            [ 'name' => 'one' ]
        ];

        foreach ($tasks as $task) {
            \App\Task::create($task);
        }

        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
