<?php

namespace App\Console;

use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Console\Commands\Play;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Play::class,
    ];
}
