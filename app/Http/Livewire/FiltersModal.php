<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use LivewireUI\Modal\ModalComponent;

class FiltersModal extends ModalComponent
{
    public $filters = ['Original', 'Clarendon', 'Gingham', 'Moon', 'Perpetua'];
    public $image;
    public $filtered_image;
    public $temp_images = [];
    public $description;
    protected $listeners = ['add_temp_image', 'modalClosed' => 'delete_temp_images'];

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }
    public static function dispatchCloseEvent(): bool
    {
        return true;
    }

    public function mount($image)
    {
        $this->image = $image;
        $this->filtered_image = $this->image;
        $this->add_temp_image($image);
    }

    public function filter_original()
    {
        $this->filtered_image = $this->image;
        $this->emit('add_temp_image', $this->filtered_image);
    }

    public function filter_clarendon()
    {
        $img = Image::make(storage_path('app/public') . DIRECTORY_SEPARATOR . $this->image)
            ->brightness(20)
            ->contrast(15)
            ->save(storage_path('app/public/temp') . DIRECTORY_SEPARATOR . Str::random(30) . '.jpeg');
        $this->filtered_image = 'temp' . DIRECTORY_SEPARATOR . $img->basename;
        $this->emit('add_temp_image', $this->filtered_image);
    }
    public function filter_moon()
    {
        $img = Image::make(storage_path('app/public') . DIRECTORY_SEPARATOR . $this->image)
            ->brightness(10)
            ->contrast(5)
            ->greyscale()
            ->save(storage_path('app/public/temp') . DIRECTORY_SEPARATOR . Str::random(30) . '.jpeg');
        $this->filtered_image = 'temp' . DIRECTORY_SEPARATOR . $img->basename;
        $this->emit('add_temp_image', $this->filtered_image);
    }

    public function filter_gingham()
    {
        $img = Image::make(storage_path('app/public') . DIRECTORY_SEPARATOR . $this->image)
            ->brightness(20)
            ->contrast(20)
            ->colorize(0, -10, -10)
            ->save(storage_path('app/public/temp') . DIRECTORY_SEPARATOR . Str::random(30) . '.jpeg');
        $this->filtered_image = 'temp' . DIRECTORY_SEPARATOR . $img->basename;
        $this->emit('add_temp_image', $this->filtered_image);
    }

    public function filter_perpetua()
    {
        $img = Image::make(storage_path('app/public') . DIRECTORY_SEPARATOR . $this->image)
            ->contrast(-10)
            ->colorize(-30, 10, 10)
            ->save(storage_path('app/public/temp') . DIRECTORY_SEPARATOR . Str::random(30) . '.jpeg');
        $this->filtered_image = 'temp' . DIRECTORY_SEPARATOR . $img->basename;
        $this->emit('add_temp_image', $this->filtered_image);
    }

    public function publish()
    {
        $this->validate([
            'description' => 'required',
        ]);

        $post_image = 'posts/' . Str::random(30) . '.jpeg';
        Storage::move('public/' . $this->filtered_image, 'public/' . $post_image);
        $post = auth()->user()->posts()->create([
            'description' => $this->description,
            'slug' => Str::random(10),
            'image' => $post_image
        ]);

        $this->forceClose()->closeModal();
    }

    public function add_temp_image($image)
    {
        array_push($this->temp_images, 'public/' . $image);
    }

    public function delete_temp_images()
    {
        Storage::delete($this->temp_images);
    }

    public function render()
    {
        return view('livewire.filters-modal');
    }
}
