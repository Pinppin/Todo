<?php

namespace Database\Factories;

use App\Models\{Task, User, Category, Board};
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $dt = $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+3 months');
        $date = $dt->format("Y-m-d"); // 1994-09-24
        return [
            //'user_id' => User::factory(),
            'board_id' => Board::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => $date,
            'state' => $this->faker->randomElement(['todo' ,'ongoing', 'done']),
            'category_id' => Category::factory(), 
            'created_at' => now(),
            'updated_at' => now(),

        ];
    }
}
