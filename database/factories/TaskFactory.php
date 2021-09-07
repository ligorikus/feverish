<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        return [
            'category_id' => $this->faker->randomElement(Category::all()),
            'title' => $this->faker->company,
            'description' => $this->faker->text,
        ];
    }
}
