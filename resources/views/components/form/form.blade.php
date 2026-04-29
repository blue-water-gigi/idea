@props(['title', 'description'])

<section class="mx-auto w-full max-w-md">
    <div class="rounded-2xl border border-zinc-200 bg-white p-8 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="mb-8 space-y-2 text-center">
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-zinc-100">
                {{ $title }}
            </h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                {{ $description }}
            </p>
        </div>

        {{ $slot }}
    </div>
</section>
