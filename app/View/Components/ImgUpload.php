<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImgUpload extends Component
{
    /**
     * Create a new component instance.
     */
    public $imageUrl;
    public $name;
    public function __construct($imageUrl = null, $name = 'image')
    {
        $this->imageUrl = $imageUrl;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.img-upload');
    }
}
