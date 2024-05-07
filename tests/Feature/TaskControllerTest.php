<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_a_logged_user_create_a_task()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $this->post(route('tasks.store'), [
            "title" => "Interview for AI/ML",
            "description" => "Interview for AI/ML position",
            "due_date" => "2024-05-08",
            "category" => "AI/ML"
        ]);
        $this->assertEquals(1, Task::count());
        $task = Task::first();
        $this->assertEquals($task->created_by, $user->id);
    }

    public function test_a_logged_user_view_task()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $this->post(route('tasks.store'), [
            "title" => "Interview for AI/ML",
            "description" => "Interview for AI/ML position",
            "due_date" => "2024-05-08",
            "category" => "AI/ML"
        ]);
        $this->assertEquals(1, Task::count());
    }

    public function test_a_logged_user_update_task()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $data = $this->post(route('tasks.store'), [
            "title" => "Interview for AI/ML",
            "description" => "Interview for AI/ML position",
            "due_date" => "2024-05-08",
            "category" => "AI/ML"
        ]);

        $task = Task::first();
        $data = $this->put(route('tasks.update', $task->id), [
            "title" => "Learn AI/ML",
            "due_date" => "2024-05-10",
        ]);
        $update_task = Task::first();

        $this->assertEquals('Learn AI/ML', $update_task->title);
        $this->assertEquals('2024-05-10', $update_task->due_date->toDateString());
    }

    public function test_a_logged_user_delete_task()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $data = $this->post(route('tasks.store'), [
            "title" => "Interview for AI/ML",
            "description" => "Interview for AI/ML position",
            "due_date" => "2024-05-08",
            "category" => "AI/ML"
        ]);

        $task = Task::first();

        $data = $this->delete(route('tasks.destroy', $task->id));
        $update_task = Task::first();

        $this->assertEquals(0, Task::count());
    }
}
