<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Search extends Component
{
    public $searchInput = '';
    public $results = [];

    public function clear()
    {
       $this->reset('results');
       $this->reset('searchInput');
    }

    public function goto($username)
    {
        return redirect()->route('user_profile', ['user' => $username]);
    }

    public function render()
    {
        $this->results = [];
        $this->results = User::where('username', 'LIKE', '%' . $this->searchInput . '%')->get(['id', 'name', 'username', 'image']);
        return view('livewire.search', [
            'results' => $this->results
        ]);
    }
}
