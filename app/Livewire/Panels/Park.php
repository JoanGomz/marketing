<?php

namespace App\Livewire\Panels;

use Livewire\Component;

class Park extends Component
{
    public $centros=[];
    public function clear(){
        
    }
    public function render()
    {
        return view('livewire.panels.park');
    }
}
