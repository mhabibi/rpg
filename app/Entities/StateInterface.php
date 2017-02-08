<?php
namespace App\Entities;

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
     * TODO refactor to : ?array after php 7.1
     */
    public function getOptions();
}
