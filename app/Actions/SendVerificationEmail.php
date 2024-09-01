<?php

namespace App\Actions;

use App\Mail\MyTestEmail;
use App\Models\Verification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Lorisleiva\Actions\Concerns\AsAction;

class SendVerificationEmail
{
    use AsAction;

    /**
     * @throws \Exception
     */
    public function handle()
    {

        try {
            DB::beginTransaction();

            $code = fake()->numberBetween(111111, 999999);

            Verification::create([
                'user_id' => Auth::id(),
                'session_id' => Session::getId(),
                'code' => $code
            ]);

            DB::commit();
            Mail::to(Auth::user()->email)->send(new MyTestEmail($code));
        } catch (\Exception $e) {
            DB::rollBack();
            throw  $e;
        }

    }
}
