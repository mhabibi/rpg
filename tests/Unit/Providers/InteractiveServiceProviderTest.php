<?php
namespace Tests\Unit\Providers;

use App\Interactive\InteractiveCharacterInterface;
use App\Interactive\InteractiveGameInterface;
use TestCase;

/**
 * @covers \App\Providers\InteractiveServiceProvider
 */
class InteractiveServiceProviderTest extends TestCase
{
    public function testIfItCanCreateMultipleInteractiveInstances()
    {
        $repo1 = $this->app->make(InteractiveGameInterface::class);
        $repo2 = $this->app->make(InteractiveGameInterface::class);

        $this->assertEquals($repo1, $repo2);
        $this->assertNotSame($repo1, $repo2);

        $repo1 = $this->app->make(InteractiveCharacterInterface::class);
        $repo2 = $this->app->make(InteractiveCharacterInterface::class);

        $this->assertEquals($repo1, $repo2);
        $this->assertNotSame($repo1, $repo2);
    }
}
