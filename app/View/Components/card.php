<?php

namespace App\View\Components;

use Closure;
use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class card extends Component
{
    public $created_at;
    /**
     * Create a new component instance.
     */
    public function __construct(public Ad $ad)
    {
        $this->created_at = Carbon::parse($ad->created_at)->diffForHumans();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
