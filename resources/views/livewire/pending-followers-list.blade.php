<div class="max-h-64 overflow-y-auto">
    <ul>
        @forelse(auth()->user()->pending_followers as $pending)
            <li class="flex flex-row w-full p-3 items-center text-sm" wire:key="user-{{ $pending->id }}">
                <div>
                    <img src="{{ $pending->image }}" class="w-10 h-10 ltr:mr-2 rtl:ml-2 rounded-full border border-neutral-300">
                </div>
                <div class="flex flex-col grow">
                    <div class="font-bold">
                        <a href="/{{ $pending->username }}">{{ $pending->username }}</a>
                    </div>
                    <div class="text-sm text-neutral-500">
                        {{ $pending->name }}
                    </div>
                </div>
                @auth
                    <div>
                        <button class="bg-blue-500 border border-blue-500 text-white px-2 py-1 rounded"
                                wire:click="confirm({{ $pending->id }})">{{ __('Confirm') }}</button>
                        <button class="border border-gray-500 px-2 py-1 rounded"
                                wire:click="delete({{ $pending->id }})">{{ __('Delete') }}</button>
                    </div>
                @endauth
            </li>
        @empty
            <li class="w-full p-3 text-center">
                {{ __('There are no pending requests.') }}
            </li>
        @endforelse
    </ul>
</div>
