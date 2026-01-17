<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Chat extends Component
{
    public $userId;
    public $orderId;
    public function render()
    {
        return view('livewire.chat');
    }
}
