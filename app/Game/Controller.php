<?php
declare(strict_types = 1);

namespace App\Game;

use App\Entities\CharacterInterface;
use App\Entities\StateInterface;
use App\Repositories\CharacterRepositoryInterface;
use App\Repositories\StateRepositoryInterface;

/**
 * Class Controller
 *
 * @package App\Game
 */
class Controller implements ControllerInterface
{
    /**
     * @var StateRepositoryInterface
     */
    protected $stateRepository;

    /**
     * @var CharacterRepositoryInterface
     */
    protected $characterRepository;

    /**
     * @param StateRepositoryInterface     $stateRepository
     * @param CharacterRepositoryInterface $characterRepository
     */
    public function __construct(
        StateRepositoryInterface $stateRepository,
        CharacterRepositoryInterface $characterRepository
    ) {
        $this->stateRepository     = $stateRepository;
        $this->characterRepository = $characterRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function currentState(CharacterInterface $character): StateInterface
    {
        $state = $character->getState();
        if ($state) {
            return $state;
        }

        return $this->stateRepository->getTheFirstState();
    }

    /**
     * {@inheritdoc}
     */
    public function move(CharacterInterface $character, StateInterface $state): CharacterInterface
    {
        $character = $this->characterRepository->updateStock($character, $character->getStock() + $state->getCost());
        $character = $this->characterRepository->setState($character, $state);

        return $character;
    }
}
