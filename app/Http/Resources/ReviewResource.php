<?php

namespace App\Http\Resources;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        return [
            'id' => $this->when($user && $user->hasRole('admin') && $request->has('include_id'), $this->id),
            'content' => $this->content,
            'rating' => $this->rating,
            'movie' => $this->movie->title,
            'user' => $this->whenLoaded('user', function () {
                return $this->user->name;
            }),
            'created_at' => $this->when($user && $user->hasRole('admin') && $request->has('include_timestamps'), $this->created_at->format('Y-m-d H:i:s')),
            'updated_at' => $this->when($user && $user->hasRole('admin') && $request->has('include_timestamps'), $this->updated_at->format('Y-m-d H:i:s')),
        ];
    }
}
