<?php
namespace Tests\Unit\Controllers;

use App\Entities\CharacterInterface;
use App\Game\ControllerInterface;
use App\Http\Controllers\CharacterController;
use App\Repositories\CharacterRepositoryInterface;
use Illuminate\Http\Response;
use TestCase;
use Illuminate\Http\Request;

/**
 * @covers \App\Http\Controllers\CharacterController
 */
class CharacterControllerTest extends TestCase
{
    public function postValidationFailProvider()
    {
        return [
            'name is not string'  => [
                'payload' => [
                    'name' => 123,
                ],
                'status'  => Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            'name is null'        => [
                'payload' => [
                    'name' => null,
                ],
                'status'  => Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            'name does not exist' => [
                'payload' => [
                ],
                'status'  => Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
        ];
    }

    /**
     * @dataProvider postValidationFailProvider
     * @expectedException \Illuminate\Validation\ValidationException
     */
    public function testPostValidationFail($payload, $status)
    {
        $gameControllerMock = $this->createMock(ControllerInterface::class);

        $characterRepoMock = $this->createMock(CharacterRepositoryInterface::class);
        $request           = Request::create('', 'POST', $payload);

        $controller = new CharacterController($gameControllerMock, $characterRepoMock);
        $controller->post($request);
    }

    public function testPostNameAlreadyExists()
    {
        $gameControllerMock = $this->createMock(ControllerInterface::class);

        $characterRepoMock = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepoMock->expects($this->once())->method('getByName')->with('a_name')->willReturn(true);

        $request = Request::create('', 'POST', ['name' => 'a_name']);

        $controller = new CharacterController($gameControllerMock, $characterRepoMock);
        /** @var Response $response */
        $response = $controller->post($request);
        $this->assertEquals(Response::HTTP_NOT_ACCEPTABLE, $response->getStatusCode());
    }

    public function testPostSuccessful()
    {
        $gameControllerMock = $this->createMock(ControllerInterface::class);

        $characterMock     = $this->createMock(CharacterInterface::class);
        $characterRepoMock = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepoMock->expects($this->once())->method('getByName')->with('a_name')->willReturn(false);
        $characterRepoMock->expects($this->once())->method('create')->with('a_name')->willReturn($characterMock);

        $request = Request::create('', 'POST', ['name' => 'a_name']);

        $controller = new CharacterController($gameControllerMock, $characterRepoMock);
        /** @var Response $response */
        $response = $controller->post($request);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
}
