<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        'App\Console\Commands\Scraper',
        'App\Console\Commands\Snov',
        'App\Console\Commands\DomainSearch',
        'App\Console\Commands\ExecuteCampaign',
        'App\Console\Commands\ExecuteFollowup',
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('execute:campaign')->everyMinute();

        $schedule->command('execute:followup')->everyMinute();    
                
        //$schedule->command('scraper:run')
            //->everyMinute();
        //$schedule->command('snov:run')
            //->everyMinute()->runInBackground();
        //$schedule->command('DomainSearch:run')
            //->everyMinute()->runInBackground();
    }

}
