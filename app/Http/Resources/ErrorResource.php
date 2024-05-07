<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    public static $wrap = 'errors';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'Error',
            'message' => parent::toArray($request)['message'],
            'code' => parent::toArray($request)['code'],
            'errors' => parent::toArray($request)['errors']
        ];
    }
}
