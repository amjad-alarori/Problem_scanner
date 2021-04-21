<?php

namespace App\Mail\Mails;

use App\Helpers\EmailComponentHelper;

class NewClient extends Mailable
{

    public static string $description = 'Email send when new client gets created. %PASSWORD% is required';

    public static array $variableDocumentation = [
        'USER_NAME' => "The name of the user",
        'USER_EMAIL' => "The email of the user",
        'PASSWORD' => "Generated password for the new client"
    ];

    public function __construct($user, $randomPassword)
    {
        $this->setVariables([
            'USER_NAME' => $user->name,
            'USER_EMAIL' => $user->email,
            'PASSWORD' => $randomPassword,
        ]);
        parent::__construct($user->language);
    }

}
