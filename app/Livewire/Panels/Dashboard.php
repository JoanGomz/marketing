<?php

namespace App\Livewire\Panels;

use App\Http\Controllers\Operation\DashboardController;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $cantUsers = app(DashboardController::class)->countActiveUsers();
        $cantConversations = app(DashboardController::class)->getConversationsStats();
        return view('livewire.panels.dashboard',[
            'users' => $cantUsers,
            'cant_conversations' => $cantConversations 
        ]);
    }
}
