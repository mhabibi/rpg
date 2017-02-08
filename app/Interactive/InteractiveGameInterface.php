<?php
namespace App\Interactive;

use App\Entities\CharacterInterface;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * Class InteractiveGameInterface
 *
 * @package App\Interactive
 */
interface InteractiveGameInterface
{
    /**
     * @param StyleInterface $output
     *
     * @return InteractiveGameInterface
     */
    public function setOutput(StyleInterface $output);

    /**
     * @param CharacterInterface $character
     *
     * @throws \Exception
     */
    public function play(CharacterInterface $character);
}
