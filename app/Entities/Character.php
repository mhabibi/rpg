<?php
declare(strict_types = 1);

namespace App\Entities;

/**
 * Class Character
 *
 * @package App\Entities
 */
class Character implements CharacterInterface
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $stock;

    /**
     * @var StateInterface
     */
    protected $state;

    /**
     * @param int    $id
     * @param string $name
     * @param int    $stock
     * @param        $state
     */
    public function __construct(int $id, string $name, int $stock, $state)
    {
        $this->id    = $id;
        $this->name  = $name;
        $this->stock = $stock;
        $this->state = $state;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function setState(StateInterface $state): CharacterInterface
    {
        $this->state = $state;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setStock(int $stock): CharacterInterface
    {
        $this->stock = $stock;

        return $this;
    }
}
