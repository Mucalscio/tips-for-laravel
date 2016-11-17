<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testLoginTest()
    {
        $this->post('/auth/login', ['email' => 'mucalscio@163.com','password' => '123456'])
            ->seeJson([
                'status' => 1,
            ]);
    }
}
