<?php

namespace App\Mail\Mails;

use App\Helpers\EmailComponentHelper;

class VerifyEmail extends Mailable
{

    public static string $description = 'This email is send when a new user creates an account. This email requires a %VERIFY_URL% or a %VERIFY_BUTTON%, with those tools the user can validate his email when he receives the email.';

    public static array $variableDocumentation = [
        'USER_NAME' => "The name of the user",
        'USER_EMAIL' => "The email of the user",
        'VERIFY_LINK' => "Verify url as text",
        'VERIFY_BUTTON' => "Verify url as styled button"
    ];

    public function __construct($user, $verifyUrl)
    {
        $this->setVariables([
            'USER_NAME' => $user->name,
            'USER_EMAIL' => $user->email,
            'VERIFY_LINK' => $verifyUrl,
            'VERIFY_BUTTON' => EmailComponentHelper::Button($verifyUrl, $user->language),
        ]);
        parent::__construct($user->language);
    }

}
