<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Entities\StateInterface;
use App\Models\StateModel;
use Illuminate\Support\Facades\DB;

/**
 * Class DbStateRepository
 *
 * @package App\Repositories
 */
class DbStateRepository implements StateRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getByTitle(string $title): ?StateInterface
    {
        $model = StateModel::query()->where('title', $title)->first();
        if ($model) {
            return $model->toEntity();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $id): ?StateInterface
    {
        $model = StateModel::query()->where('id', $id)->first();
        if ($model) {
            return $model->toEntity();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getTheFirstState(): StateInterface
    {
        /**
         * When state id is not in options.child column,
         * it is not a child of any states,
         * therefore it is the first node in states tree
         */
        return StateModel::query()->orWhereNotExists(
            function ($query) {
                $query->select(DB::raw(1))
                      ->from('options')
                      ->whereRaw('options.child=states.id');
            }
        )->orderBy('id')->first()->toEntity();
    }
}
