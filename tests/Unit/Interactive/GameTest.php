<?php

namespace Tests\Unit\Interactive;

use App\Entities\CharacterInterface;
use App\Entities\StateInterface;
use App\Game\ControllerInterface;
use App\Interactive\Game;
use App\Repositories\StateRepositoryInterface;
use Symfony\Component\Console\Style\StyleInterface;
use TestCase;

/**
 * @covers \App\Interactive\Game
 * @covers \App\Interactive\InteractiveAbstract
 */
class GameTest extends TestCase
{
    public function testPlay()
    {
        $characterMock = $this->createMock(CharacterInterface::class);
        $characterMock->expects($this->exactly(1))->method('getName')->willReturn('test_name');
        $characterMock->expects($this->exactly(1))->method('getStock')->willReturn(10);

        $stateMock1 = $this->createMock(StateInterface::class);
        $stateMock1->expects($this->once())->method('getTitle')->willReturn('title1');
        $stateMock1->expects($this->once())->method('getDescription')->willReturn('description1');
        $stateMock1->expects($this->exactly(3))->method('getOptions')->willReturn([1 => 'title2', 2 => 'another']);

        $stateMock2 = $this->createMock(StateInterface::class);
        $stateMock2->expects($this->once())->method('getTitle')->willReturn('title2');
        $stateMock2->expects($this->once())->method('getDescription')->willReturn('description2');
        $stateMock2->expects($this->exactly(3))->method('getOptions')->willReturn([1 => 'title3']);

        $stateMock3 = $this->createMock(StateInterface::class);
        $stateMock3->expects($this->once())->method('getTitle')->willReturn('title3');
        $stateMock3->expects($this->once())->method('getDescription')->willReturn('description3');
        $stateMock3->expects($this->exactly(1))->method('getOptions')->willReturn(null);

        $controllerMock = $this->createMock(ControllerInterface::class);
        $controllerMock->expects($this->exactly(3))->method('currentState')->willReturn(
            $stateMock1,
            $stateMock2,
            $stateMock3
        );

        $stateRepositoryMock = $this->createMock(StateRepositoryInterface::class);
        $stateRepositoryMock->expects($this->once())->method('getById')->with(1)->willReturn($stateMock3);
        $stateRepositoryMock->expects($this->once())->method('getByTitle')->with('title2')->willReturn($stateMock2);

        $outputMock = $this->createMock(StyleInterface::class);
        $outputMock->expects($this->exactly(3))->method('title')->withConsecutive(['title1'], ['title2'], ['title3']);
        $outputMock->expects($this->exactly(6))->method('text');
        $outputMock->expects($this->once())->method('success')->with('You\'ve reached the end.');
        $outputMock->expects($this->once())->method('confirm')->with('continue...');
        $outputMock->expects($this->once())
                   ->method('choice')
                   ->with('What are you going to do?', ['title2', 'another'])
                   ->willReturn('title2');

        $game = new Game($controllerMock, $stateRepositoryMock);
        $game->setOutput($outputMock);
        $game->play($characterMock);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Output dependency is not set
     */
    public function testOutputDependencyIsNotSet()
    {
        $controllerMock      = $this->createMock(ControllerInterface::class);
        $stateRepositoryMock = $this->createMock(StateRepositoryInterface::class);
        $characterMock       = $this->createMock(CharacterInterface::class);

        $game = new Game($controllerMock, $stateRepositoryMock);
        $game->play($characterMock);
    }
}
