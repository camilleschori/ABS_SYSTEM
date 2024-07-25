<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    


    public $action;
    public $method;
    public $back;

    public function __construct($action , $method , $back)
    {
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->back = $back;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form');
    }
}
