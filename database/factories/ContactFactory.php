<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'first_name' => fake()->lastName(),
            'last_name' => fake()->firstName(),
            'gender' => fake()->numberBetween(1, 3),
            'email' => fake()->email(),
            'tel' => str_replace('-', '', fake()->phoneNumber()),
            'address' => fake()->address(),
            'building' => fake()->company(),
            'detail' => fake()->text(120),
        ];
    }
}
