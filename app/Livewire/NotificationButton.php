<?php

namespace App\Livewire;

use App\Models\Ad;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationButton extends Component
{
    public $notificationButton;

    #[On('formsubmit')]
    public function mount()
    {
        $this->notificationButton = Ad::where('is_accepted', false)->where('user_id','!=',auth()->user()->id)->count();
    }

    public function render()
    {
        return view('livewire.notification-button');
    }
}
