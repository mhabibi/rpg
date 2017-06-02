<?php

namespace Tests\Unit\Interactive;

use App\Entities\CharacterInterface;
use App\Interactive\Character;
use App\Repositories\CharacterRepositoryInterface;
use Symfony\Component\Console\Style\StyleInterface;
use TestCase;

/**
 * @covers \App\Interactive\Character
 * @covers \App\Interactive\InteractiveAbstract
 */
class CharacterTest extends TestCase
{
    public function testCreateNewCharacter()
    {
        $outputMock = $this->createMock(StyleInterface::class);
        $outputMock->expects($this->once())->method('confirm')->willReturn(false);
        $outputMock->expects($this->once())->method('ask')->willReturn('a_name');
        $outputMock->expects($this->any())->method('text');

        $characterMock = $this->createMock(CharacterInterface::class);
        $characterMock->expects($this->any())->method('getName');

        $characterRepositoryMock = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepositoryMock->expects($this->once())->method('create')->with('a_name')->willReturn($characterMock);
        $characterRepositoryMock->expects($this->once())->method('getByName')->with('a_name')->willReturn(null);

        $characterInteractive = new Character($characterRepositoryMock);
        $characterInteractive->setOutput($outputMock);
        $this->assertEquals($characterMock, $characterInteractive->get());
    }

    public function testEnterNameThatAlreadyExist()
    {
	$characterMock = $this->createMock(CharacterInterface::class);	

        $outputMock = $this->createMock(StyleInterface::class);
        $outputMock->expects($this->once())->method('confirm')->willReturn(false);
        $outputMock->expects($this->once())->method('ask')->willReturn('a_name');
        $outputMock->expects($this->any())->method('text');

        $characterRepositoryMock = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepositoryMock->expects($this->once())->method('getByName')->with('a_name')->willReturn($characterMock);

        $characterInteractive = new Character($characterRepositoryMock);
        $characterInteractive->setOutput($outputMock);
        $this->assertNull($characterInteractive->get());
    }

    public function testGetCharacter()
    {
        $outputMock = $this->createMock(StyleInterface::class);
        $outputMock->expects($this->once())->method('confirm')->willReturn(true);
        $outputMock->expects($this->once())->method('ask')->willReturn('a_name');
        $outputMock->expects($this->any())->method('text');

        $characterMock = $this->createMock(CharacterInterface::class);
        $characterMock->expects($this->any())->method('getName');

        $characterRepositoryMock = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepositoryMock->expects($this->once())
                                ->method('getByName')
                                ->with('a_name')
                                ->willReturn($characterMock);

        $characterInteractive = new Character($characterRepositoryMock);
        $characterInteractive->setOutput($outputMock);
        $this->assertEquals($characterMock, $characterInteractive->get());
    }

    public function testEnterWrongName()
    {
        $outputMock = $this->createMock(StyleInterface::class);
        $outputMock->expects($this->once())->method('confirm')->willReturn(true);
        $outputMock->expects($this->once())->method('ask')->willReturn('a_name');
        $outputMock->expects($this->once())->method('note');

        $characterMock = $this->createMock(CharacterInterface::class);
        $characterMock->expects($this->any())->method('getName');

        $characterRepositoryMock = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepositoryMock->expects($this->once())
                                ->method('getByName')
                                ->with('a_name')
                                ->willReturn(null);

        $characterInteractive = new Character($characterRepositoryMock);
        $characterInteractive->setOutput($outputMock);
        $this->assertNull($characterInteractive->get());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Output dependency is not set
     */
    public function testOutputDependencyIsNotSet()
    {
        $characterRepositoryMock = $this->createMock(CharacterRepositoryInterface::class);

        $game = new Character($characterRepositoryMock);
        $game->get();
    }
}
