<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInput extends Component
{



    public $type;
    public $name;
    public $label;
    public $value;
    public $class;
    public $options;
    public $readonly;
    public $required;
    public $multiple;
    public $modal;

    public $disabled;
    public function __construct($type, $name, $label, $class, $value = null, $options = null, $multiple = null, $readonly = null, $required = null, $modal = null, $disabled = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->class = $class;
        $this->value = $value;
        $this->options = $options;
        $this->multiple = $multiple;
        $this->readonly = $readonly;
        $this->required = $required;
        $this->modal = $modal;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-input');
    }
}
