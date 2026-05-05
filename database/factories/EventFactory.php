<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        return [
            'category_id' => Category::factory(),
            'organization_id' => Organization::factory(),
            'uuid' => (string) Str::uuid(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'price_cents' => $this->faker->numberBetween(1000, 5000), // €10 - €50
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(7)->addHours(4),
            'max_capacity' => $this->faker->numberBetween(50, 200),
        ];
    }
}
