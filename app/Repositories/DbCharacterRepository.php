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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function create(string $name): CharacterInterface
    {
        $character       = new CharacterModel();
        $character->name = $name;
        $character->save();

        return $character->toEntity();
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
