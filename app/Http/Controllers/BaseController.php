<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller;

/**
 * Class BaseController
 *
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    /**
     * @param array|null $data
     *
     * @return Response
     */
    protected function response(array $data = null): Response
    {
        return new Response($data, Response::HTTP_OK);
    }

    /**
     * @return Response
     */
    protected function notFound(): Response
    {
        return new Response(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * @return Response
     */
    protected function badRequest(): Response
    {
        return new Response(null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @return Response
     */
    protected function notAcceptable(): Response
    {
        return new Response(null, Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @return Response
     */
    protected function created(): Response
    {
        return new Response(null, Response::HTTP_CREATED);
    }
}
