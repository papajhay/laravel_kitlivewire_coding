<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class EditPost extends Component
{
    public ?int $postId = null;

    public string $title = '';

    public string $content = '';

    #[On('edit-post')]
    public function open(int $postId): void
    {
        $post = Post::query()
            ->select(['id', 'title', 'content'])
            ->findOrFail($postId);

        $this->resetValidation();
        $this->postId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;

        $this->modal('edit-post-modal')->show();
    }

    public function update(): void
    {
        $validated = $this->validate(
            $this->rules(),
            $this->messages(),
            $this->validationAttributes(),
        );

        $post = Post::query()->find($this->postId);

        if (! $post) {
            $this->addError('form', 'The selected post could not be found.');

            return;
        }

        $post->update([
            'title' => Str::of($validated['title'])->squish()->toString(),
            'content' => trim($validated['content']),
        ]);

        $this->resetForm();
        $this->modal('edit-post-modal')->close();
        $this->dispatch('post-updated', message: 'Post updated successfully.');
    }

    public function render(): View
    {
        return view('livewire.posts.edit-post');
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'content.required' => 'The content field is required.',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'title' => 'title',
            'content' => 'content',
        ];
    }

    protected function resetForm(): void
    {
        $this->reset(['postId', 'title', 'content']);
        $this->resetValidation();
    }
}
