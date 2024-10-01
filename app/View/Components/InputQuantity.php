<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputQuantity extends Component
{
    protected $stock;
    protected $id;
    protected $min;
    protected $max;

    /**
     * Create a new component instance.
     */
    public function __construct($id,$stock,$max,$min = 1)
    {
        $this->id = $id;
        $this->stock = $stock;
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-quantity', [
            'id' => $this->id,
            'stock' => $this->stock,
            'min' => $this->min,
            'max' => $this->max,
        ]);
    }
}
