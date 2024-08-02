<?php

namespace Tests\Feature\app\Controllers\Api;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $userData = [
        'name' => "Murat",
        'email' => 'murat@mail.uz',
        'password' => 'murat123',
        'password_confirmation' => 'murat123'
    ];

    private array $headers = [
        'Accept' => "application/json"
    ];
    public function testRegister()
    {
        $response = $this->post('/api/register', $this->userData, $this->headers);

        $response->assertCreated();
        $response->assertJsonIsObject();
        $response->assertJsonPath('name', 'Murat');
        $response->assertJsonPath('email', 'murat@mail.uz');

        $this->assertDatabaseHas('users', ['name' => 'Murat', 'email' => 'murat@mail.uz']);
        $this->assertDatabaseCount('personal_access_tokens', 1);
    }

    public function testLogin()
    {
        $this->post('/api/register', $this->userData, $this->headers);
        $loginData = $this->userData;
        unset($loginData['name']);
        unset($loginData['password_confirmation']);

        $response = $this->post('/api/login', $loginData, $this->headers);

        $response->assertOk();
        $response->assertJsonIsObject();
        $response->assertJsonPath('name', 'Murat');
        $response->assertJsonPath('email', 'murat@mail.uz');

        $this->assertDatabaseCount('personal_access_tokens', 2);
    }

    public function testWrongLogin()
    {
        $this->post('/api/register', $this->userData, $this->headers);
        $this->assertDatabaseCount('personal_access_tokens', 1);
        $loginData = $this->userData;
        unset($loginData['name']);
        unset($loginData['password_confirmation']);

        $loginData['email'] = 'a@a.uz';

        $response = $this->post('/api/login', $loginData, $this->headers);

        $response->assertJsonPath('message', "You've given wrong credentials");

        $this->assertDatabaseCount('personal_access_tokens', 1);
    }


    public function testLogout()
    {
        $this->post('/api/register', $this->userData, $this->headers);
        $this->assertDatabaseCount('personal_access_tokens', 1);

        $response = $this->actingAs(User::first())
            ->post('/api/logout', $this->userData, $this->headers);

        $response->assertNoContent();
        $this->assertDatabaseCount('personal_access_tokens', 0);

    }

    public function testLogoutWithoutUser()
    {
        $response = $this->post('/api/logout', $this->userData, $this->headers);

        $response->assertUnauthorized();
    }
}
