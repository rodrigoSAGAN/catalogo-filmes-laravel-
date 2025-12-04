<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmeFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o fluxo completo de um usuário autenticado acessando a listagem de filmes.
     * Verifica que a rota retorna HTTP 200 e que os filmes criados são exibidos na página.
     */
    public function test_deve_ser_capaz_de_usuario_autenticado_visualizar_listagem_de_filmes()
    {
        // Create a test user
        $user = User::factory()->create();

        // Create two test movies
        $filme1 = Movie::create([
            'title' => 'Inception',
            'release_year' => 2010,
            'genre' => 'Ação',
        ]);

        $filme2 = Movie::create([
            'title' => 'Interstellar',
            'release_year' => 2014,
            'genre' => 'Aventura',
        ]);

        // Act as the authenticated user and make a GET request
        $response = $this->actingAs($user)->get(route('movies.index'));

        // Assert HTTP 200 response
        $response->assertStatus(200);

        // Assert that both movie titles are visible on the page
        $response->assertSee('Inception');
        $response->assertSee('Interstellar');
    }

    /**
     * Testa o fluxo completo de criação de um filme por usuário autenticado.
     * Verifica que o usuário pode submeter o formulário via POST,
     * que o sistema redireciona após sucesso, e que o filme é persistido no banco.
     */
    public function test_deve_ser_capaz_de_usuario_autenticado_criar_novo_filme()
    {
        // Create a test user
        $user = User::factory()->create();

        // Define valid movie data
        $filmeData = [
            'title' => 'The Dark Knight',
            'release_year' => 2008,
            'genre' => 'Ação',
            'autor' => 'Christopher Nolan',
            'is_series' => false,
            'rating' => 9.0,
            'image_url' => 'https://example.com/dark-knight.jpg',
            'personal_comment' => 'Um dos melhores filmes de super-heróis já feitos.',
            'user_rating' => 5,
        ];

        // Act as authenticated user and make POST request to store route
        $response = $this->actingAs($user)->post(route('movies.store'), $filmeData);

        // Assert redirect after successful creation (HTTP 302)
        $response->assertStatus(302);

        // Assert that the movie exists in the database
        $this->assertDatabaseHas('movies', [
            'title' => 'The Dark Knight',
            'release_year' => 2008,
            'genre' => 'Ação',
            'autor' => 'Christopher Nolan',
        ]);
    }

    /**
     * Testa o fluxo completo de atualização de um filme por usuário autenticado.
     * Verifica que o usuário pode editar um filme existente via PUT/PATCH,
     * que o sistema redireciona após sucesso, e que as alterações são persistidas no banco.
     */
    public function test_deve_ser_capaz_de_usuario_autenticado_atualizar_filme()
    {
        // Create a test user
        $user = User::factory()->create();

        // Create an existing movie
        $movie = Movie::create([
            'title' => 'Original Title',
            'release_year' => 2020,
            'genre' => 'Drama',
            'autor' => 'Original Director',
        ]);

        // Define updated movie data
        $updatedData = [
            'title' => 'Updated Title',
            'release_year' => 2021,
            'genre' => 'Ação',
            'autor' => 'Updated Director',
            'is_series' => false,
            'rating' => 8.5,
            'image_url' => 'https://example.com/updated.jpg',
            'personal_comment' => 'Comentário atualizado.',
            'user_rating' => 4,
        ];

        // Act as authenticated user and make PUT request to update route
        $response = $this->actingAs($user)->put(route('movies.update', $movie->id), $updatedData);

        // Assert redirect after successful update (HTTP 302)
        $response->assertStatus(302);

        // Assert that the movie exists with NEW data in the database
        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'title' => 'Updated Title',
            'release_year' => 2021,
            'genre' => 'Ação',
            'autor' => 'Updated Director',
        ]);

        // Assert that the movie with OLD data no longer exists
        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id,
            'title' => 'Original Title',
            'release_year' => 2020,
            'autor' => 'Original Director',
        ]);
    }

    /**
     * Testa o fluxo completo de exclusão de um filme por usuário autenticado.
     * Verifica que o usuário pode excluir um filme existente via DELETE,
     * que o sistema redireciona após sucesso, e que o filme é removido do banco de dados.
     */
    public function test_deve_ser_capaz_de_usuario_autenticado_excluir_filme()
    {
        // Create a test user
        $user = User::factory()->create();

        // Create an existing movie
        $movie = Movie::create([
            'title' => 'Filme a Ser Excluído',
            'release_year' => 2019,
            'genre' => 'Terror',
            'autor' => 'Director To Delete',
        ]);

        // Act as authenticated user and make DELETE request to destroy route
        $response = $this->actingAs($user)->delete(route('movies.destroy', $movie->id));

        // Assert redirect after successful deletion (HTTP 302)
        $response->assertStatus(302);

        // Assert that the movie no longer exists in the database
        $this->assertDatabaseMissing('movies', [
            'id' => $movie->id,
            'title' => 'Filme a Ser Excluído',
            'release_year' => 2019,
        ]);
    }
}
