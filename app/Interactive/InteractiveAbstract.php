<?php
declare(strict_types = 1);

namespace App\Interactive;

use Symfony\Component\Console\Style\StyleInterface;

/**
 * Class InteractiveAbstract
 *
 * @package App\Interactive
 */
class InteractiveAbstract
{
    /**
     * @var StyleInterface
     */
    protected $output;

    /**
     * {@inheritdoc}
     */
    public function setOutput(StyleInterface $output)
    {
        $this->output = $output;

        return $this;
    }
}
