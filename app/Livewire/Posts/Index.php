<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Posts')]
class Index extends Component
{
    use WithPagination;

    public int $perPage = 10;

    #[On('post-created')]
    public function refreshPosts(string $message = 'Post created successfully.'): void
    {
        session()->flash('status', $message);
        $this->resetPage();
    }

    #[On('post-updated')]
    public function handlePostUpdated(string $message = 'Post updated successfully.'): void
    {
        session()->flash('status', $message);
        $this->resetPage();
    }

    public function editPost(Post $post): void
    {
        $this->dispatch('edit-post', postId: $post->id);
    }

    public function deletePost(Post $post): void
    {
        $post->delete();

        session()->flash('status', 'Post deleted successfully.');

        if ($this->hasEmptyPage()) {
            $this->previousPage();
        }
    }

    public function render(): View
    {
        return view('livewire.posts.index', [
            'posts' => Post::query()
                ->select(['id', 'title', 'content', 'created_at', 'updated_at'])
                ->latest('updated_at')
                ->paginate($this->perPage),
        ]);
    }

    protected function hasEmptyPage(): bool
    {
        if ($this->getPage() === 1) {
            return false;
        }

        return ($this->getPage() - 1) * $this->perPage >= Post::query()->count();
    }
}
