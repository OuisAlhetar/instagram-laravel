<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Likedby extends Component
{
    public $post;

    protected $listeners = ['likeToggled' => 'getLikesProperty'];

    public function getLikesProperty()
    {
        return $this->post->likes()->count();
    }

    public function getFirstusernameProperty()
    {
        return $this->post->likes()->first()->username;
    }
    public function render()
    {
        return view('livewire.likedby');
    }
}
