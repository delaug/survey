<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Survey;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Survey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(32),
            'description' => $this->faker->text(),
            'media_id' => Media::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'publish_at' => Carbon::createFromTimestamp($this->faker->dateTimeBetween($startDate = '+2 days', $endDate = '+1 week')->getTimeStamp())
        ];
    }
}
