<div class="w-[30rem] mx-auto lg:w-[95rem]">
    @forelse ($this->posts as $post)
        <livewire:post :post="$post" :wire:key="'post_'.$post->id"/>
    @empty
        <div class="max-w-2xl gap-8 mx-auto">
            {{ __('Start Following Your Friends and Enjoy.') }}
        </div>
    @endforelse
</div>
