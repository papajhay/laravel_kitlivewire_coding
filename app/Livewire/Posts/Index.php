<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Flux\Flux;
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

    public int $perPage = 5;

    public ?int $postIdToDelete = null;

    #[On('post-created')]
    public function refreshPosts(): void
    {
        $this->resetPage();
    }

    public function editPost(Post $post): void
    {
        $this->dispatch('edit-post', postId: $post->id);
    }

    public function confirmDeletePost(int $postId): void
    {
        $this->postIdToDelete = $postId;

        $this->modal('delete-post-modal')->show();
    }

    public function deletePost(): void
    {
        $post = Post::query()->find($this->postIdToDelete);

        if (! $post) {
            $this->postIdToDelete = null;
            $this->modal('delete-post-modal')->close();

            return;
        }

        $post->delete();
        $this->postIdToDelete = null;
        $this->modal('delete-post-modal')->close();

        Flux::toast(
            text: 'Post deleted successfully.',
            duration: 2000,
            variant: 'success',
        );

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
