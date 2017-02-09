<?php
declare(strict_types = 1);

namespace App\Entities;

/**
 * Class State
 *
 * @package App\Entities
 */
class State implements StateInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $cost;

    /**
     * @var \ArrayObject
     */
    protected $options;

    /**
     * @param int        $id
     * @param string     $title
     * @param string     $description
     * @param int        $cost
     * @param array|null $options
     */
    public function __construct(int $id, string $title, string $description, int $cost, $options)
    {
        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
        $this->cost        = $cost;
        $this->options     = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getCost(): int
    {
        return $this->cost;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }
}
