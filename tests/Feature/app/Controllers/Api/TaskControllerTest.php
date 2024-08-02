<?php

namespace Tests\Feature\app\Controllers\Api;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = User::factory()->create();

        $tasks = Task::factory(10)->for($user)->create();

        $response = $this->actingAs($user)->get('api/tasks');

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonIsArray('data');
    }

    public function testShow()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        $response = $this->actingAs($user)->get('api/tasks/' . $task->slug);
        $response->assertOk();
        $response->assertJsonIsObject('data');
        $response->assertJsonPath('data.slug', $task->slug);
    }

    public function testShowAnotherUser()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        $user2 = User::factory()->create();

        $response = $this->actingAs($user2)->get('api/tasks/' . $task->slug);
        $response->assertForbidden();
    }

    public function testStore()
    {
        $user = User::factory()->create();

        $task = Task::factory()->make();

        $response = $this->actingAs($user)->post('api/tasks', [
            'title' => $task->title,
            'description' => $task->description,
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('tasks', ['id' => 1]);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        $updateData = [
            'title' => 'title',
            'description' => 'description',
        ];

        $response = $this->actingAs($user)->put('api/tasks/' . $task->slug, $updateData);

        $response->assertOk();
        $this->assertDatabaseHas('tasks', ['title' => 'title', 'description' => 'description']);
    }

    public function testUpdateAnotherUser()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        $user2 = User::factory()->create();

        $updateData = [
            'title' => 'title',
            'description' => 'description',
        ];

        $response = $this->actingAs($user2)->put('api/tasks/' . $task->slug, $updateData);

        $response->assertForbidden();
    }

    public function testDelete()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete('api/tasks/' . $task->slug);

        $response->assertNoContent();
        $this->assertSoftDeleted('tasks', ['slug' => $task->slug]);
    }


    public function testDeleteAnotherUser()
    {
        $user = User::factory()->create();

        $task = Task::factory()->for($user)->create();

        $user2 = User::factory()->create();

        $response = $this->actingAs($user2)->delete('api/tasks/' . $task->slug);

        $response->assertForbidden();
        $this->assertNotSoftDeleted('tasks', ['slug' => $task->slug]);
    }
}
