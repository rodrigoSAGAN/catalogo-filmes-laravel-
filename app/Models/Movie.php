<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'release_year',
        'genre',
        'autor',
        'is_series',
        'rating',
        'image_url',
        'personal_comment',
        'user_rating',
        'sort_order',
    ];
    protected static function booted()
    {
        static::creating(function ($movie) {
            if (empty($movie->image_url)) {
                $movie->image_url = 'https://img.freepik.com/fotos-premium/carretel-de-filme-de-oculos-3d-de-pipoca-voadora-e-ripa-em-fundo-amarelo-conceito-de-filme-de-cinema-3d_989822-1302.jpg?semt=ais_hybrid&w=740&q=80';
            }
        });

        static::updating(function ($movie) {
            if (empty($movie->image_url)) {
                $movie->image_url = 'https://img.freepik.com/fotos-premium/carretel-de-filme-de-oculos-3d-de-pipoca-voadora-e-ripa-em-fundo-amarelo-conceito-de-filme-de-cinema-3d_989822-1302.jpg?semt=ais_hybrid&w=740&q=80';
            }
        });
    }

    /**
     * Scope a query to only include movies of a given genre.
     */
    public function scopePorGenero($query, $genero)
    {
        return $query->where('genre', $genero);
    }

    public function scopePorAutor($query, $autor)
    {
        return $query->where('autor', 'LIKE', '%' . $autor . '%');
    }
}
