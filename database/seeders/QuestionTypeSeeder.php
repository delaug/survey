<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionType::create(['name' => 'checkbox']);
        QuestionType::create(['name' => 'radio']);
        QuestionType::create(['name' => 'text']);
        QuestionType::create(['name' => 'textarea']);
    }
}
