<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use App\Http\Resources\MovieResource;
use App\Services\ImageService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller
{
    use AuthorizesRequests;
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Movie::class);

        $movies = Movie::with(['genre', 'movie', 'ratingAverage', 'reviewsCount'])->get();

        return MovieResource::collection($movies);
    }

    public function show(int $id): MovieResource
    {
        $movie = Movie::findOrFailCustom($id);
        $this->authorize('view', $movie);
        $movie->load(['genre', 'movie', 'ratingAverage', 'reviewsCount']);

        return new MovieResource($movie);
    }

    public function store(MovieRequest $request, ImageService $imageService): MovieResource
    {
        $this->authorize('create', Movie::class);

        $movie = Movie::create($request->validated());

        if ($request->hasFile('cover_image')) {
            $movie->cover_image = $imageService->storeImage($request->file('cover_image'), $movie->title, $movie->id, 'movies_images');
            $movie->save();
        }

        return new MovieResource($movie);
    }

    public function update(MovieRequest $request, int $id, ImageService $imageService): MovieResource
    {
        $movie = Movie::findOrFailCustom($id);
        $this->authorize('update', $movie);

        $movie->update($request->validated());

        if ($request->hasFile('cover_image')) {
            if ($movie->cover_image) {
                $imageService->deleteImage($movie->cover_image);
            }
            $movie->image = $imageService->storeImage($request->file('image'), $movie->title, $movie->id, 'movies_images');
            $movie->save();
        }

        return new MovieResource($movie);
    }

    public function destroy(int $id, ImageService $imageService): MovieResource
    {
        $movie = Movie::findOrFailCustom($id);
        $this->authorize('delete', $movie);

        if ($movie->cover_image) {
            $imageService->deleteImage($movie->cover_image);
        }

        $movie->delete();

        return new MovieResource($movie);
    }
}
