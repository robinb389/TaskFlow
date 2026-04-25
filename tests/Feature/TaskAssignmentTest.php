<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_assign_a_new_task_to_another_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $assignee = User::factory()->create();
        $project = Project::create([
            'user_id' => $admin->id,
            'name' => 'Platform refresh',
            'description' => 'Internal migration work.',
        ]);

        $response = $this->actingAs($admin)->post(route('tasks.store'), [
            'project_id' => $project->id,
            'user_id' => $assignee->id,
            'title' => 'Prepare rollout plan',
            'description' => 'Coordinate the staged release.',
            'status' => 'pending',
            'due_date' => now()->addWeek()->toDateString(),
        ]);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'user_id' => $assignee->id,
            'title' => 'Prepare rollout plan',
        ]);
    }

    public function test_regular_user_cannot_assign_a_task_to_someone_else(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $project = Project::create([
            'user_id' => $user->id,
            'name' => 'Client portal',
            'description' => 'Customer-facing updates.',
        ]);

        $response = $this->from(route('tasks.create'))
            ->actingAs($user)
            ->post(route('tasks.store'), [
                'project_id' => $project->id,
                'user_id' => $otherUser->id,
                'title' => 'Review feedback',
                'description' => 'Look through the latest notes.',
                'status' => 'pending',
            ]);

        $response->assertRedirect(route('tasks.create'));
        $response->assertSessionHasErrors('user_id');

        $this->assertDatabaseMissing('tasks', [
            'project_id' => $project->id,
            'title' => 'Review feedback',
        ]);
    }

    public function test_admin_can_reassign_an_existing_task(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $originalAssignee = User::factory()->create();
        $newAssignee = User::factory()->create();
        $project = Project::create([
            'user_id' => $admin->id,
            'name' => 'Operations board',
            'description' => 'Weekly maintenance tasks.',
        ]);
        $task = Task::create([
            'project_id' => $project->id,
            'user_id' => $originalAssignee->id,
            'title' => 'Update runbook',
            'description' => 'Refresh the failover steps.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->put(route('tasks.update', $task), [
            'project_id' => $project->id,
            'user_id' => $newAssignee->id,
            'title' => 'Update runbook',
            'description' => 'Refresh the failover steps.',
            'status' => 'in_progress',
        ]);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'user_id' => $newAssignee->id,
            'status' => 'in_progress',
        ]);
    }
}
