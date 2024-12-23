<div>
    <li class="flex flex-col md:flex-row text-center">
        <div class="ltr:md:mr-1 rtl:md:ml-1 font-bold md:font-normal">
            {{ $this->count }}
        </div>
        <button onclick="Livewire.emit('openModal', 'followers-modal', {{ json_encode(['userId' => $userId]) }})"
                class='text-neutral-500 md:text-black'>
            {{ $this->user->followers()->count() > 1 ? __('followers') : __('follower') }}
        </button>
    </li>

</div>
