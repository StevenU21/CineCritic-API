<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->when($request->has('include_id'), $this->id),
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->when($request->has('include_timestamps'), $this->created_at->format('Y-m-d H:i:s')),
        ];
    }
}
