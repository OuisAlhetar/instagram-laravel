<div>
    <a wire:click="toggle_like">
        @if ($post->liked(auth()->user()))
            <i class="bx bxs-heart text-red-600 text-3xl hover:text-gray-400 cursor-pointer ltr:mr-3 rtl:ml-3"></i>
        @else
            <i class="bx bx-heart text-3xl hover:text-gray-400 cursor-pointer ltr:mr-3 rtl:ml-3"></i>
        @endif
    </a>
</div>
