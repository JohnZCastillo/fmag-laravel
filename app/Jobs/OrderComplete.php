<?php

namespace App\Jobs;

use App\Enums\OrderStatus;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OrderComplete implements ShouldQueue
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


//        $now = Carbon::now()->subDays(7);

        Order::where('status',OrderStatus::DELIVERY->value)
//            ->where('updated_at','>=', $now->format('Y-m-d H:i'))
            ->update([
                'status' => OrderStatus::COMPLETED->value
            ]);

    }
}
