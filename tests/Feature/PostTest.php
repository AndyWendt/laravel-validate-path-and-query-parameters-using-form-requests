<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * @test
     */
    public function it_allows_you_to_replace_a_post()
    {
        // Arrange
        Post::truncate();
        $post = Post::create([
            'name' => 'foobar'
        ]);

        // Act
        $response = $this->put(sprintf('/api/posts/%s', $post->id), [
            'name' => 'fizzbuzz',
        ]);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['name' => 'fizzbuzz']);
    }
}
