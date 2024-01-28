<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->catchPhrase,
            'status' => fake()->boolean(40),
        ];
    }

    public function done(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 1,
            ];
        });
    }

    public function todo(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 0,
            ];
        });
    }

    public function name($input = ''): Factory
    {
        return $this->state(function (array $attributes) use ($input) {
            return [
                'name' => $input != '' ? $input : fake()->catchPhrase,
            ];
        });
    }
}
