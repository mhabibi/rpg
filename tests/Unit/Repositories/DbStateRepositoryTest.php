<?php

namespace Tests\Unit\Repositories;

use App\Entities\StateInterface;
use App\Models\StateModel;
use App\Repositories\DbStateRepository;
use TestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * @covers \App\Repositories\DbStateRepository
 */
class DbStateRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var DbStateRepository
     */
    protected $stateRepo;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->stateRepo = $this->app->make(DbStateRepository::class);
    }

    public function testGetByTitle()
    {
        factory(StateModel::class)->create(['title' => 'a_state_title']);
        $entity = $this->stateRepo->getByTitle('a_state_title');
        $this->assertEquals('a_state_title', $entity->getTitle());
    }

    public function testGetById()
    {
        $insertedState = factory(StateModel::class)->create(['title' => 'a_state_title']);
        $entity        = $this->stateRepo->getById($insertedState['id']);
        $this->assertEquals('a_state_title', $entity->getTitle());
    }

    public function testGetTheFirstState()
    {
        factory(StateModel::class)->create(['title' => 'a_state_title']);
        $entity = $this->stateRepo->getTheFirstState();
        $this->assertInstanceOf(StateInterface::class, $entity);
        $this->notSeeInDatabase('options', ['child' => $entity->getId()]);
    }
}
