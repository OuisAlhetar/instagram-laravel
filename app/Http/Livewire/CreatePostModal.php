<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class CreatePostModal extends ModalComponent
{
    use WithFileUploads;

    public $image;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function save_temp()
    {
        $this->validate([
            'image' => 'image:max:2048'
        ]);

        $image = $this->image->store('temp', 'public');
        $this->emit('openModal', 'filters-modal', ['image' => $image]);
    }

    public function render()
    {
        return view('livewire.create-post-modal');
    }
}
