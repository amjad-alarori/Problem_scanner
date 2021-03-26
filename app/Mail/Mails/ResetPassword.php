<?php

namespace App\Mail\Mails;

use App\Helpers\EmailComponentHelper;

class ResetPassword extends Mailable
{

    public static string $description = 'This email is send when a user requests a new password. This email requires a %RESET_URL% or a %RESET_BUTTON%, with those tools the user can change his password when he receives the email.';

    public static array $variableDocumentation = [
        'USER_NAME' => "The name of the user",
        'USER_EMAIL' => "The email of the user",
        'RESET_URL' => "Reset url as text",
        'RESET_BUTTON' => "Reset url as styled button"
    ];

    public function __construct($user, $resetUrl)
    {
        $this->setVariables([
            'USER_NAME' => $user->name,
            'USER_EMAIL' => $user->email,
            'RESET_URL' => $resetUrl,
            'RESET_BUTTON' => EmailComponentHelper::Button($resetUrl, $user->language),
        ]);
        parent::__construct($user->language);
    }

}
