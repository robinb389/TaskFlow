<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tags = collect([
            ['name' => 'Todo', 'color' => '#3B82F6'],
            ['name' => 'In Progress', 'color' => '#F59E0B'],
            ['name' => 'Done', 'color' => '#10B981'],
            ['name' => 'Bug', 'color' => '#EF4444'],
            ['name' => 'Feature', 'color' => '#8B5CF6'],
        ])->map(fn (array $tag) => Tag::updateOrCreate(['name' => $tag['name']], $tag));

        $admin = User::updateOrCreate(
            ['email' => 'admin@taskflow.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        $admin->forceFill(['is_admin' => true])->save();

        User::factory(2)->create()->each(function (User $user) use ($tags) {
            foreach (range(1, 2) as $projectIndex) {
                $project = Project::create([
                    'user_id' => $user->id,
                    'name' => fake()->sentence(3),
                    'description' => fake()->optional()->paragraph(),
                ]);

                foreach (range(1, 3) as $taskIndex) {
                    $task = Task::create([
                        'project_id' => $project->id,
                        'user_id' => $user->id,
                        'title' => fake()->sentence(4),
                        'description' => fake()->optional()->paragraph(),
                        'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
                        'due_date' => fake()->optional()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
                    ]);

                    $task->tags()->sync($tags->shuffle()->take(rand(1, 2))->pluck('id')->all());
                }
            }
        });
    }
}
