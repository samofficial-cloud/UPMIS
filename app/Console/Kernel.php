<?php

namespace App\Console;

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
        //
       Commands\NotifyUsers::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('command:sendInvoices')
             ->dailyAt('03:40')->timezone('Africa/Dar_es_Salaam');

        $schedule->command('command:sendInsuranceInvoices')
            ->dailyAt('03:35')->timezone('Africa/Dar_es_Salaam');


        $schedule->command('command:sendParentClientsInvoices')
            ->dailyAt('03:30')->timezone('Africa/Dar_es_Salaam');


        $schedule->command('command:UpdateSpaceContractsAmount')
            ->dailyAt('03:00')->timezone('Africa/Dar_es_Salaam');





//        $schedule->command('command:sendEmailsSpace')
//            ->everyMinute();

            //$schedule->command('command:ContractEnd')->everyFiveMinutes();

      $schedule->command('command:ContractEnd')->dailyAt('19:00')->timezone('Africa/Dar_es_Salaam');


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
