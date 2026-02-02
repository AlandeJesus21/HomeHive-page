<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PropiedadFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->regexify('[A-Za-z0-9]{50}'),
            'tipo_prop' => fake()->regexify('[A-Za-z0-9]{50}'),
            'barrio' => fake()->regexify('[A-Za-z0-9]{50}'),
            'calle' => fake()->regexify('[A-Za-z0-9]{50}'),
            'numero_calle' => fake()->word(),
            'precio' => fake()->randomFloat(2, 0, 9999999.99),
            'forma_pago' => fake()->regexify('[A-Za-z0-9]{20}'),
            'servicio' => fake()->regexify('[A-Za-z0-9]{100}'),
            'reglas' => fake()->regexify('[A-Za-z0-9]{100}'),
            'cercanias' => fake()->regexify('[A-Za-z0-9]{100}'),
            'descripcion' => fake()->text(),
            'imagen' => fake()->regexify('[A-Za-z0-9]{250}'),
        ];
    }
}
