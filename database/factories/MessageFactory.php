<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Message;
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Message::class;
    public function definition()
    {
        return [
            //
            'content' => $this->faker->paragraph,
        ];
    }
}
