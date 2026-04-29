<section class="w-full">
    <div class="mx-auto flex w-full max-w-7xl flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex flex-col gap-2">
                <flux:heading size="xl" level="1">Posts</flux:heading>
                <flux:subheading size="lg">Manage your posts with a dedicated creation modal and inline editing workflow.</flux:subheading>
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
                <div class="rounded-2xl border border-dashed border-zinc-300 bg-white/80 p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                    <flux:heading size="lg">Create Posts</flux:heading>
                    <flux:subheading class="mt-2">
                        Use the create button to open a focused modal with validation, plain-text protection, and a clearer submission flow.
                    </flux:subheading>
                </div>

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

            <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="mb-6 flex items-start justify-between gap-4">
                    <div>
                        <flux:heading size="lg">All Posts</flux:heading>
                        <flux:subheading>Latest posts are shown first.</flux:subheading>
                    </div>

                    <div class="rounded-full bg-zinc-100 px-3 py-1 text-sm font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                        {{ $posts->total() }} {{ \Illuminate\Support\Str::plural('post', $posts->total()) }}
                    </div>
                </div>

                @if ($posts->isEmpty())
                    <div class="rounded-xl border border-dashed border-zinc-300 px-6 py-12 text-center text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                        No posts have been created yet.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($posts as $post)
                            <article wire:key="post-{{ $post->id }}" class="rounded-xl border border-zinc-200 p-5 dark:border-zinc-700">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="min-w-0 flex-1">
                                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $post->title }}</h2>
                                        <p class="mt-1 text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                            Updated {{ $post->updated_at->diffForHumans() }}
                                        </p>
                                        <p class="mt-4 whitespace-pre-line text-sm leading-6 text-zinc-600 dark:text-zinc-300">{{ $post->content }}</p>
                                    </div>

                                    <div class="flex shrink-0 gap-2">
                                        <flux:button variant="filled" type="button" wire:click="editPost({{ $post->id }})">
                                            Edit
                                        </flux:button>

                                        <flux:button
                                            variant="danger"
                                            type="button"
                                            wire:click="deletePost({{ $post->id }})"
                                            wire:confirm="Delete this post?"
                                        >
                                            Delete
                                        </flux:button>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
