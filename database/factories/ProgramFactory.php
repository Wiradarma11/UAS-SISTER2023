<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nama_program' => 'Program ' . $this->faker->name,
            'slug' => $this->faker->slug,
            'deskripsi' => $this->faker->text,
            'foto' => 'foto.jpg'
        ];
    }
}
