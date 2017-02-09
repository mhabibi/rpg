<?php
namespace Tests\Unit\Providers;

use App\Repositories\CharacterRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use TestCase;

/**
 * @covers \App\Providers\RepositoriesServiceProvider
 */
class RepositoriesServiceProviderTest extends TestCase
{
    public function testIfItCanCreateMultipleRepositories()
    {
        $repo1 = $this->app->make(StateRepositoryInterface::class);
        $repo2 = $this->app->make(StateRepositoryInterface::class);

        $this->assertEquals($repo1, $repo2);
        $this->assertNotSame($repo1, $repo2);

        $repo1 = $this->app->make(CharacterRepositoryInterface::class);
        $repo2 = $this->app->make(CharacterRepositoryInterface::class);

        $this->assertEquals($repo1, $repo2);
        $this->assertNotSame($repo1, $repo2);
    }
}
