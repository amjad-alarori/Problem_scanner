<?php

namespace Database\Seeders;

use App\Helpers\AppConfigHelper;
use App\Models\AppConfig;
use Illuminate\Database\Seeder;
use App\Models\EmailTranslation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use function React\Promise\all;


class AppConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (AppConfig::$DEFAULT_CONFIGS as $key => $value) {
            if (!AppConfig::where('key', $key)->first()) {
                AppConfig::create([
                    'key' => $key,
                    'value' => $value['Value']
                ]);
            }
        }
    }
}
