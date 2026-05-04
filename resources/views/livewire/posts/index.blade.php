<section class="w-full">
    <div class="mx-auto flex w-full max-w-7xl flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="space-y-2">
                <flux:heading size="xl" level="1">Posts</flux:heading>
                <flux:subheading size="lg">
                    Manage your posts in a clean table with simple pagination and modal-based editing.
                </flux:subheading>
            </div>

            <livewire:posts.create-post />
        </div>

        <livewire:posts.view-post />
        <livewire:posts.edit-post />

            <div >
                @if ($posts->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto max-w-md rounded-2xl border border-dashed border-zinc-300 px-6 py-10 dark:border-zinc-700">
                            <p class="text-base font-medium text-zinc-900 dark:text-white">No posts found.</p>
                            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                                Create a new post to populate the table.
                            </p>
                        </div>
                    </div>
                @else
                    <flux:table>
                        <flux:table.columns class="bg-zinc-50/80 dark:bg-zinc-800/60">
                            <flux:table.column>Title</flux:table.column>
                            <flux:table.column>Content</flux:table.column>
                            <flux:table.column align="end">Actions</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @foreach ($posts as $post)
                                <flux:table.row :key="$post->id" class="transition hover:bg-zinc-50/80 dark:hover:bg-zinc-800/50">
                                    <flux:table.cell variant="strong">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                                                {{ $post->title }}
                                            </p>
                                        </div>
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        <p class="max-w-2xl whitespace-normal text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                                            {{ \Illuminate\Support\Str::limit($post->content, 180) }}
                                        </p>
                                    </flux:table.cell>

                                    <flux:table.cell align="end">
                                        <div class="flex flex-col items-stretch gap-2 sm:flex-row sm:justify-end">
                                            <flux:button
                                                variant="filled"
                                                icon="eye"
                                                size="sm"
                                                type="button"
                                                aria-label="View post"
                                                title="View post"
                                                wire:click="viewPost({{ $post->id }})"
                                            />

                                            <flux:button
                                                variant="filled"
                                                icon="pencil-square"
                                                size="sm"
                                                type="button"
                                                aria-label="Edit post"
                                                title="Edit post"
                                                wire:click="editPost({{ $post->id }})"
                                            />

                                            <flux:button
                                                variant="danger"
                                                icon="trash"
                                                size="sm"
                                                type="button"
                                                aria-label="Delete post"
                                                title="Delete post"
                                                wire:click="confirmDeletePost({{ $post->id }})"
                                            />
                                        </div>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>

                        <x-slot:footer>
                            <div class="border-t border-zinc-200 px-5 py-4 dark:border-zinc-700">
                                <flux:pagination :paginator="$posts" />
                            </div>
                        </x-slot:footer>
                    </flux:table>
                @endif
            </div>

        <flux:modal name="delete-post-modal" class="max-w-md">
            <div class="space-y-6">
                <div class="space-y-2">
                    <flux:heading size="lg">Delete post</flux:heading>
                    <flux:subheading>
                        Are you sure you want to delete this post?
                    </flux:subheading>
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-zinc-200 pt-4 dark:border-zinc-700">
                    <flux:modal.close>
                        <flux:button variant="filled" type="button">
                            Cancel
                        </flux:button>
                    </flux:modal.close>

                    <flux:button
                        variant="danger"
                        type="button"
                        wire:click="deletePost"
                        wire:loading.attr="disabled"
                        wire:target="deletePost"
                    >
                        <span wire:loading.remove wire:target="deletePost">Delete</span>
                        <span wire:loading wire:target="deletePost">Deleting...</span>
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</section>
