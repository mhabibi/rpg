<?php
namespace App\Interactive;

use App\Entities\CharacterInterface;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * Class InteractivePlayInterface
 *
 * @package App\Interactive
 */
interface InteractivePlayInterface
{
    /**
     * @param StyleInterface $output
     *
     * @return InteractivePlayInterface
     */
    public function setOutput(StyleInterface $output);

    /**
     * @param CharacterInterface $character
     *
     * @throws \Exception
     */
    public function play(CharacterInterface $character);
}