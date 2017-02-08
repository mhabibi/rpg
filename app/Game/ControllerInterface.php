<?php
namespace App\Game;

use App\Entities\CharacterInterface;
use App\Entities\State;
use App\Entities\StateInterface;

/**
 * Interface ControllerInterface
 *
 * @package App\Game
 */
interface ControllerInterface
{
    /**
     * @param CharacterInterface $character
     *
     * @return StateInterface
     */
    public function currentState(CharacterInterface $character): StateInterface;

    /**
     * @param CharacterInterface $character
     * @param StateInterface     $state
     *
     * @return CharacterInterface
     */
    public function move(CharacterInterface $character, StateInterface $state): CharacterInterface;
}
