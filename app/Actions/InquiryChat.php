<?php

namespace App\Actions;

use App\Enums\UserRole;
use App\Models\Chat;
use App\Models\ServiceInquiry;
use Lorisleiva\Actions\Concerns\AsAction;

class InquiryChat
{
    use AsAction;

    public function handle(ServiceInquiry $serviceInquiry)
    {

        $content = view('mail.inquiry-email',['serviceInquiry' => $serviceInquiry])->render();

        Chat::create([
            'content' => $content ,
            'sender_id' => UserRole::ADMIN_ID,
            'receiver_id' => $serviceInquiry->user_id,
        ]);

    }
}
