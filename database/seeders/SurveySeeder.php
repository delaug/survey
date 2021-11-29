<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\Survey;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Survey::factory(25)->create()->each(
            fn($surveys) => Question::factory(5)->create([
                'survey_id' => $surveys->id,
                'type_id' => fn() => QuestionType::all()->random()->id
            ])->each(
                fn($question) => Field::factory(4)->create([
                    'question_id' => $question->id
                ])
            )
        );
    }
}
