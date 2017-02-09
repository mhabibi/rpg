<?php

namespace App\Http\Controllers;

use App\Game\Controller as GameController;
use App\Game\ControllerInterface;
use App\Repositories\CharacterRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class Controller
 *
 * @package App\Http\Controllers
 */
class PlayController extends BaseController
{
    /**
     * @var ControllerInterface
     */
    protected $gameController;

    /**
     * @var StateRepositoryInterface
     */
    protected $stateRepository;

    /**
     * @var CharacterRepositoryInterface
     */
    protected $characterRepository;

    /**
     * @param ControllerInterface          $gameController
     * @param StateRepositoryInterface     $stateRepository
     * @param CharacterRepositoryInterface $characterRepository
     */
    public function __construct(
        ControllerInterface $gameController,
        StateRepositoryInterface $stateRepository,
        CharacterRepositoryInterface $characterRepository
    ) {
        $this->gameController      = $gameController;
        $this->stateRepository     = $stateRepository;
        $this->characterRepository = $characterRepository;
    }

    /**
     * @param string $name
     *
     * @return \Illuminate\Http\Response
     */
    public function get(string $name)
    {
        $character = $this->characterRepository->getByName($name);
        if (!$character) {
            return $this->notFound();
        }

        $state = $this->gameController->currentState($character);

        $options = null;
        foreach ($state->getOptions() as $id => $title) {
            $options[$id] = $title;
        }

        return $this->response(
            [
                'character'   => $character->getName(),
                'stock'       => $character->getStock(),
                'title'       => $state->getTitle(),
                'description' => $state->getDescription(),
                'options'     => $options,
            ]
        );
    }

    /**
     * @param Request $request
     * @param string  $name
     *
     * @return \Illuminate\Http\Response
     */
    public function put(Request $request, string $name)
    {
        $this->validate($request, ['id' => ['required', 'integer']]);

        $character = $this->characterRepository->getByName($name);
        if (!$character) {
            return $this->notFound();
        }

        $nextState = $this->stateRepository->getById($request->get('id'));
        if (!$nextState) {
            return $this->badRequest();
        }

        $currentState = $this->gameController->currentState($character);
        if (!array_key_exists($nextState->getId(), $currentState->getOptions())) {
            return $this->badRequest();
        }

        $this->gameController->move($character, $nextState);

        return $this->get($character->getName());
    }
}
