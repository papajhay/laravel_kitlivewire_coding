<div>
    <flux:modal name="view-post-modal" class="max-w-2xl">
        <div class="space-y-6">
            <div class="space-y-2">
                <flux:heading size="lg">View post</flux:heading>
                <flux:subheading>
                    Review the selected post without leaving the posts table.
                </flux:subheading>
            </div>

            <div class="space-y-5">
                <div class="space-y-2">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Title</p>
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800/70 dark:text-white">
                        {{ $title }}
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Content</p>
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm leading-6 whitespace-pre-wrap text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800/70 dark:text-zinc-200">
                        {{ $content }}
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end border-t border-zinc-200 pt-4 dark:border-zinc-700">
                <flux:modal.close>
                    <flux:button variant="filled" type="button">
                        Close
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
