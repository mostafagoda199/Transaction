<?php

namespace App\Exceptions;

use App\Domain\Shared\Responder\Interfaces\IApiHttpResponder;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiCustomException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return resolve(IApiHttpResponder::class)
            ->response(message: $this->message, status: $this->code);
    }
}
