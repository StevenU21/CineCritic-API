<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Resources\GenreResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GenreController extends Controller
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $genres = Genre::latest()->paginate(10);
        return GenreResource::collection($genres);
    }

    public function show(int $id): GenreResource
    {
        $genre = Genre::findOrFailCustom($id);

        return new GenreResource($genre);
    }
}
