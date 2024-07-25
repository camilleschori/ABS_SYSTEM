<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * Create a new component instance.
     */
    public $sub1;
    public $sub2;
    public $sub1url;
    public $sub2url;
    public function __construct($sub1, $sub2 = null, $sub1url = null, $sub2url = null)
    {
        //
        $this->sub1 = $sub1;
        $this->sub2 = $sub2;
        $this->sub1url = $sub1url;
        $this->sub2url = $sub2url;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
