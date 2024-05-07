<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    public static $wrap = 'success';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => parent::toArray($request)['status'],
            'message' => parent::toArray($request)['message'],
            'code' => parent::toArray($request)['code'],
            'data' => parent::toArray($request)['data']
        ];
    }
}
