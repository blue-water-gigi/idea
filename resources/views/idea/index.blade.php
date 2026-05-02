<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2">Capture your thoughts. Make a plan.</p>

            <x-card x-data @click="$dispatch('open-modal', 'create-idea')" is="button" type="button"
                class="mt-10 space-y-3 cursor-pointer h-32 w-full" data-test="create-idea-button">
                <p>
                    What's the idea?
                </p>
            </x-card>
        </header>

        <div>
            <a href="/ideas" class="btn {{ request()->has('status') ? 'btn-outlined' : '' }} ">All</a>

            @foreach (App\IdeaStatus::cases() as $status)
                <a href="/ideas?status={{ $status->value }}"
                    class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}">
                    {{ $status->label() }}
                    <span class="text-xs pl-3">
                        {{ $statusCounts->get($status->value) }}
                    </span>
                </a>
            @endforeach
        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse ($ideas as $idea)
                    <x-card href="ideas/{{ $idea->id }}">

                        @if ($idea->image_path)
                            <div class="mb-4 -mx-4 -mt-4 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $idea->image_path) }}" alt=""
                                    class="w-full h-48 object-cover">
                            </div>
                        @endif

                        <h3 class='text-foreground text-lg'>{{ $idea->title }}</h3>
                        <div class="mt-2">
                            <x-idea.status-label status="{{ $idea->status }}">
                                {{ $idea->status->label() }}
                            </x-idea.status-label>
                        </div>
                        <div class="mt-5 line-clamp-3">{{ $idea->description }}</div>
                        <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
                    </x-card>
                @empty
                    <x-card>
                        <p>No ideas yet.</p>
                    </x-card>
                @endforelse
            </div>
        </div>

        <!-- modal -->
        <x-modal name="create-idea" title="New idea">
            <form x-data="{
                status: 'pending',
                newLink: '',
                links: [],
                newStep: '',
                steps: []
            }" action="{{ route('idea.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <x-form.field autofocus label="Title" name="title" placeholder="Your idea title" required />

                    <div class="space-y-2">
                        <label for="status" class="label">Status</label>

                        <div class="felx gap-x-3">
                            @foreach (App\IdeaStatus::cases() as $status)
                                <button type="button" @click="status = @js($status->value)"
                                    class="btn flex-1 h-10 btn-outlined" data-test="status-button-{{ $status->value }}"
                                    :class="{ 'btn-outlined': status !== @js($status->value) }">
                                    {{ $status->label() }}
                                </button>
                            @endforeach

                            <input type="hidden" type="text" name="status" :value="status" class="input">
                        </div>

                        <x-form.error name="status" />

                    </div>

                    <x-form.field label="Description" name="description" type="textarea" placeholder="Describe it" />

                    <div class="space-y-2">
                        <label for="image" class="label">Featured image</label>
                        <input type="file" name="image" accept="image/*">
                        <x-form.error name="image" />
                    </div>

                    <div>
                        <fieldset class="space-y-3">
                            <legend class="label">
                                Actionable steps
                            </legend>

                            <template x-for="(step, index) in steps" :key="step">
                                <div class="flex gap-x-2 items-center">
                                    <input type="text" name="steps[]" class="input" x-model="step">

                                    <button type="button" @click="steps.splice(index, 1)" class="form-muted-icon">
                                        <x-icons.delete />
                                    </button>

                                </div>
                            </template>

                            <div class="flex gap-x-2 items-center">
                                <input x-model="newStep" type="url" id="new-step" data-test="new-step"
                                    placeholder="What needs to be done?" class="input flex-1" spellcheck="false">
                                <button :disabled="newStep.trim() === 0" type="button"
                                    @click="steps.push(newStep.trim()); newStep=''" class="form-muted-icon"
                                    data-test="submit-new-step-button">
                                    <x-icons.add />
                                </button>
                            </div>

                        </fieldset>
                    </div>

                    <div>
                        <fieldset class="space-y-3">
                            <legend class="label">
                                Links
                            </legend>

                            <template x-for="(link, index) in links" :key="link">
                                <div class="flex gap-x-2 items-center">
                                    <input type="url" name="links[]" class="input" x-model="link">

                                    <button type="button" @click="links.splice(index, 1)" class="form-muted-icon">
                                        <x-icons.delete />
                                    </button>

                                </div>
                            </template>

                            <div class="flex gap-x-2 items-center">
                                <input x-model="newLink" type="url" id="new-link" data-test="new-link"
                                    placeholder="http://example.com" autocomplete="url" class="input flex-1"
                                    spellcheck="false">
                                <button :disabled="newLink.trim() === 0" type="button"
                                    @click="links.push(newLink.trim()); newLink=''" class="form-muted-icon"
                                    data-test="submit-new-link-button">
                                    <x-icons.add />
                                </button>
                            </div>

                        </fieldset>
                    </div>

                    <div class="flex justify-end gap-x-5">
                        <button @click="$dispatch('close-modal')" type="button"
                            class="btn btn-outlined">Cancel</button>
                        <button type="submit" class="btn">Create</button>
                    </div>

                </div>

            </form>
        </x-modal>
    </div>
</x-layout>
