<?php

namespace App\View\Components;

use App\Models\ProductImages;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditProductImage extends Component
{

    protected ProductImages $image;

    public function __construct(ProductImages $image)
    {
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.edit-product-image', [
            'image' => $this->image,
        ]);
    }
}
