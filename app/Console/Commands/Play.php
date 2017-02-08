<?php
declare(strict_types = 1);

namespace App\Console\Commands;

use App\Interactive\InteractiveCharacterInterface;
use App\Interactive\InteractiveGameInterface;
use Illuminate\Console\Command;

/**
 * Class Play
 *
 * @package App\Console\Commands
 */
class Play extends Command
{
    protected $signature = 'play';

    protected $description = 'WARNING! Do not run this if you are not 100% ready, there is no way to come back...';

    protected $outputFormatter;

    /**
     * @param InteractiveCharacterInterface $interactiveCharacter
     * @param InteractiveGameInterface      $interactivePlay
     */
    public function handle(
        InteractiveCharacterInterface $interactiveCharacter,
        InteractiveGameInterface $interactivePlay
    ) {
        $this->getOutputFormatter()->note('Watch your steps! There is no way to come back.');
        $interactiveCharacter->setOutput($this->getOutputFormatter());
        $character = $interactiveCharacter->get();
        $interactivePlay->setOutput($this->getOutputFormatter());
        $interactivePlay->play($character);
    }

    /**
     * @return mixed
     */
    public function getOutputFormatter()
    {
        if (!$this->outputFormatter) {
            $this->outputFormatter = $this->output;
        }

        return $this->outputFormatter;
    }

    /**
     * @param mixed $outputFormatter
     *
     * @return self
     */
    public function setOutputFormatter($outputFormatter)
    {
        $this->outputFormatter = $outputFormatter;

        return $this;
    }
}
