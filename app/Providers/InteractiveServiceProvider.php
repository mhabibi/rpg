<?php
namespace App\Providers;

use App\Interactive\Character;
use App\Interactive\InteractiveCharacterInterface;
use App\Interactive\InteractiveGameInterface;
use App\Interactive\Game;
use Illuminate\Support\ServiceProvider;

/**
 * Class InteractiveServiceProvider
 *
 * @package App\Providers
 */
class InteractiveServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(InteractiveCharacterInterface::class, Character::class);
        $this->app->bind(InteractiveGameInterface::class, Game::class);
    }
}
