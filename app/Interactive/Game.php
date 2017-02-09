<?php
declare(strict_types = 1);

namespace App\Interactive;

use App\Entities\CharacterInterface;
use App\Entities\StateInterface;
use App\Game\ControllerInterface;
use App\Repositories\StateRepositoryInterface;

/**
 * Class Game
 *
 * @package App\Interactive
 */
class Game extends InteractiveAbstract implements InteractiveGameInterface
{
    const STOCK_UNIT = 'GOLD';

    /**
     * @var ControllerInterface
     */
    protected $gameController;

    /**
     * @var StateRepositoryInterface
     */
    protected $stateRepository;

    /**
     * @param ControllerInterface      $gameController
     * @param StateRepositoryInterface $stateRepository
     */
    public function __construct(ControllerInterface $gameController, StateRepositoryInterface $stateRepository)
    {
        $this->gameController  = $gameController;
        $this->stateRepository = $stateRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function play(CharacterInterface $character)
    {
        if (!$this->output) {
            throw new \Exception('Output dependency is not set');
        }

        while (1) {
            #TODO add clear screen after refactoring the output
            $this->output->text($character->getName().'('.$character->getStock().' '.self::STOCK_UNIT.')');
            $state = $this->gameController->currentState($character);
            $this->showState($state);
            $nextState = $this->getNextState($state);
            if (!$nextState) {
                break;
            }
            $character = $this->gameController->move($character, $nextState);
        }
    }

    /**
     * @param StateInterface $state
     */
    protected function showState(StateInterface $state)
    {
        $this->output->title($state->getTitle());
        $this->output->text($state->getDescription());
    }

    /**
     * @param StateInterface $state
     *
     * @return StateInterface|null
     * TODO refactor after php 7.1 to getNextState(StateInterface $state): ?StateInterface
     */
    protected function getNextState(StateInterface $state)
    {
        if (!$state->getOptions()) {
            $this->output->success('You\'ve reached the end.');

            return null;
        }
        if (count($state->getOptions()) == 1) {
            $this->output->confirm('continue...');

            return $this->stateRepository->getById(key($state->getOptions()));
        }
        $choices = [];
        foreach ($state->getOptions() as $option) {
            $choices[] = $option;
        }

        #TODO refactor here to get the id of selected option
        $title = $this->output->choice('What are you going to do?', $choices);

        return $this->stateRepository->getByTitle($title);
    }
}
