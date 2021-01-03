<?php

namespace Database\Factories;

use App\Models\{Task, User, TaskUser};
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaskUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'task_id' => Task::factory(), 
            //'assigned' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),

        ];
    }
}
