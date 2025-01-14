<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GuiButton extends Component
{
    public $name, $target, $active, $class, $post, $inputs, $datas;

    /**
     * Create a new component instance.
     */
    public function __construct($target = '', $name = '', $active = '', $class = '', $post = '', $inputs = '', $datas = [])
    {
        $this->target = $target;
        $this->name = $name;
        $this->active = $active;
        $this->class = $class;
        $this->post = $post;
        $this->inputs = $inputs;
        $this->datas = $datas;
//        if (!empty($data)) dd($this->data);
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.gui-button');
    }
}
