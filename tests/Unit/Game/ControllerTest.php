<?php
namespace Tests\Unit\Game;

use App\Entities\CharacterInterface;
use App\Entities\StateInterface;
use App\Game\Controller;
use App\Repositories\CharacterRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use TestCase;

/**
 * @covers \App\Game\Controller
 */
class ControllerTest extends TestCase
{
    public function testCurrentStateForNewCharacters()
    {
        $characterMock = $this->createMock(CharacterInterface::class);
        $characterMock->expects($this->once())->method('getState')->willReturn(null);

        $stateMock     = $this->createMock(StateInterface::class);
        $stateRepoMock = $this->createMock(StateRepositoryInterface::class);
        $stateRepoMock->expects($this->once())->method('getTheFirstState')->willReturn($stateMock);

        $characterRepoMock = $this->createMock(CharacterRepositoryInterface::class);

        $controller = new Controller($stateRepoMock, $characterRepoMock);

        $this->assertEquals($stateMock, $controller->currentState($characterMock));
    }

    public function testCurrentStateForPlayingCharacters()
    {
        $stateMock     = $this->createMock(StateInterface::class);
        $characterMock = $this->createMock(CharacterInterface::class);
        $characterMock->expects($this->once())->method('getState')->willReturn($stateMock);

        $stateRepoMock     = $this->createMock(StateRepositoryInterface::class);
        $characterRepoMock = $this->createMock(CharacterRepositoryInterface::class);

        $controller = new Controller($stateRepoMock, $characterRepoMock);

        $this->assertEquals($stateMock, $controller->currentState($characterMock));
    }

    public function testMove()
    {
        $characterMock = $this->createMock(CharacterInterface::class);
        $characterMock->expects($this->once())->method('getStock')->willReturn(1);

        $stateMock = $this->createMock(StateInterface::class);
        $stateMock->expects($this->once())->method('getCost')->willReturn(2);

        $characterRepoMock = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepoMock->expects($this->once())->method('updateStock')->with($characterMock, 3);
        $characterRepoMock->expects($this->once())->method('setState');

        $stateRepoMock = $this->createMock(StateRepositoryInterface::class);

        $controller = new Controller($stateRepoMock, $characterRepoMock);
        $this->assertInstanceOf(CharacterInterface::class, $controller->move($characterMock, $stateMock));
    }
}
