@props(['idea' => new App\Models\Idea()])


<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}" title="{{ $idea->exists ? 'Edit idea' : 'New idea' }}">
    <form x-data="{
        status: @js(old('status', $idea->status?->value)),
        newLink: '',
        links: @js(old('links', $idea->links ?? [])),
        newStep: '',
        ssteps: @js(old('steps', $idea->steps?->map->only(['id', 'description', 'completed']) ?? []))
    }" action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf

        @if ($idea->exists)
            @method('PATCH')
        @endif

        <div class="space-y-6">
            <x-form.field autofocus label="Title" name="title" placeholder="Your idea title" required
                :value="$idea->title" />

            <div class="space-y-2">
                <label for="status" class="label">Status</label>

                <div class="flex gap-x-3">
                    @foreach (App\IdeaStatus::cases() as $status)
                        <button type="button" @click="status = @js($status->value)"
                            class="btn flex-1 h-10" data-test="status-button-{{ $status->value }}"
                            :class="status === @js($status->value) ? 'btn-primary' : 'btn-outlined'">
                            {{ $status->label() }}
                        </button>
                    @endforeach

                    <input type="hidden" name="status" :value="status" class="input">
                </div>

                <x-form.error name="status" />

            </div>

            <x-form.field label="Description" name="description" type="textarea" placeholder="Describe it"
                :value="$idea->description" />

            <div class="space-y-2">
                <label for="image" class="label">Featured image</label>

                @if ($idea->image_path)
                    <div class="space-y-2">
                        <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}"
                            class="w-full h-48 object-cover rounded-lg">

                        <button class="btn btn-outlined h-10 w-full" form="delete-image-form">Remove image</button>
                    </div>
                @endif

                <input type="file" name="image" accept="image/*">
                <x-form.error name="image" />
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legend class="label">
                        Actionable steps
                    </legend>
            
                    <template x-for="(step, index) in steps" :key="step.id || index">
                        <div class="flex gap-x-2 items-center">
                            <input type="text" :name="`steps[${index}][description]`" class="input"
                                   x-model="step.description">
                            <input type="hidden" :name="`steps[${index}][completed]`"
                                   :value="step.completed ? '1' : '0'">
            
                            <button type="button" @click="steps.splice(index, 1)" class="form-muted-icon">
                                <x-icons.delete />
                            </button>
                        </div>
                    </template>
            
                    <div class="flex gap-x-2 items-center">
                        <input x-model="newStep" type="text" id="new-step" data-test="new-step"
                               placeholder="What needs to be done?" class="input flex-1" spellcheck="false">
                        <button :disabled="newStep.trim() === ''" type="button"
                                @click="steps.push({description: newStep.trim(), completed: false}); newStep=''"
                                class="form-muted-icon" data-test="submit-new-step-button">
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

                    {{-- <template x-for="(link, index) in links" :key="link"> --}}
                    <template x-for="(link, index) in links" :key="index">
                        <div class="flex gap-x-2 items-center">
                            {{-- <input type="url" name="links[]" class="input" x-model="link"> --}}
                            <input type="url" name="links[]" class="input" x-model="links[index]">
                            <button type="button" @click="links.splice(index, 1)" class="form-muted-icon">
                                <x-icons.delete />
                            </button>

                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center">
                        <input x-model="newLink" type="url" id="new-link" data-test="new-link"
                            placeholder="http://example.com" autocomplete="url" class="input flex-1" spellcheck="false">
                        {{-- <button :disabled="newLink.trim() === 0" type="button" --}}
                        <button :disabled="newLink.trim() === ''" type="button"
                            @click="links.push(newLink.trim()); newLink=''" class="form-muted-icon"
                            data-test="submit-new-link-button">
                            <x-icons.add />
                        </button>
                    </div>

                </fieldset>
            </div>

            <div class="flex justify-end gap-x-5">
                <button @click="$dispatch('close-modal')" type="button" class="btn btn-outlined">Cancel</button>
                <button data-test="upd-or-crt-button" type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>
            </div>

        </div>

    </form>

    @if ($idea->image_path)
        <form action="{{ route('idea.image.destroy', $idea) }}" method="POST" id="delete-image-form" class="">
            @csrf
            @method('DELETE')
        </form>
    @endif

</x-modal>
