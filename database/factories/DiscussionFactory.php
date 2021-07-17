<?php

namespace Database\Factories;

use App\Models\Discussion;
use App\Models\User;
use App\Models\Channel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscussionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discussion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        $slug = Str::slug($title,'-');
        return [
            'user_id' => User::factory()->create(),
            'channel_id' => Channel::factory()->create(),
            'title' => $title,
            'content' => $this->faker->paragraph,
            'slug' => $slug,
        ];
    }
}
