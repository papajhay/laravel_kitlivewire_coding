<div>
    <flux:modal name="edit-post-modal" :show="$errors->isNotEmpty()" focusable class="max-w-2xl">
        <form wire:submit="update" class="space-y-6">
            <div class="space-y-2">
                <flux:heading size="lg">Edit post</flux:heading>
                <flux:subheading>
                    Update the selected post without leaving the current page.
                </flux:subheading>
            </div>

            @if ($errors->has('form'))
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-200">
                    {{ $errors->first('form') }}
                </div>
            @endif

            <div class="grid gap-5">
                <flux:input
                    wire:model.blur="title"
                    name="title"
                    label="Title"
                    type="text"
                    placeholder="Post title"
                    autofocus
                />

                <flux:textarea
                    wire:model.blur="content"
                    name="content"
                    label="Content"
                    rows="10"
                    placeholder="Write the post content here..."
                />
            </div>

            <div class="flex items-center justify-end gap-2 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                <flux:modal.close>
                    <flux:button variant="filled" type="button">
                        Cancel
                    </flux:button>
                </flux:modal.close>

                <flux:button variant="primary" type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="update">Save Changes</span>
                    <span wire:loading wire:target="update">Saving...</span>
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
