<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     * tries to login and make sure token is returned and also tries to login without fields
     *
     * @return void
     */
    public function it_tries_to_login_and_get_token()
    {
        factory(App\User::class, 'admin')->create();

        $api = $this->post(
            'api/login',
            [
                'email' => 'admin@admin.com',
                'password' => 'password'
            ]
        );

        $this->assertEquals(200, $api->response->status());

        $api->seeJsonStructure([
            'token' => [],
            'user' => []
        ]);

        $this->assertEquals(400, $api = $this->post(
            'api/login',
            []
        )->response->status());

    }

    /**
     * @test
     *
     * It tries to register and get the token back in the response and also tries to register without fields
     *
     * @return null
     */
    public function it_tries_to_register_and_get_token()
    {
        $api = $this->post(
            'api/register',
            [
                'name' => 'test name',
                'email' => 'test@test.com',
                'password' => bcrypt('password')
            ]
        );

        $this->assertEquals(200, $api->response->status());
        $api->seeJsonStructure([
            'token' => [],
            'user' => []
        ]);

        $this->assertEquals(422, $api = $this->post(
            'api/register',
            []
        )->response->status());
    }


    /**
     * @test
     *
     * It requests to reset the password
     */
    public function it_requests_to_reset_password(){

        factory(App\User::class, 'admin')->create();

        \Mail::shouldReceive('send')
            ->andReturn(true);

        $api = $this->post(
            'api/password',
            [
                'email' => 'admin@admin.com'
            ]
        );

        $this->assertEquals(200, $api->response->status());

        $api->seeJsonStructure([
            'status' => []
        ]);

    }

    /**
     * @test
     *
     * It resets the password
     */
    public function it_resets_the_password(){

        factory(App\User::class, 'admin')->create();

        \Mail::shouldReceive('send')
            ->andReturn(true);

        $this->post(
            'api/password',
            [
                'email' => 'admin@admin.com'
            ]
        );

        $token = \DB::table('password_resets')
            ->where('email', 'admin@admin.com')
            ->value('token');

        $api = $this->post(
            'api/password/reset',
            [
                'token'                     => $token,
                'email'                     => 'admin@admin.com',
                'password'                  => 'asdasd',
                'password_confirmation'     => 'asdasd'
            ]
        );

        $this->assertEquals(200, $api->response->status());

    }
}
