<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DynamicTable extends Component
{
    /**
     * Create a new component instance.
     */

    public $headers;
    public $rows;
    public $route;

    public $excludeBtns;

    public $excludePagination;
    public function __construct($headers, $rows, $route, $excludeBtns = null, $excludePagination = false)
    {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->route = $route;
        $this->excludeBtns = $excludeBtns;
        $this->excludePagination = $excludePagination;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dynamic-table');
    }
}
