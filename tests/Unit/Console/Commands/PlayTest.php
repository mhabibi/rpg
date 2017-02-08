<?php
namespace Tests\Unit\Console\Commands;

use App\Entities\CharacterInterface;
use App\Interactive\InteractiveCharacterInterface;
use App\Interactive\InteractiveGameInterface;
use Symfony\Component\Console\Style\StyleInterface;
use TestCase;
use App\Console\Commands\Play;

class PlayTest extends TestCase
{
    public function testHandle()
    {
        $characterMock            = $this->createMock(CharacterInterface::class);
        $interactiveCharacterMock = $this->createMock(InteractiveCharacterInterface::class);
        $interactiveCharacterMock->expects($this->once())->method('get')->willReturn($characterMock);
        $interactiveGameMock = $this->createMock(InteractiveGameInterface::class);
        $interactiveGameMock->expects($this->once())->method('play')->with($characterMock);
        $outputMock = $this->createMock(StyleInterface::class);
        $outputMock->method('note');

        $playCommand = new Play();
        $playCommand->setOutputFormatter($outputMock);
        $playCommand->handle($interactiveCharacterMock, $interactiveGameMock);
    }
}
