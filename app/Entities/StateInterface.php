<?php
namespace App\Entities;

/**
 * Interface StateInterface
 *
 * @package App\Entities
 */
interface StateInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return int
     */
    public function getCost(): int;

    /**
     * @return array|null
     */
    public function getOptions(): ?array;
}
