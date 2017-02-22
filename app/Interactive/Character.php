<?php
declare(strict_types = 1);

namespace App\Interactive;

use App\Entities\CharacterInterface;
use App\Repositories\CharacterRepositoryInterface;

/**
 * Class Character
 *
 * @package App\Interactive
 */
class Character extends InteractiveAbstract implements InteractiveCharacterInterface
{
    /**
     * @var CharacterRepositoryInterface
     */
    protected $characterRepository;

    /**
     * @param CharacterRepositoryInterface $characterRepository
     */
    public function __construct(CharacterRepositoryInterface $characterRepository)
    {
        $this->characterRepository = $characterRepository;
    }

    /**
     * @return CharacterInterface|null
     * @throws \Exception
     */
    public function get()
    {
        if (!$this->output) {
            throw new \Exception('Output dependency is not set');
        }

        $character = null;
        if ($this->output->confirm('You continue your journey?')) {
            $name      = $this->output->ask('What is you name?');
            $character = $this->characterRepository->getByName($name);
            if ($character) {
                return $character;
            }
            $this->output->note('Wrong name! You\'re not allowed to come in!');

            return null;
        }

        $this->output->text('Hmm, OK then, you\'ll create a new character.');
        $name = $this->output->ask('What would you like to be called? :');

        if ($this->characterRepository->getByName($name)) {
            $this->output->note('This name already exist, please choose another one');

            return null;
        }

        $character = $this->characterRepository->create($name);
        $this->output->text('Welcome '.$character->getName().'. Enjoy your journey!');

        return $character;
    }
}
