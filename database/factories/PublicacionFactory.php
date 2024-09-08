<?php

namespace Database\Factories;
use App\Models\Publicacion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publicacion>
 */
class PublicacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * 
     * 
     */
    protected $model = Publicacion::class;
    public function definition(): array
    {

        
        return [
            'user_id' => \App\Models\User::factory(), // Esto creará un usuario asociado
            'descripcion_publicacion' => $this->faker->sentence(),
            'contenido_publicacion' => $this->faker->paragraph(),
            'num_reacciones' => $this->faker->numberBetween(0, 1000),
            'num_compartidos' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
