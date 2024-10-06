<?php

namespace App\Listeners;

use App\Events\ForgotPassword;
use App\Mail\RecoveryEmail;
use App\Models\Verification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SendRecoveryCode implements ShouldQueue
{

    /**
     * Handle the event.
     */
    public function handle(ForgotPassword $forgotPassword): void
    {

        $verification  = $forgotPassword->getVerification();

        $user = $verification->user;
        $code = $verification->code;

        Mail::to($user->email)->send(new RecoveryEmail($code));

    }
}
