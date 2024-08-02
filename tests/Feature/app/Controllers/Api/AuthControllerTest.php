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
        'password' => 'murat123'
    ];

    private array $headers = [
        'Accept' => "application/json"
    ];
    public function testRegister()
    {
        $this->userData = array_merge($this->userData, ['password_confirmation' => $this->userData['password']]);
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
        User::factory()->create($this->userData);

        $loginData = $this->userData;
        unset($loginData['name']);
        unset($loginData['password_confirmation']);

        $response = $this->post('/api/login', $loginData, $this->headers);

        $response->assertOk();
        $response->assertJsonIsObject();
        $response->assertJsonPath('name', 'Murat');
        $response->assertJsonPath('email', 'murat@mail.uz');

        $this->assertDatabaseCount('personal_access_tokens', 1);
    }

    public function testWrongLogin()
    {
        User::factory()->create($this->userData);

        $loginData['email'] = 'a@a.uz';
        $loginData['password'] = 'qwerty1234';

        $response = $this->post('/api/login', $loginData, $this->headers);

        $response->assertJsonPath('message', "You've given wrong credentials");

        $this->assertDatabaseCount('personal_access_tokens',0);
    }


    public function testLogout()
    {
        $user = User::factory()->create($this->userData);

        $response = $this->actingAs($user)
            ->post('/api/logout');

        $response->assertNoContent();
        $this->assertDatabaseCount('personal_access_tokens', 0);

    }

    public function testLogoutWithoutUser()
    {
        $response = $this->post('/api/logout', headers: $this->headers);

        $response->assertUnauthorized();
    }
}
