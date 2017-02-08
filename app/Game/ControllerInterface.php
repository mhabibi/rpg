<?php
namespace App\Game;

use App\Entities\CharacterInterface;
use App\Entities\State;
use App\Entities\StateInterface;

interface ControllerInterface
{
    public function currentState(CharacterInterface $character): StateInterface;

    public function move(CharacterInterface $character, StateInterface $state): CharacterInterface;
}