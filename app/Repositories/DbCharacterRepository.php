<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Entities\CharacterInterface;
use App\Entities\StateInterface;
use App\Models\CharacterModel;

/**
 * Class DbCharacterRepository
 *
 * @package App\Repositories
 */
class DbCharacterRepository implements CharacterRepositoryInterface
{
    /**
     * @param string $name
     *
     * @return CharacterInterface|null
     * TODO refactor after php 7.1 to getByName(string $name): ?CharacterInterface
     */
    public function getByName(string $name)
    {
        $character = CharacterModel::query()->where('name', $name)->first();
        if ($character) {
            return $character->toEntity();
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return CharacterInterface
     */
    public function create(string $name): CharacterInterface
    {
        $character       = new CharacterModel();
        $character->name = $name;
        $character->save();

        return $character->toEntity();
    }

    /**
     * @param CharacterInterface $character
     * @param StateInterface     $state
     *
     * @return CharacterInterface
     */
    public function setState(CharacterInterface $character, StateInterface $state): CharacterInterface
    {
        /** @var CharacterModel $character */
        $character           = CharacterModel::find($character->getId());
        $character->state_id = $state->getId();
        $character->save();

        return $character->toEntity();
    }

    /**
     * @param CharacterInterface $character
     * @param int                $stock
     *
     * @return CharacterInterface
     */
    public function updateStock(CharacterInterface $character, int $stock): CharacterInterface
    {
        /** @var CharacterModel $character */
        $character        = CharacterModel::find($character->getId());
        $character->stock = $stock;
        $character->save();

        return $character->toEntity();
    }
}
