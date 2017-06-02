<?php
namespace App\Repositories;

use App\Entities\StateInterface;

/**
 * Interface StateRepositoryInterface
 *
 * @package App\Repositories
 */
interface StateRepositoryInterface
{
    /**
     * @param $title
     *
     * @return StateInterface|null
     */
    public function getByTitle(string $title): ?StateInterface;

    /**
     * @param int $id
     *
     * @return StateInterface|null
     */
    public function getById(int $id): ?StateInterface;

    /**
     * @return StateInterface
     */
    public function getTheFirstState(): StateInterface;
}
