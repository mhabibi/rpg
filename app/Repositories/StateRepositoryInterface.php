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
    public function getByTitle($title);

    /**
     * @param int $id
     *
     * @return StateInterface|null
     */
    public function getById(int $id);

    /**
     * @return StateInterface
     */
    public function getTheFirstState(): StateInterface;
}
