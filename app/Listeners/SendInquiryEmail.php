<?php

namespace App\Listeners;

use App\Actions\InquiryChat;
use App\Actions\InquiryEmail;
use App\Events\InquiryEvent;
use App\Models\Chat;
use App\Models\ServiceInquiry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SendInquiryEmail implements ShouldQueue
{

    protected InquiryEmail $inquiryEmail;

    /**
     * Create the event listener.
     */
    public function __construct(InquiryEmail $inquiryEmail)
    {
        $this->inquiryEmail = $inquiryEmail;
    }

    /**
     * Handle the event.
     */
    public function handle(InquiryEvent $inquiryEvent): void
    {
        $this->inquiryEmail->handle($inquiryEvent->getInquiry());
    }
}
