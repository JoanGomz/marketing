<?php

namespace App\Livewire\Panels;

use App\Http\Controllers\Operation\DashboardController;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $cantUsers = app(DashboardController::class)->countActiveUsers();
        return view('livewire.panels.dashboard',[
            'users' => $cantUsers
        ]);
    }
}
