<x-app-layout>
    <div class="flex flex-row max-w-3xl gap-8 mx-auto">
        {{-- Left Side --}}
        <livewire:posts-list />
        {{-- Right Side --}}
        <div class="hidden w-[60rem] lg:flex lg:flex-col pt-4">
            <div class="flex flex-row text-sm">
                <div class="ltr:mr-5 rtl:ml-5">
                    <a href="/{{ auth()->user()->username }}">
                        <img src="{{ auth()->user()->image }}" alt=""
                             class="border border-gray-300 rounded-full h-12 w-12 object-cover">
                    </a>
                </div>
                <div class="flex flex-col">
                    <a href="/{{ auth()->user()->username }}" class="font-bold">
                        {{ auth()->user()->username }}
                    </a>
                    <div class="text-gray-500 text-sm">{{ auth()->user()->name }}</div>
                </div>
            </div>

            {{-- Suggested Users --}}
            <div class="mt-5">
                <h3 class="text-gray-500 font-bold">{{ __('Suggestions For You') }}</h3>
                <ul>
                    @foreach ($suggested_users as $suggested_user)
                        <li class="flex flex-row my-5 text-sm justify-items-center items-center">
                            <div class="ltr:mr-5 rtl:ml-5">
                                <a href="/{{ $suggested_user->username }}"></a>
                                <img src="{{ $suggested_user->image }}" class="rounded-full h-9 w-9 border border-gray-300">
                            </div>
                            <div class="flex flex-col grow">
                                <a href="/{{ $suggested_user->username }}" class="font-bold">
                                    {{ $suggested_user->username }}
                                    @if (auth()->user()->is_follower($suggested_user))
                                        <span class="text-xs text-gray-500">Follower</span>
                                    @endif
                                </a>
                                <div class="text-gray-500 text-sm">{{ $suggested_user->name }}</div>
                            </div>
                            @if (auth()->user()->is_pending($suggested_user))
                                <span class="text-gray-500 font-bold px-2">{{ __('Pending') }}</span>
                            @else
                                <livewire:follow-button :userId="$suggested_user->id" classes="text-blue-500" />
                            @endif

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
