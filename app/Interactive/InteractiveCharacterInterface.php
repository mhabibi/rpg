<?php
namespace App\Interactive;

use App\Entities\CharacterInterface;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * Interface InteractiveCharacterInterface
 *
 * @package App\Interactive
 */
interface InteractiveCharacterInterface
{
    /**
     * @return CharacterInterface|null
     */
    public function get(): ?CharacterInterface;

    /**
     * @param StyleInterface $output
     *
     * @return InteractiveCharacterInterface
     */
    public function setOutput(StyleInterface $output);
}
