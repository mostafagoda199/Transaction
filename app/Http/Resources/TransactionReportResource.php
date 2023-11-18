<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'year' => $this->resource['year'],
            'month' => $this->resource['month'],
            'paid' => $this->resource['paid'],
            'outstanding' => $this->resource['outstanding'],
            'overdue' => $this->resource['overdue'],
        ];
    }
}
