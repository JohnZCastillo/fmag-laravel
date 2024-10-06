<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new \App\Jobs\OrderComplete())->everyMinute()->withoutOverlapping();
