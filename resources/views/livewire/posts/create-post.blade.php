<div class="shrink-0">
    <flux:modal.trigger name="create-post-modal">
        <flux:button variant="primary" icon="folder-plus" >
            Create Post
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-post-modal" :show="$errors->isNotEmpty()" focusable class="max-w-2xl">
        <form wire:submit="save" class="space-y-6">
            <div class="space-y-2">
                <flux:heading size="lg">Create a new post</flux:heading>
                <flux:subheading>
                    Add a well-structured post with validated plain-text content. Invalid or unsafe input is rejected before anything is saved.
                </flux:subheading>
            </div>

            @if ($errors->has('form'))
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200">
                    {{ $errors->first('form') }}
                </div>
            @endif

            <div class="grid gap-5 mb-5">
                <flux:input
                    wire:model.blur="title"
                    name="title"
                    label="Title"
                    type="text"
                    placeholder="Enter a concise, descriptive title"
                    maxlength="120"
                    autofocus
                />

                <div class="space-y-2">
                    <flux:textarea
                        wire:model.blur="content"
                        name="content"
                        label="Content"
                        rows="10"
                        placeholder="Write clear post content with at least 10 characters"
                    />

                </div>
            </div>

            <div class="flex items-center justify-between gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                
                <div class="flex items-center gap-2">
                    <flux:modal.close>
                        <flux:button variant="filled" type="button">
                            Cancel
                        </flux:button>
                    </flux:modal.close>

                    <flux:button variant="primary" type="submit" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">Create Post</span>
                        <span wire:loading wire:target="save">Creating...</span>
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>
