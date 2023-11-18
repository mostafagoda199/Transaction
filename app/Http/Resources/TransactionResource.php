<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount' => $this->resource->amount,
            'payer' => new UserResource($this->resource->payer),
            'due_on' => $this->resource->due_on,
            'vat' => $this->resource->vat,
            'is_vat_inclusive' => $this->resource->is_vat_inclusive ? trans('Yes') : trans('No'),
            'status' => $this->resource->status,
        ];
    }
}
