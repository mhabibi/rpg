<?php
namespace App\Repositories;

use App\Entities\CharacterInterface;
use App\Entities\StateInterface;

/**
 * Interface CharacterRepositoryInterface
 *
 * @package App\Repositories
 */
interface CharacterRepositoryInterface
{
    /**
     * @param string $name
     *
     * @return CharacterInterface|null
     */
    public function getByName(string $name): ?CharacterInterface;

    /**
     * @param string $name
     *
     * @return CharacterInterface
     */
    public function create(string $name): CharacterInterface;

    /**
     * @param CharacterInterface $character
     * @param StateInterface     $state
     *
     * @return CharacterInterface
     */
    public function setState(CharacterInterface $character, StateInterface $state): CharacterInterface;

    /**
     * @param CharacterInterface $character
     * @param int                $stock
     *
     * @return CharacterInterface
     */
    public function updateStock(CharacterInterface $character, int $stock): CharacterInterface;
}
