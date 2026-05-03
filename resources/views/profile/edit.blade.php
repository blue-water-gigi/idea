<x-layout>
    <x-form title="Edit your account" description="Need some changes?">
        <form method="POST" action="/profile" class="space-y-5">
            @csrf
            @method('PATCH')

            <x-form.field name="name" label="Name" :value="$user->name"/>
            <x-form.field name="email" label="Email" type="email" :value="$user->email"/>
            <x-form.field name="password" label="New password" type="password" />

            <button type="submit"
                class="inline-flex w-full items-center justify-center rounded-xl bg-zinc-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-400 focus-visible:ring-offset-2 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200 dark:focus-visible:ring-zinc-600 dark:focus-visible:ring-offset-zinc-900">
                Update Account
            </button>
        </form>
    </x-form>
</x-layout>
