<?php
namespace Tests\Unit\Models;

use App\Models\CharacterModel;
use App\Models\StateModel;
use TestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * @covers \App\Models\CharacterModel
 * @covers \App\Entities\Character
 */
class CharacterModelTest extends TestCase
{
    use DatabaseTransactions;

    public function testToEntity()
    {
        $insertedState  = factory(StateModel::class)->create();
        $characterModel = factory(CharacterModel::class)->create(
            [
                'name'     => 'a_name',
                'stock'    => 123,
                'state_id' => $insertedState['id']
            ]
        );

        $characterEntity = $characterModel->toEntity();
        $this->assertEquals('a_name', $characterEntity->getName());
        $this->assertEquals(123, $characterEntity->getStock());
        $this->assertEquals($characterModel['id'], $characterEntity->getId());
        $this->assertEquals($insertedState->toEntity(), $characterEntity->getState());
    }
}
