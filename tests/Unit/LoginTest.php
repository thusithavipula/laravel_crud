<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase {
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function testLoginTrue() { //Test correct login with default admin user
        $credential = [
            'email' => 'admin@email.com',
            'password' => '123456'
        ];
        $response = $this->post('login', $credential)->assertRedirect('/admin');
        $response->assertSessionMissing('errors');
    }

    /** @test */
    public function testLoginFalse() {
        $credential = [
            'email' => 'user@ad.com',
            'password' => ''
        ];

        $response = $this->post('login', $credential);
        $response->assertSessionHasErrors();
    }
    
    public function newUserLogin() { //test only once
//        $credential = [
//            'email' => 'johndoe@example.com',
//            'password' => 'testpass123'
//        ];
//        $user = factory(User::class)->create([
//            'email' => $credential['email'],
//            'password' => bcrypt($credential['password']),
//            'role' => 'admin'
//        ]);
//        $response = $this->post('login', $credential)->assertRedirect('/admin');
//        $response->assertSessionMissing('errors');
    }

}
