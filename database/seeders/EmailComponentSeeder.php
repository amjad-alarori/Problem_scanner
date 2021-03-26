<?php

namespace Database\Seeders;

use App\Helpers\LanguageHelper;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('email_component_translations')->get()->count() == 0) {

            DB::table('email_component_translations')->insert(

                [
                    'type' => 'Button',
                    'text' => 'klik hier',
                    'language' => LanguageHelper::$DEFAULT_LANGUAGE,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            );
        }
    }
}
