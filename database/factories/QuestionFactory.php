<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionType;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text(128),
            'sort' => $this->faker->randomElement([10,20,30,40,50,60,70,80,90,100]),
            'type_id' => QuestionType::all()->random()->id,
            'survey_id' => Survey::all()->random()->id
        ];
    }
}
