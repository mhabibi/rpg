<?php
namespace App\Interactive;

use App\Entities\CharacterInterface;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * Class InteractiveCharacterInterface
 *
 * @package App\Interactive
 */
interface InteractiveCharacterInterface
{
    /**
     * @return CharacterInterface|null
     * TODO refactor after php 7.1 tp get(): ?CharacterInterface
     */
    public function get();

    /**
     * @param StyleInterface $output
     *
     * @return InteractiveCharacterInterface
     */
    public function setOutput(StyleInterface $output);
}
