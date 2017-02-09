<?php
namespace App\Providers;

use App\Repositories\CharacterRepositoryInterface;
use App\Repositories\DbCharacterRepository;
use App\Repositories\DbStateRepository;
use App\Repositories\StateRepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoriesServiceProvider
 *
 * @package App\Providers
 */
class RepositoriesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CharacterRepositoryInterface::class, DbCharacterRepository::class);
        $this->app->bind(StateRepositoryInterface::class, DbStateRepository::class);
    }
}
