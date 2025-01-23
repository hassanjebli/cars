<?php

namespace App\View\Components;

use Closure;
use App\Models\State;
use Illuminate\View\Component;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class SelectState extends Component
{
    public Collection $states;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->states = State::orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-state');
    }
}
