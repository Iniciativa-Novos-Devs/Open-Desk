<?php

namespace App\Console;

use App\Console\Commands\RequestHomologationForAllCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RequestHomologationForAllCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Para colocar no crontab
        //https://laravel.com/docs/8.x/scheduling#running-the-scheduler
        // https://laravel.com/docs/8.x/scheduling#schedule-frequency-options

        $schedule->command('chamados:homologation-request-all')->twiceDaily(8, 18);//Envia e-nmails às 8h e 18h
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
