@props(['label', 'name', 'type' => 'text', 'required' => false])

<div class="space-y-2">
    <label for="{{ $name }}"
        class="text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ $label }}</label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old('name') }}"
        @if ($required) required @endif autocomplete="{{ $name }}"
        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-zinc-500 dark:focus:ring-zinc-800"
        placeholder="{{ $label }}">

    @error($name)
        <p class="error">{{ $message }}</p>
    @enderror
</div>
