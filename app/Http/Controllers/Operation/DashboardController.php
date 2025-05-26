<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function countActiveUsers()
    {
        $count_user = User::where('status', 1)->count();

        return $this->responseLivewire('success', 'succes', $count_user);
    }
}
