<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Throwable;

class CreatePost extends Component
{
    public string $title = '';

    public string $content = '';

    public function save(): void
    {
        $this->resetErrorBag('form');
        $this->normalizeInput();

        $validated = $this->validate(
            $this->rules(),
            $this->messages(),
            $this->validationAttributes(),
        );

        try {
            DB::transaction(function () use ($validated): void {
                Post::query()->create($validated);
            });
        } catch (Throwable $exception) {
            report($exception);

            $this->addError('form', 'The post could not be created right now. Please try again in a moment.');

            return;
        }

        $this->resetForm();
        $this->modal('create-post-modal')->close();
        $this->dispatch('post-created', message: 'Post created successfully.');
    }

    public function render(): View
    {
        return view('livewire.posts.create-post');
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        $plainTextRule = function (string $attribute, mixed $value, \Closure $fail): void {
            if (! is_string($value) || $value !== strip_tags($value)) {
                $fail("The {$attribute} field contains invalid characters.");
            }
        };

        return [
            'title' => ['required', 'string', 'min:3', 'max:120', $plainTextRule],
            'content' => ['required', 'string', 'min:10', 'max:5000', $plainTextRule],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'title.required' => 'A title is required before the post can be created.',
            'title.min' => 'The title must contain at least 3 characters.',
            'title.max' => 'The title may not be greater than 120 characters.',
            'content.required' => 'Content is required before the post can be created.',
            'content.min' => 'The content must contain at least 10 characters.',
            'content.max' => 'The content may not be greater than 5000 characters.',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'title' => 'post title',
            'content' => 'post content',
        ];
    }

    protected function normalizeInput(): void
    {
        $this->title = Str::of($this->title)->squish()->toString();
        $this->content = trim(str_replace(["\r\n", "\r"], "\n", $this->content));
    }

    protected function resetForm(): void
    {
        $this->reset(['title', 'content']);
        $this->resetValidation();
    }
}
