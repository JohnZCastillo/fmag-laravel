<?php

namespace App\Events;

use App\Models\User;
use App\Models\Verification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected Verification $verification;
    protected User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Verification $verification, User $user)
    {
        $this->verification = $verification;
        $this->user = $user;
    }

    public function getVerification(): Verification
    {
        return  $this->verification;
    }

    public function getUser()
    {
        return $this->user;
    }
}
