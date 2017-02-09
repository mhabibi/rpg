<?php
namespace Tests\Unit\Repositories;

use App\Models\CharacterModel;
use App\Models\StateModel;
use App\Repositories\DbCharacterRepository;
use App\Repositories\DbStateRepository;
use TestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * @covers \App\Repositories\DbCharacterRepository
 */
class DbCharacterRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var DbCharacterRepository
     */
    protected $characterRepo;

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

        $this->characterRepo = $this->app->make(DbCharacterRepository::class);
        $this->stateRepo     = $this->app->make(DbStateRepository::class);
    }

    public function testGetByName()
    {
        factory(CharacterModel::class)->create(['name' => 'a_name']);
        $entity = $this->characterRepo->getByName('a_name');
        $this->assertEquals('a_name', $entity->getName());
    }

    public function testGetByNameNotFound()
    {
        $entity = $this->characterRepo->getByName('a_name');
        $this->assertEquals(null, $entity);
    }

    public function testCreate()
    {
        $this->characterRepo->create('a_name');
        $this->seeInDatabase('characters', ['name' => 'a_name']);
    }

    public function testSetState()
    {
        $character = factory(CharacterModel::class)->create(['name' => 'a_name', 'state_id' => null])->toEntity();
        $state     = factory(StateModel::class)->create(['title' => 'a_test_title'])->toEntity();

        $result = $this->characterRepo->setState($character, $state);
        $this->seeInDatabase('characters', ['name' => 'a_name', 'state_id' => $state->getId()]);

        $this->assertEquals($character->setState($state), $result);
    }

    public function testUpdateStock()
    {
        $character = factory(CharacterModel::class)->create(['name' => 'a_name', 'stock' => 123])->toEntity();

        $result = $this->characterRepo->updateStock($character, 456);
        $this->seeInDatabase('characters', ['name' => 'a_name', 'stock' => 456]);

        $this->assertEquals($character->setStock(456), $result);
    }
}
