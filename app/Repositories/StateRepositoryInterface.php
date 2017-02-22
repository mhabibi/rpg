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
     * TODO refactor after php 7.1 to getByTitle(string $title): ?StateInterface
     */
    public function getByTitle(string $title);

    /**
     * @param int $id
     *
     * @return StateInterface|null
     * TODO refactor after php 7.1 to getById(int $id): ?StateInterface
     */
    public function getById(int $id);

    /**
     * @return StateInterface
     */
    public function getTheFirstState(): StateInterface;
}
