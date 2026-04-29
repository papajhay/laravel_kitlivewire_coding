<?php

use App\Livewire\Posts\CreatePost;
use App\Livewire\Posts\Index;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

test('guests are redirected away from the posts page', function () {
    $this->get('/posts')->assertRedirect('/login');
});

test('authenticated users can visit the posts page', function () {
    $this->actingAs(User::factory()->create());

    $this->get('/posts')
        ->assertOk()
        ->assertSee('Posts');
});

test('a user can create a post', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(CreatePost::class)
        ->set('title', 'My first post')
        ->set('content', 'This is the content of the first post.')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('posts', [
        'title' => 'My first post',
        'content' => 'This is the content of the first post.',
    ]);
});

test('a user sees custom validation messages when invalid data is submitted', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(CreatePost::class)
        ->set('title', '  ')
        ->set('content', 'short')
        ->call('save')
        ->assertHasErrors(['title', 'content'])
        ->assertSee('A title is required before the post can be created.')
        ->assertSee('The content must contain at least 10 characters.');
});

test('a user can update a post', function () {
    $this->actingAs(User::factory()->create());

    $post = Post::factory()->create();

    Livewire::test(Index::class)
        ->call('editPost', $post)
        ->set('title', 'Updated title')
        ->set('content', 'Updated content')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Updated title',
        'content' => 'Updated content',
    ]);
});

test('a user can delete a post', function () {
    $this->actingAs(User::factory()->create());

    $post = Post::factory()->create();

    Livewire::test(Index::class)
        ->call('deletePost', $post)
        ->assertHasNoErrors();

    $this->assertDatabaseMissing('posts', [
        'id' => $post->id,
    ]);
});
