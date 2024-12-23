<div class="h-[50rem] lg:flex lg:flex-row overflow-y-auto">
    {{-- Left Side --}}
    <div class="flex h-1/2 lg:h-full items-center justify-center overflow-hidden bg-black lg:w-8/12">
        <img class="h-full w-auto object-cover" src="http://localhost:8000/storage/{{ $post->image }}">
    </div>

    {{-- Right Side --}}
    <div class="lg:w-4/12 flex flex-col bg-white p-5">
        <div class="flex flex-row items-center">
            <div>
                <img src="{{ auth()->user()->image }}" class="w-10 h-10 mr-2 rounded-full border border-neutral-300">
            </div>
            <div class="flex flex-col">
                <div class="font-bold">
                    <a href="/{{ auth()->user()->username }}">{{ auth()->user()->username }}</a>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <textarea placeholder="{{ __('Write description...') }}" wire:model="description"
                class="ring-none border-none h-64 w-full mb-2 rounded"></textarea>
            @error('description')
            <span class="text-sm text-red-500 py-5">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-auto">
            <x-button class="w-full justify-center" wire:click="update">{{ __('Update') }}</x-button>
        </div>
    </div>
</div>