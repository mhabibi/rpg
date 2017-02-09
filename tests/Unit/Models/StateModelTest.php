<?php
namespace Tests\Unit\Models;

use App\Models\StateModel;
use TestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * @covers \App\Models\StateModel
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
            ]
        );

        $stateEntity = $stateModel->toEntity();
        $this->assertEquals('a_title', $stateEntity->getTitle());
        $this->assertEquals('description', $stateEntity->getDescription());
    }
}
