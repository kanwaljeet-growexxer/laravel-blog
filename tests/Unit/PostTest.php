<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class PostTest extends TestCase
{
    protected User $user;
    protected Post $post;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->post = Post::factory()->for($this->user)->create();
    }

    /**
     * @return void
     */
    public function test_create_post_screen_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get('/post/create'); 
        $response->assertStatus(200);
        $response->assertViewIs('post.create');
    }

    /**
     * @return void
     */
    public function test_users_can_create_post_using_post_screen()
    {
        $response = $this->actingAs($this->user)->post('/post', [
            'title'    => 'Test post title',
            'description'  => 'Test post content',
            'category' => 'Test post category',
        ]);
        $response->assertRedirect('/post');
        $this->assertDatabaseHas('posts', [
            'title' => 'Test post title',
        ]);
    }

    /**
     * @return void
     */
    public function test_users_can_view_posts_in_post_list_screen()
    {
        $response = $this->actingAs($this->user)->get('/post'); 
        $response->assertStatus(200);
        $response->assertViewIs('post.index');
        $response->assertViewHas('posts');
    }

    /**
     * @return void
     */
    public function test_users_can_view_single_post_on_single_post_screen()
    {
        $response = $this->actingAs($this->user)->get('/post/' . $this->post->id); 
        $response->assertStatus(200);
        $response->assertViewIs('post.show');
        $response->assertViewHas('post');
    }

    /**
     * @return void
     */
    public function test_users_can_view_post_on_edit_post_screen()
    {
        $response = $this->actingAs($this->user)->get('/post/' . $this->post->id . '/edit'); 
        $response->assertStatus(200);
        $response->assertViewIs('post.edit');
        $response->assertViewHas('post');
    }

    /**
     * @return void
     */
    public function test_users_can_update_post_on_edit_post_screen()
    {
        $response = $this->actingAs($this->user)->patch('/post/' . $this->post->id, [
            'title'    => 'Test post title updated',
            'description'  => 'Test post content updated',
            'category' => 'IT',
        ]);
        $response->assertRedirect('/post');
        $this->assertDatabaseHas('posts', [
            'title' => 'Test post title updated',
        ]);
    }

    /**
     * @return void
     */
    public function test_users_can_delete_post()
    {
        $response = $this->actingAs($this->user)->delete('post/' . $this->post->id);
        $response->assertRedirect('/post');
        $this->assertDatabaseMissing('posts', [
            'id' => $this->post->id,
        ]);
    }
}