<?php
namespace Tests\Unit\Providers;

use App\Game\ControllerInterface;
use TestCase;

/**
 * @covers \App\Providers\GameServiceProvider
 */
class GameServiceProviderTest extends TestCase
{
    public function testIfItCanCreateMultipleGameController()
    {
        $controller1 = $this->app->make(ControllerInterface::class);
        $controller2 = $this->app->make(ControllerInterface::class);

        $this->assertEquals($controller1, $controller2);
        $this->assertNotSame($controller1, $controller2);
    }
}
