<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\TrishulPlant1\MakeCSVs::class,
        Commands\TrishulPlant1\Copy::class,
        Commands\SBMS1\Copy::class,
        Commands\TRUEMIX1\Copy::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('bb:trishul_plant_1_copy')
                 ->everyFiveMinutes();

        $schedule->command('bb:sbms1_copy')
             ->everyFiveMinutes();

        $schedule->command('bb:truemix1_copy')
             ->everyFiveMinutes();
    }
}
