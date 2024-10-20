<?php

namespace App\Listeners;

use App\Actions\InquiryChat;
use App\Events\InquiryEvent;
use App\Models\Chat;
use App\Models\ServiceInquiry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SendInquiryNotification implements ShouldQueue
{

    protected InquiryChat $inquiryChat;

    /**
     * Create the event listener.
     */
    public function __construct(InquiryChat $inquiryChat)
    {
        $this->inquiryChat = $inquiryChat;
    }

    /**
     * Handle the event.
     */
    public function handle(InquiryEvent $inquiryEvent): void
    {
        $this->inquiryChat->handle($inquiryEvent->getInquiry());
    }
}
