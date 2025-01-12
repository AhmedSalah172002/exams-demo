<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserEnrollToExamTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_user_remove_from_exam(): void
    {
        $loginData = [
            'email'=> 'ahmed12@gmail.com',
            'password'=> '123456789'
        ];
        $response = $this->post(route('login'),$loginData);
        $response->assertStatus(200);

        $data = [
            'exam_id'=>6
        ];
        $response = $this->post(route('withdraw'),$data);

        $response->assertStatus(200);
    }

    public function test_user_can_enroll_to_new_exam(): void
    {
        $loginData = [
            'email'=> 'ahmed12@gmail.com',
            'password'=> '123456789'
        ];
        $response = $this->post(route('login'),$loginData);
        $response->assertStatus(200);

        $data = [
          'exam_id'=>6
        ];
        $response = $this->post(route('enroll'),$data);

        $response->assertStatus(201);
    }

    public function test_user_can_not_enroll_to_same_exam(): void
    {
        $loginData = [
            'email'=> 'ahmed12@gmail.com',
            'password'=> '123456789'
        ];
        $response = $this->post(route('login'),$loginData);
        $response->assertStatus(200);

        $data = [
            'exam_id'=>6
        ];
        $response = $this->post(route('enroll'),$data);

        $response->assertStatus(400);
    }
}
