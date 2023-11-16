<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegisterSuccess(): void
    {
        $this->post('/api/users', [
            'username' => 'deni',
            'password' => 'password',
            'name' => 'Deni Sugiarto'
        ])->assertStatus(201)
            ->assertJSON([
                "data" => [
                    'username' => 'deni',
                    'name' => 'Deni Sugiarto'
                ]
            ]);
    }
    public function testRegisterFailed(): void
    {
        $this->post('/api/users', [
            'username' => '',
            'password' => '',
            'name' => ''
        ])->assertStatus(400)
            ->assertJSON([
                "errors" => [
                    'username' => ["The username field is required."],
                    'password' => ["The password field is required."],
                    'name' => ["The name field is required."]
                ]
            ]);
    }
    public function testRegisterUsernameAlreadyExist(): void
    {
        $this->testRegisterSuccess();
        $this->post('/api/users', [
            'username' => 'deni',
            'password' => 'password',
            'name' => 'Deni Sugiarto'
        ])->assertStatus(400)
            ->assertJSON([
                "errors" => [
                    'username' => ['username already registered'],
                ]
            ]);
    }
}
