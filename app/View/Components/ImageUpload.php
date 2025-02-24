<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageUpload extends Component
{
    public $hasData;
    public $name;
    public $route;
    public $class;
    /**
     * Create a new component instance.
     */
    public function __construct($hasData = null, $name = 'avatar', $route = null, $class = 'image-preview')
    {
        $this->hasData = $hasData;
        $this->name = $name;
        $this->class = $class;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-upload');
    }
}
