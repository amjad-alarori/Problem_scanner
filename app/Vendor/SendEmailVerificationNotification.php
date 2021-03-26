<?php

namespace App\Vendor;

use App\Mail\Mails\VerifyEmail as CustomVerifyEmail;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $event->user->getKey(),
                    'hash' => sha1($event->user->getEmailForVerification()),
                ]
            );
            Mail::to($event->user->email)->send(new CustomVerifyEmail($event->user, $verifyUrl));
        }
    }
}
