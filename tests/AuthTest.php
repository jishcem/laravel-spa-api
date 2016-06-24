<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     * tries to login and make sure token is returned
     *
     * @return void
     */
    public function it_tries_to_login_and_get_token()
    {
        factory(App\User::class, 'admin')->create();

        $this->assertEquals(200, $this->post(
            'api/login',
            [
                'email' => 'admin@admin.com',
                'password' => 'password'
            ]
        )->response->status());

        $this->post(
            'api/login',
            [
                'email' => 'admin@admin.com',
                'password' => 'password'
            ]
        )->seeJsonStructure([
            'token' => [],
            'user' => []
        ]);

    }
}
