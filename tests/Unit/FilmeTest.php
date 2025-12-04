<?php

namespace Tests\Unit;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se o campo image_url usa o fallback quando omitido na criação.
     * Verifica que um filme criado sem imagem recebe automaticamente a URL padrão.
     */
    public function test_deve_ser_capaz_de_usar_fallback_para_imagem_quando_omitida()
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

    /**
     * Testa o scope porGenero do Model Movie.
     * Verifica que apenas filmes do gênero especificado são retornados.
     */
    public function test_deve_ser_capaz_de_filtrar_filmes_por_genero()
    {
        // Create test movies
        Movie::create([
            'title' => 'Filme A',
            'release_year' => 2023,
            'genre' => 'Ação',
        ]);

        Movie::create([
            'title' => 'Filme B',
            'release_year' => 2023,
            'genre' => 'Comédia',
        ]);

        Movie::create([
            'title' => 'Filme C',
            'release_year' => 2023,
            'genre' => 'Ação',
        ]);

        // Filter movies by genre 'Ação'
        $filmes_filtrados = Movie::porGenero('Ação')->get();

        // Assert count
        $this->assertCount(2, $filmes_filtrados);

        // Assert titles contain 'Filme A' and 'Filme C'
        $titulos = $filmes_filtrados->pluck('title')->toArray();
        $this->assertTrue(in_array('Filme A', $titulos));
        $this->assertTrue(in_array('Filme C', $titulos));
    }

    /**
     * Testa o scope porAutor do Model Movie.
     * Verifica que apenas filmes do autor especificado são retornados usando LIKE.
     */
    public function test_deve_ser_capaz_de_buscar_filmes_por_autor()
    {
        // Create movies with different authors
        Movie::create(['title' => 'Filme A', 'release_year' => 2023, 'genre' => 'Ação', 'autor' => 'Christopher Nolan']);
        Movie::create(['title' => 'Filme B', 'release_year' => 2022, 'genre' => 'Drama', 'autor' => 'Steven Spielberg']);
        Movie::create(['title' => 'Filme C', 'release_year' => 2024, 'genre' => 'Terror', 'autor' => 'Christopher Nolan']);

        // Search by author
        $filmes_filtrados = Movie::porAutor('Christopher Nolan')->get();

        // Assert that only 2 movies by Christopher Nolan are returned
        $this->assertCount(2, $filmes_filtrados);

        // Assert titles contain 'Filme A' and 'Filme C'
        $titulos = $filmes_filtrados->pluck('title')->toArray();
        $this->assertTrue(in_array('Filme A', $titulos));
        $this->assertTrue(in_array('Filme C', $titulos));
    }

    /**
     * Testa que o campo 'autor' é nullable (não obrigatório).
     * Verifica que um filme pode ser criado sem fornecer o campo autor,
     * e que o campo é salvo como NULL no banco de dados.
     */
    public function test_deve_ser_capaz_de_criar_filme_sem_autor()
    {
        // Create a movie without providing the 'autor' field
        $movie = Movie::create([
            'title' => 'Filme Sem Autor',
            'release_year' => 2023,
            'genre' => 'Drama',
            // autor field omitted intentionally
        ]);

        // Assert that the movie was created successfully
        $this->assertTrue($movie->exists);

        // Assert that the autor field is NULL
        $this->assertNull($movie->autor);

        // Verify in database
        $this->assertDatabaseHas('movies', [
            'title' => 'Filme Sem Autor',
            'release_year' => 2023,
            'genre' => 'Drama',
            'autor' => null,
        ]);
    }
}
