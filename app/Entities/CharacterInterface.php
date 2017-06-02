<?php
namespace App\Entities;

/**
 * Interface CharacterInterface
 *
 * @package App\Entities
 */
interface CharacterInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getStock(): int;

    /**
     * @return StateInterface
     */
    public function getState(): ?StateInterface;

    /**
     * @param StateInterface $state
     *
     * @return CharacterInterface
     */
    public function setState(StateInterface $state): CharacterInterface;

    /**
     * @param int $stock
     *
     * @return CharacterInterface
     */
    public function setStock(int $stock): CharacterInterface;
}
