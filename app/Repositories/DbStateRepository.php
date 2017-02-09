<?php
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
     * @param $title
     *
     * @return StateInterface
     * TODO remove this method and use getById when output is refactored. States should be fetched by Id
     */
    public function getByTitle($title): StateInterface
    {
        return StateModel::query()->where('title', $title)->first()->toEntity();
    }

    /**
     * @param int $id
     *
     * @return StateInterface
     */
    public function getById(int $id): StateInterface
    {
        return StateModel::query()->where('id', $id)->first()->toEntity();
    }

    /**
     * @return StateInterface
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
