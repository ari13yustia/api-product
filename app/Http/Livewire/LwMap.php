<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LwMap extends Component
{
    public $long, $lat;
    public function render()
    {
        return view('livewire.lw-map');
    }
}
