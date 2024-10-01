<?php

namespace App\Actions;

use App\Enums\UserRole;
use App\Mail\MyTestEmail;
use App\Mail\SendInquiryEmail;
use App\Models\Chat;
use App\Models\ServiceInquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class InquiryEmail
{
    use AsAction;

    public function handle(ServiceInquiry $serviceInquiry)
    {
        Mail::to($serviceInquiry->user->email)->send(new SendInquiryEmail($serviceInquiry));
    }
}
