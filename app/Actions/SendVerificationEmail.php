<?php

namespace App\Actions;

use App\Mail\MyTestEmail;
use App\Models\Verification;
use Carbon\Carbon;
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

            //check if user has an existing code that is not expired
            $hasExistingCode = Verification::where('session_id', '=', Session::getId())
                ->where('user_id', '=', Auth::id())
                ->where('expiration', '>', Carbon::now()->format('Y-m-d H:i'))
                ->first();

            if (isset($hasExistingCode)) {
                return;
            }

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
