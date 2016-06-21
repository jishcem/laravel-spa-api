<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TasksTest extends TestCase
{

    use DatabaseMigrations, WithoutMiddleware;

    /**
     * Test to
     *
     * @return void
     */
    public function testExample()
    {

        $this->withoutMiddleware();

        $authUser = factory(\App\User::class, 'admin')->create();
        $authToken = \JWTAuth::fromUser($authUser);

        $this->refreshApplication();

        $this->artisan('migrate:refresh');
        $this->seed('TasksTableSeeder');

        factory(\App\User::class)->create();

        $server = [
            'HTTP_Authorization' => 'Bearer '.$authToken
        ];

        $this->get('api/task', $server)
            ->seeJsonStructure([
                'tasks' => [
                    '*' => [
                        'id', 'name'
                    ]
                ]
            ]);
    }
}
