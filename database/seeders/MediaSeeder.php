<?php

namespace Database\Seeders;

use App\Facades\Admin\MediaFacade;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MediaFacade::deleteMediaFiles();
        MediaFacade::import();
    }
}
