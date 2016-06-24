<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class TasksTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     *
     * Test GET /api/task
     * Gets the tasks for a user with token
     *
     * @return void
     */
    public function it_gets_all_tasks()
    {
        $user = factory(App\User::class)->create();

        $this->seed('TasksTableSeeder');

        $this->get('api/task', $this->headers($user))->seeJsonStructure([
            'tasks' => [
                '*' => [
                    'id',
                    'name'
                ]
            ]
        ]);

        $this->assertEquals(200, $this->get('api/task', $this->headers($user))->response->status());

        \JWTAuth::invalidate();

        $this->assertEquals(401, $this->get('api/task')->response->status());
    }


    /**
     * @test
     *
     * Test POST /api/task
     * Creates a task
     *
     * @return void
     */
    public function it_creates_a_task()
    {
        $user = factory(App\User::class)->create();

        $this->post(
            'api/task',
            [
                'name' => 'New Task'
            ],
            $this->headers($user)
        )
            ->seeJsonContains(['name' => 'New Task'])
            ->seeInDatabase('tasks', ['name' => 'New Task']);

        \JWTAuth::invalidate();

        $this->assertEquals(401, $this->post('api/task')->response->status());
    }

    /**
     * @test
     *
     * Test GET /api/task/edit/{id}
     * Gets a task details
     *
     * @return void
     */
    public function it_shows_a_task()
    {
        $user = factory(App\User::class)->create();

        $this->seed('TasksTableSeeder');

        $this->post('api/task/edit/1', [], $this->headers($user))
            ->seeJsonContains(['name' => 'one'])
            ->seeInDatabase('tasks', ['name' => 'one']);

        \JWTAuth::invalidate();

        $this->assertEquals(401, $this->post('api/task/edit/1')->response->status());
    }


    /**
     * Test GET /api/task/update/{id}
     * It updates a task
     */
    public function it_updates_a_task()
    {
        $user = factory(App\User::class)->create();

        $this->post(
            'api/task/update/1',
            ['name' => 'two'],
            $this->headers($user)
        )
            ->seeJsonContains(['name' => 'two'])
            ->seeInDatabase('tasks', ['name' => 'two']);

        \JWTAuth::invalidate();

        $this->assertEquals(401, $this->post(
            'api/task/update/1',
            ['name' => 'two'],
            $this->headers($user)
        )->response->status());
    }

    /**
     * Test POST /api/task/delete/{id}
     * It delete a task for authenticated user and makes sure the deleted entry is not in the database
     *
     * @return void
     */
    public function it_deletes_a_task()
    {
        $user = factory(App\User::class)->create();

        $this->post('api/task/delete/1', [], $this->headers($user))
            ->seeJsonContains(['status' => 1])
            ->missingFromDatabase('tasks', ['name' => 'one']);

        \JWTAuth::invalidate();

        $this->assertEquals(401, $this->post('api/task/delete/1', [], $this->headers($user))->response->status());
    }

}
