<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Post::truncate();
    }

    /**
     * @test
     */
    public function it_allows_you_to_replace_a_post()
    {
        // Arrange
        $post = Post::create(['name' => 'foobar']);

        // Act
        $response = $this->putJson(sprintf('/api/posts/%s', $post->id), [
            'name' => 'fizzbuzz',
        ]);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['name' => 'fizzbuzz']);
        $this->assertDatabaseMissing('posts', ['name' => 'foobar']);
    }

    /**
     * @test
     */
    public function it_fails_validation_if_the_post_id_is_incorrect()
    {
        // Arrange
        Post::create(['name' => 'foobar']);

        // Act
        $response = $this->putJson(sprintf('/api/posts/%s', 235435), [
            'name' => 'fizzbuzz',
        ]);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonFragment(['post_id' => ['The selected post id is invalid.']]);
        $this->assertDatabaseHas('posts', ['name' => 'foobar']);
        $this->assertDatabaseMissing('posts', ['name' => 'fizzbuzz']);
    }

    /**
     * @test
     */
    public function it_fails_validation_if_a_query_parameter_is_incorrect()
    {
        // Arrange
        $post = Post::create(['name' => 'foobar']);

        // Act
        $response = $this->putJson(sprintf('/api/posts/%s?include=adfasdf', $post->id), [
            'name' => 'fizzbuzz',
        ]);

        // Assert
        $response->assertStatus(422);
        $response->assertJsonFragment(['include' => ['The include must be a number.']]);
        $this->assertDatabaseHas('posts', ['name' => 'foobar']);
        $this->assertDatabaseMissing('posts', ['name' => 'fizzbuzz']);
    }

    /**
     * @test
     */
    public function it_allows_a_valid_include_query_paramter()
    {
        // Arrange
        $post = Post::create(['name' => 'foobar']);

        // Act
        $response = $this->putJson(sprintf('/api/posts/%s?include=1234', $post->id), [
            'name' => 'fizzbuzz',
        ]);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['name' => 'fizzbuzz']);
        $this->assertDatabaseMissing('posts', ['name' => 'foobar']);
    }
}
