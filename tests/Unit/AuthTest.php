<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Populate the roles table
        Role::create(['id' => 1, 'role' => 'admin']);
        Role::create(['id' => 2, 'role' => 'user']);
    }

    public function testRegister()
    {
        $controller = new AuthController();

        $request = Request::create('/register', 'POST', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role_id' => 1,
        ]);

        $response = $controller->register($request);

        $responseContent = $response->getContent();
        $responseData = json_decode($responseContent, true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('user', $responseData);
        $this->assertArrayHasKey('role', $responseData);
        $this->assertArrayHasKey('access_token', $responseData);
        $this->assertEquals('admin', $responseData['role']['role']);
    }

    public function testLogin()
    {
        // Create a user first
        $role = Role::find(1);
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $role->id,
        ]);

        $controller = new AuthController();

        $request = Request::create('/login', 'POST', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response = $controller->login($request);

        $responseContent = $response->getContent();
        $responseData = json_decode($responseContent, true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('access_token', $responseData);
        $this->assertArrayHasKey('token_type', $responseData);
        $this->assertEquals('Bearer', $responseData['token_type']);
        $this->assertEquals('Login successful', $responseData['message']);
    }
}
