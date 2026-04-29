<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Posts')]
class Index extends Component
{
    use WithPagination;

    public ?int $postId = null;

    public string $title = '';

    public string $content = '';

    public function save(): void
    {
        $validated = $this->validate($this->rules());

        if ($this->postId === null) {
            Post::query()->create($validated);

            session()->flash('status', 'Post created successfully.');
        } else {
            Post::query()->findOrFail($this->postId)->update($validated);

            session()->flash('status', 'Post updated successfully.');
        }

        $this->resetForm();
        $this->resetPage();
    }

    public function editPost(Post $post): void
    {
        $this->resetValidation();

        $this->postId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
    }

    public function cancelEditing(): void
    {
        $this->resetForm();
    }

    public function deletePost(Post $post): void
    {
        $post->delete();

        if ($this->postId === $post->id) {
            $this->resetForm();
        }

        session()->flash('status', 'Post deleted successfully.');

        $this->resetPage();
    }

    public function render(): View
    {
        return view('livewire.posts.index', [
            'posts' => Post::query()
                ->latest()
                ->paginate(5),
        ]);
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ];
    }

    protected function resetForm(): void
    {
        $this->reset(['postId', 'title', 'content']);
        $this->resetValidation();
    }
}
