<?php

namespace App\Events;

use App\Models\Inquiry;
use App\Models\ServiceInquiry;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InquiryEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected ServiceInquiry $serviceInquiry;

    /**
     * Create a new event instance.
     */
    public function __construct(ServiceInquiry $serviceInquiry)
    {
        $this->serviceInquiry = $serviceInquiry;
    }

    public function getInquiry()
    {
        return $this->serviceInquiry;
    }
}
