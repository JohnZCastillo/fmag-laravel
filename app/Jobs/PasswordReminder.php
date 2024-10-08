<?php

namespace App\Jobs;

use App\Enums\UserRole;
use App\Models\Chat;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class PasswordReminder implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {

            DB::beginTransaction();

            $users = User::select(['id','name'])
                ->get();

            foreach ($users as $user){

                $message = 'Hello ' .  $user->name . ', Dont forget to change your password!';

                Chat::create([
                    'title' => 'Password Reminder',
                    'content' => $message,
                    'sender_id' => UserRole::ADMIN_ID,
                    'receiver_id' => $user->id,
                ]);

            }

            DB::commit();

        }catch (\Exception $exception){
            report($exception);
            DB::rollBack();
        }
    }
}
