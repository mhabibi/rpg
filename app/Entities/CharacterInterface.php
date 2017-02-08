<?php
namespace App\Entities;

/**
 *
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
     * TODO refactor after php 7.1 to getState(): ?StateInterface;
     */
    public function getState();

    /**
     * @param StateInterface $state
     *
     * @return CharacterInterface
     */
    public function setState(StateInterface $state): CharacterInterface;

    public function setStock(int $stock): CharacterInterface;
}