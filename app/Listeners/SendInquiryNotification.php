<?php

namespace App\Listeners;

use App\Events\InquiryEvent;
use App\Models\Chat;
use App\Models\ServiceInquiry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SendInquiryNotification
{

    protected ServiceInquiry $serviceInquiry;

    /**
     * Create the event listener.
     */
    public function __construct(ServiceInquiry $serviceInquiry)
    {
        $this->serviceInquiry = $serviceInquiry;
    }

    /**
     * Handle the event.
     */
    public function handle(InquiryEvent $event): void
    {

        $html = 'test';


    }
}
