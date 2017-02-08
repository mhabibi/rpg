<?php
namespace App\Repositories;

use App\Entities\StateInterface;

interface StateRepositoryInterface
{
    public function getByTitle($title): StateInterface;

    public function getById(int $id): StateInterface;

    public function getTheFirstState(): StateInterface;
}
