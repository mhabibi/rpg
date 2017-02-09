<?php
namespace Tests\Unit\Models;

use App\Models\StateModel;
use TestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * @covers \App\Models\StateModel
 * @covers \App\Entities\State
 */
class StateModelTest extends TestCase
{
    use DatabaseTransactions;

    public function testToEntity()
    {
        $stateModel = factory(StateModel::class)->create(
            [
                'title'       => 'a_title',
                'description' => 'description',
                'cost'        => 10,
            ]
        );

        $stateEntity = $stateModel->toEntity();
        $this->assertEquals('a_title', $stateEntity->getTitle());
        $this->assertEquals('description', $stateEntity->getDescription());
        $this->assertEquals(10, $stateEntity->getCost());
        $this->assertEquals($stateModel['id'], $stateEntity->getId());
        $this->assertEmpty($stateEntity->getOptions());
    }
}
