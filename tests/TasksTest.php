<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TasksTest extends TestCase
{

    use DatabaseMigrations, WithoutMiddleware;

    /**
     * @test
     *
     * Test GET /api/task
     * Gets the tasks for a user with token
     *
     * @return void
     */
    public function it_gets_all_tasks_for_authenticated_user()
    {
        $this->get('api/task', $this->setUpAuthenticatedUserHeader())
            ->seeJsonStructure([
                'tasks' => [
                    '*' => [
                        'id',
                        'name'
                    ]
                ]
            ]);
    }

    /**
     * @test
     *
     * Test GET /api/task
     * Gets no task(s) but error for a user without token
     *
     * @return void
     *
     */
    public function it_gets_no_tasks_for_non_authenticated_user()
    {
        $this->withoutMiddleware();

        $this->assertEquals(404, $this->get('api/task')->response->status());
    }


    /**
     * @test
     *
     * Test POST /api/task
     * Creates a task for a user with token
     *
     * @return void
     */
    public function it_creates_a_task_for_authenticated_user ()
    {
        $this->post(
            'api/task',
            [
                'name' => 'New Task'
            ],
            $this->setUpAuthenticatedUserHeader()
        )
            ->seeJsonContains(['name' => 'New Task'])
            ->seeInDatabase('tasks', ['name' => 'New Task']);
    }

    /**
     * @test
     *
     * Test POST /api/task
     * Creates a task for a user with token
     *
     * @return void
     */
    public function it_does_not_creates_a_task_for_unauthenticated_user ()
    {
        $this->withoutMiddleware();

        $this->assertEquals(404, $this->post('api/task')->response->status());
    }

    /**
     * @return array Header Array with JWT Token
     */
    private function setUpAuthenticatedUserHeader()
    {
        $this->withoutMiddleware();

        $token = $this->getToken();

        $this->refreshApp();

        $this->seed('TasksTableSeeder');

        factory(\App\User::class)->create();

        $server = [
            'HTTP_Authorization' => 'Bearer ' . $token
        ];

        return $server;
    }

}
