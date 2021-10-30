<?php

namespace Database\Seeders;

use App\Models\FieldType;
use Illuminate\Database\Seeder;

class FieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FieldType::create(['name' => 'checkbox', 'description' => 'Checkbox field']);
        FieldType::create(['name' => 'radio', 'description' => 'Radio field']);
        FieldType::create(['name' => 'text', 'description' => 'Text field']);
        FieldType::create(['name' => 'textarea', 'description' => 'Textarea field']);
    }
}
