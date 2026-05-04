<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class ViewPost extends Component
{
    public ?int $postId = null;

    public string $title = '';

    public string $content = '';

    #[On('view-post')]
    public function open(int $postId): void
    {
        $post = Post::query()
            ->select(['id', 'title', 'content', 'created_at', 'updated_at'])
            ->find($postId);

        if (! $post) {
            return;
        }

        $this->postId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;

        $this->modal('view-post-modal')->show();
    }

    public function render(): View
    {
        return view('livewire.posts.view-post');
    }
}
