<?php

namespace App\Console;

use App\Console\Commands\EventRefreshCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        EventRefreshCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(EventRefreshCommand::class)->dailyAt('2:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
