<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieReorderTest extends TestCase
{
    use RefreshDatabase;

    public function test_movies_are_ordered_by_sort_order()
    {
        $user = User::factory()->create();
        $movie1 = Movie::create([
            'title' => 'Movie 1',
            'release_year' => 2021,
            'genre' => 'Action',
            'sort_order' => 2,
        ]);
        $movie2 = Movie::create([
            'title' => 'Movie 2',
            'release_year' => 2022,
            'genre' => 'Comedy',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)->get(route('movies.index'));

        $response->assertSeeInOrder(['Movie 2', 'Movie 1']);
    }

    public function test_can_reorder_movies()
    {
        $user = User::factory()->create();
        $movie1 = Movie::create([
            'title' => 'Movie 1',
            'release_year' => 2021,
            'genre' => 'Action',
            'sort_order' => 1,
        ]);
        $movie2 = Movie::create([
            'title' => 'Movie 2',
            'release_year' => 2022,
            'genre' => 'Comedy',
            'sort_order' => 2,
        ]);

        $response = $this->actingAs($user)->postJson(route('movies.reorder'), [
            'ids' => [$movie2->id, $movie1->id],
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('movies', [
            'id' => $movie1->id,
            'sort_order' => 1, // 0-indexed in controller loop: index 1
        ]);
        $this->assertDatabaseHas('movies', [
            'id' => $movie2->id,
            'sort_order' => 0, // 0-indexed in controller loop: index 0
        ]);
    }
}
