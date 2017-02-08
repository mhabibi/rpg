<?php
namespace App\Repositories;

use App\Entities\CharacterInterface;
use App\Entities\StateInterface;

interface CharacterRepositoryInterface
{
    public function getByName(string $name);

    public function create(string $name): CharacterInterface;

    public function setState(CharacterInterface $character, StateInterface $state): CharacterInterface;

    public function updateStock(CharacterInterface $character, int $stock): CharacterInterface;
}