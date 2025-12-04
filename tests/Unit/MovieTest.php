<?php

namespace Tests\Unit;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    public function test_filme_campos_obrigatorios_falham()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Movie::create([
            'genre' => 'Action',
            // Missing title and release_year
        ]);
    }
    public function test_image_url_usa_fallback_se_omitida()
    {
        $movie = Movie::create([
            'title' => 'Filme Sem Imagem',
            'release_year' => 2023,
            'genre' => 'Drama',
            // image_url omitted
        ]);

        $this->assertEquals(
            'https://img.freepik.com/fotos-premium/carretel-de-filme-de-oculos-3d-de-pipoca-voadora-e-ripa-em-fundo-amarelo-conceito-de-filme-de-cinema-3d_989822-1302.jpg?semt=ais_hybrid&w=740&q=80',
            $movie->image_url
        );
    }

    public function test_image_url_usa_fallback_em_atualizacao()
    {
        // Create a movie with an image URL
        $movie = Movie::create([
            'title' => 'Filme Com Imagem',
            'release_year' => 2023,
            'genre' => 'Action',
            'image_url' => 'https://example.com/custom-image.jpg',
        ]);

        // Update the movie and set image_url to empty
        $movie->update([
            'image_url' => '',
        ]);

        // Refresh the model from the database
        $movie->refresh();

        // Assert that the fallback URL was applied
        $this->assertEquals(
            'https://img.freepik.com/fotos-premium/carretel-de-filme-de-oculos-3d-de-pipoca-voadora-e-ripa-em-fundo-amarelo-conceito-de-filme-de-cinema-3d_989822-1302.jpg?semt=ais_hybrid&w=740&q=80',
            $movie->image_url
        );
    }
}
