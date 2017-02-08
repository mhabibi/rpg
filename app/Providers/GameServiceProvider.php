<?php
namespace App\Providers;

use App\Game\Controller;
use App\Game\ControllerInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class GameServiceProvider
 *
 * @package App\Providers
 */
class GameServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ControllerInterface::class, Controller::class);
    }
}
