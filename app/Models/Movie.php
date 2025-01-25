<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'release_date',
        'genre_id',
        'director_id',
    ];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function director(): BelongsTo
    {
        return $this->belongsTo(Director::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getImageAttribute(): string
    {
        return asset('storage/' . $this->cover_image);
    }
}
