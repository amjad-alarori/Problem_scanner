<?php

namespace Database\Seeders;

use App\Helpers\LanguageHelper;
use App\Models\EmailTranslation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTranslationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if table users is empty
        if(DB::table('email_translations')->get()->count() == 0){

            DB::table('email_translations')->insert([

                [
                    'type' => 'VerifyEmail',
                    'subject' => 'Hoi %USER_NAME% hier is jou verificatie email',
                    'body' => '<p style="text-align: center; ">Hoi&nbsp;<span style="font-size: 14.4px; font-family: Nunito, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;">%USER_NAME%,</span></p><p style="text-align: center; ">Met één druk op de knop verifieer je jouw email adres.</p><div style="text-align: center;"><span style="font-size: 14.4px; font-family: Nunito, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;">%VERIFY_BUTTON%</span></div><div style="text-align: center;"><br></div><div style="text-align: center;">Geen account aangemaakt?</div><div style="text-align: center;">Dan kun je deze email negeren.</div>',
                    'language' => LanguageHelper::$DEFAULT_LANGUAGE,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'type' => 'ResetPassword',
                    'subject' => 'Hoi %USER_NAME% met deze email kun je jou wachtwoord wijzigen',
                    'body' => '<p style="text-align: center; ">Hoi&nbsp;<span style="font-size: 14.4px; font-family: Nunito, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;">%USER_NAME%,</span></p><p style="text-align: center; ">Met één druk op de knop maak je een nieuw orange-eyes wachtwoord aan.</p><div style="text-align: center;"><span style="font-size: 14.4px; font-family: Nunito, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;;">%RESET_BUTTON%</span></div><div style="text-align: center;"><br></div><div style="text-align: center;">Geen aanvraag gedaan?</div><div style="text-align: center;">Dan kun je deze email negeren.</div>',
                    'language' => LanguageHelper::$DEFAULT_LANGUAGE,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'type' => 'NewClient',
                    'subject' => 'Orange Eyes account gemaakt',
                    'body' => '<div style="text-align: left;">Beste %USER_NAME%,</div><div style="text-align: left;"><br></div><div style="text-align: left;">Er is een account voor u aangemaakt bij Orange Eyes. Uw wachtwoord is:</div><div style="text-align: left;">%PASSWORD%</div><div style="text-align: left;"><br></div><div style="text-align: left;">U kunt inloggen op https://www.orangeeyes.nl om uw wachtwoord te wijzigen.</div><div style="text-align: left;"><br></div><div style="text-align: left;"><div>Met vriendelijke groet,</div><div>Orange Eyes</div></div>',
                    'language' => LanguageHelper::$DEFAULT_LANGUAGE,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ]);

        }

    }

}
