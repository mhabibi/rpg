<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Game\ControllerInterface;
use App\Repositories\CharacterRepositoryInterface;
use Illuminate\Http\Request;

/**
 * Class CharacterController
 *
 * @package App\Http\Controllers
 */
class CharacterController extends BaseController
{
    /**
     * @var ControllerInterface
     */
    protected $gameController;

    /**
     * @var CharacterRepositoryInterface
     */
    protected $characterRepository;

    /**
     * Controller constructor.
     *
     * @param ControllerInterface          $gameController
     * @param CharacterRepositoryInterface $characterRepository
     */
    public function __construct(
        ControllerInterface $gameController,
        CharacterRepositoryInterface $characterRepository
    ) {
        $this->gameController      = $gameController;
        $this->characterRepository = $characterRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        $this->validate($request, ['name' => ['required', 'string']]);
        $name = $request->get('name');
        if ($this->characterRepository->getByName($name)) {
            return $this->notAcceptable();
        }

        $this->characterRepository->create($name);

        return $this->created();
    }
}
