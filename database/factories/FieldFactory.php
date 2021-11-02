<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\QuestionType;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Field::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text(),
            'sort' => $this->faker->randomElement([10,20,30,40,50,60,70,80,90,100]),
            'question_id' => Question::all()->random()->id,
        ];
    }
}
