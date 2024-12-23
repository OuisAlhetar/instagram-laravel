<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostsList extends Component
{
    protected $listeners = ['toggleFollow' => '$refresh'];

    public function getPostsProperty()
    {
       $ids = auth()->user()->following()->wherePivot('confirmed', true)->get()->pluck('id');
       return Post::whereIn('user_id', $ids)->latest()->get();
    }

    public function render()
    {
        return view('livewire.posts-list');
    }
}
