<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    protected $user;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }
    public function test_user_login_sucess()
    {
        $response = $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => $this->user->password
        ]);
        $response->assertOk();
    }
}
