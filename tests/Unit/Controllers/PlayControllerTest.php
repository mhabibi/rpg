<?php

namespace Tests\Unit\Controllers;

use App\Entities\CharacterInterface;
use App\Entities\StateInterface;
use App\Game\ControllerInterface;
use App\Http\Controllers\PlayController;
use App\Repositories\CharacterRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TestCase;

/**
 * @covers \App\Http\Controllers\PlayController
 * @covers \App\Http\Controllers\BaseController
 */
class PlayControllerTest extends TestCase
{
    public function testGetNotFound()
    {
        $gameControllerMock = $this->createMock(ControllerInterface::class);
        $stateRepoMock      = $this->createMock(StateRepositoryInterface::class);
        $characterRepoMock  = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepoMock->expects($this->once())->method('getByName')->with('wrong_name')->willReturn(null);

        $controller = new PlayController($gameControllerMock, $stateRepoMock, $characterRepoMock);
        $reponse    = $controller->get('wrong_name');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $reponse->getStatusCode());
    }

    public function testGetSuccessful()
    {
        $stateMock = $this->createMock(StateInterface::class);
        $stateMock->expects($this->once())->method('getOptions')->willReturn([1 => 'option1', 2 => 'option2']);
        $stateMock->expects($this->once())->method('getTitle')->willReturn('a_title');
        $stateMock->expects($this->once())->method('getDescription')->willReturn('desc');

        $characterMock = $this->createMock(CharacterInterface::class);
        $characterMock->expects($this->once())->method('getName')->willReturn('a_name');
        $characterMock->expects($this->once())->method('getStock')->willReturn(10);

        $gameControllerMock = $this->createMock(ControllerInterface::class);
        $gameControllerMock->expects($this->once())
                           ->method('currentState')
                           ->with($characterMock)
                           ->willReturn($stateMock);

        $stateRepoMock = $this->createMock(StateRepositoryInterface::class);

        $characterRepoMock = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepoMock->expects($this->once())->method('getByName')->with('a_name')->willReturn($characterMock);

        $controller = new PlayController($gameControllerMock, $stateRepoMock, $characterRepoMock);
        $response   = $controller->get('a_name');
        $expected   = '{"character":"a_name","stock":10,"title":"a_title","description":"desc","options":{"1":"option1","2":"option2"}}';
        $this->assertJsonStringEqualsJsonString($expected, $response->getContent());
    }

    public function putValidationFailProvider()
    {
        return [
            'id is not number'  => [
                'payload' => [
                    'id' => "123a",
                ],
            ],
            'id is null'        => [
                'payload' => [
                    'id' => null,
                ],
            ],
            'id does not exist' => [
                'payload' => [
                ],
            ],
        ];
    }

    /**
     * @dataProvider putValidationFailProvider
     * @expectedException \Illuminate\Validation\ValidationException
     */
    public function testPutValidationFail($payload)
    {
        $gameControllerMock = $this->createMock(ControllerInterface::class);

        $characterRepoMock = $this->createMock(CharacterRepositoryInterface::class);
        $request           = Request::create('', 'PUT', $payload);

        $stateRepoMock = $this->createMock(StateRepositoryInterface::class);

        $controller = new PlayController($gameControllerMock, $stateRepoMock, $characterRepoMock);
        $controller->put($request, 'a_name');
    }

    public function testNameNotFound()
    {
        $gameControllerMock = $this->createMock(ControllerInterface::class);
        $characterRepoMock  = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepoMock->expects($this->once())->method('getByName')->with('wrong_name')->willReturn(null);
        $request       = Request::create('', 'PUT', ['id' => 1]);
        $stateRepoMock = $this->createMock(StateRepositoryInterface::class);

        $controller = new PlayController($gameControllerMock, $stateRepoMock, $characterRepoMock);
        $response   = $controller->put($request, 'wrong_name');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testSelectedOptionNotExist()
    {
	$characterMock = $this->createMock(CharacterInterface::class);

        $gameControllerMock = $this->createMock(ControllerInterface::class);
        $characterRepoMock  = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepoMock->expects($this->once())->method('getByName')->with('a_name')->willReturn($characterMock);
        $request       = Request::create('', 'PUT', ['id' => 1]);
        $stateRepoMock = $this->createMock(StateRepositoryInterface::class);
        $stateRepoMock->expects($this->once())->method('getById')->with(1)->willReturn(null);

        $controller = new PlayController($gameControllerMock, $stateRepoMock, $characterRepoMock);
        $response   = $controller->put($request, 'a_name');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testSelectedOptionNotValid()
    {
        $characterMock = $this->createMock(CharacterInterface::class);

        $characterRepoMock = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepoMock->expects($this->once())->method('getByName')->with('a_name')->willReturn($characterMock);

        $currentStateMock = $this->createMock(StateInterface::class);
        $currentStateMock->expects($this->once())->method('getOptions')->willReturn([1 => 1, 2 => 2]);

        $gameControllerMock = $this->createMock(ControllerInterface::class);
        $gameControllerMock->expects($this->once())
                           ->method('currentState')
                           ->with($characterMock)
                           ->willReturn($currentStateMock);

        $request = Request::create('', 'PUT', ['id' => 1]);

        $nextStateMock = $this->createMock(StateInterface::class);
        $nextStateMock->expects($this->once())->method('getId')->willReturn(3);

        $stateRepoMock = $this->createMock(StateRepositoryInterface::class);
        $stateRepoMock->expects($this->once())->method('getById')->with(1)->willReturn($nextStateMock);

        $controller = new PlayController($gameControllerMock, $stateRepoMock, $characterRepoMock);
        $response   = $controller->put($request, 'a_name');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testSuccessfulMove()
    {
        $characterMock = $this->createMock(CharacterInterface::class);
        $characterMock->expects($this->any())->method('getName')->willReturn('a_name');

        $characterRepoMock = $this->createMock(CharacterRepositoryInterface::class);
        $characterRepoMock->expects($this->any())->method('getByName')->with('a_name')->willReturn($characterMock);

        $currentStateMock = $this->createMock(StateInterface::class);
        $currentStateMock->expects($this->exactly(2))->method('getOptions')->willReturn([1 => 1]);

        $nextStateMock = $this->createMock(StateInterface::class);
        $nextStateMock->expects($this->once())->method('getId')->willReturn(1);

        $gameControllerMock = $this->createMock(ControllerInterface::class);
        $gameControllerMock->expects($this->exactly(2))
                           ->method('currentState')
                           ->with($characterMock)
                           ->willReturn($currentStateMock);
        $gameControllerMock->expects($this->once())
                           ->method('move')
                           ->with($characterMock, $nextStateMock)
                           ->willReturn($characterMock);

        $request = Request::create('', 'PUT', ['id' => 1]);

        $stateRepoMock = $this->createMock(StateRepositoryInterface::class);
        $stateRepoMock->expects($this->once())->method('getById')->with(1)->willReturn($nextStateMock);

        $controller = new PlayController($gameControllerMock, $stateRepoMock, $characterRepoMock);
        $response   = $controller->put($request, 'a_name');
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
