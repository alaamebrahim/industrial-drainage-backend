<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'client_key' => $this->faker->numberBetween(100000000, 100099999),
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'letter_heading' => $this->faker->name,
            'consumption' => 100,
            'is_active' => true,
        ];
    }
}
