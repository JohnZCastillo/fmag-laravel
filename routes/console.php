<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new \App\Jobs\OrderComplete())->daily()->withoutOverlapping();
Schedule::job(new \App\Jobs\PasswordReminder())->everyMinute()->withoutOverlapping();
