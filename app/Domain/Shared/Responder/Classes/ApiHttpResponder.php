<?php

declare(strict_types=1);

namespace App\Domain\Shared\Responder\Classes;

use App\Domain\Shared\Responder\Interfaces\IApiHttpResponder;
use Illuminate\Http\JsonResponse;

class ApiHttpResponder implements IApiHttpResponder
{
    /**
     * @param array<string,int> $data
     * @param null|string $message
     * @param int $status
     * @return JsonResponse
     */
    public function response(array $data = [], string|null $message = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
