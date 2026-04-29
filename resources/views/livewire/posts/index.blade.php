<section class="w-full">
    <div class="mx-auto flex w-full max-w-7xl flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="space-y-2">
                <flux:heading size="xl" level="1">Posts</flux:heading>
                <flux:subheading size="lg">
                    Manage your posts in a clean table with simple pagination and inline actions.
                </flux:subheading>
            </div>

            <livewire:posts.create-post />
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-6 xl:grid-cols-[24rem_minmax(0,1fr)]">
            <div class="space-y-6">

                @if ($postId)
                    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                        <div class="mb-6">
                            <flux:heading size="lg">Edit Post</flux:heading>
                            <flux:subheading>Update the selected post and save your changes.</flux:subheading>
                        </div>

                        <form wire:submit="save" class="space-y-5">
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

                            <div class="flex flex-wrap items-center gap-3">
                                <flux:button variant="primary" type="submit">
                                    Update Post
                                </flux:button>

                                <flux:button variant="filled" type="button" wire:click="cancelEditing">
                                    Cancel
                                </flux:button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
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
                    <flux:table container:class="w-full">
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
                                                size="sm"
                                                type="button"
                                                wire:click="editPost({{ $post->id }})"
                                            >
                                                Edit
                                            </flux:button>

                                            <flux:button
                                                variant="danger"
                                                size="sm"
                                                type="button"
                                                wire:click="deletePost({{ $post->id }})"
                                                wire:confirm="Delete this post?"
                                            >
                                                Delete
                                            </flux:button>
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
        </div>
    </div>
</section>
