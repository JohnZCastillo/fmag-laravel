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

    /**
     * Create a new event instance.
     */
    public function __construct(Verification $verification)
    {
        $this->verification = $verification;
    }

    public function getVerification(): Verification
    {
        return  $this->verification;
    }
}
