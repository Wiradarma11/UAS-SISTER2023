<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SistemInformasi>
 */
class SistemInformasiFactory extends Factory
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
            'nama' => 'Sistem Informasi ' . $this->faker->name,
            'slug' => $this->faker->slug,
            'jabatan' => $this->faker->jobTitle,
            'foto' => 'foto.jpg'
        ];
    }
}
