<?php

namespace Database\Seeders;

use App\Models\FieldOption;
use App\Models\FieldType;
use Illuminate\Database\Seeder;

class FieldOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FieldOption::create(['name' => 'position', 'description' => 'Vertical', 'field_type_id' => FieldType::CHECKBOX]);
        FieldOption::create(['name' => 'position', 'description' => 'Horizontal', 'field_type_id' => FieldType::CHECKBOX]);
        FieldOption::create(['name' => 'position', 'description' => 'Vertical', 'field_type_id' => FieldType::RADIO]);
        FieldOption::create(['name' => 'position', 'description' => 'Horizontal', 'field_type_id' => FieldType::RADIO]);
    }
}
