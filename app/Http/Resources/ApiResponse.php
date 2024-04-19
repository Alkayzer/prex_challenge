<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->resource['code'] ?? 200,
            'message' => $this->resource['message'] ?? 'Success',
            'data' => $this->resource['data'] ?? []
        ];
    }
}
