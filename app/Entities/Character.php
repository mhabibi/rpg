<?php
declare(strict_types = 1);

namespace App\Entities;

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

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @return StateInterface
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param StateInterface $state
     *
     * @return CharacterInterface
     */
    public function setState(StateInterface $state): CharacterInterface
    {
        $this->state = $state;

        return $this;
    }

    public function setStock(int $stock): CharacterInterface
    {
        $this->stock = $stock;

        return $this;
    }
}
