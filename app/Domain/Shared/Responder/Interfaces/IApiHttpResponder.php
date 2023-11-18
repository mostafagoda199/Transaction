<?php

declare(strict_types=1);

namespace App\Domain\Shared\Responder\Interfaces;

use Illuminate\Http\JsonResponse;

interface IApiHttpResponder
{
    /**
     * @param array<string,int> $data
     * @param null|string $message
     * @param int $status
     * @return JsonResponse
     */
    public function response(array $data = [], string|null $message = null, int $status = 200): JsonResponse;
}
