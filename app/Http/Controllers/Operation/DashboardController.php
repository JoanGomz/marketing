<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\LandbotConversations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function countActiveUsers()
    {
        $count_user = User::where('status', 1)->count();

        return $this->responseLivewire('success', 'succes', $count_user);
    }

    public function getConversationsStats()
    {
        try {
            $totalConversations = LandbotConversations::count();

            $conversationsByPark = DB::table('landbot_conversations as lc')
                ->join('users as u', 'lc.user_asing_id', '=', 'u.id')
                ->join('parks as p', 'u.parks_id', '=', 'p.id')
                ->select(
                    'p.id as parque_id',
                    'p.name as parque_nombre',
                    DB::raw('COUNT(lc.id) as total_conversaciones')
                )
                ->whereNotNull('lc.user_asing_id')
                ->groupBy('p.id', 'p.name')
                ->orderBy('total_conversaciones', 'desc')
                ->get();

            $data = [
                'total_conversaciones' => $totalConversations,
                'conversaciones_por_sede' => $conversationsByPark
            ];

            return $this->responseLivewire('success', 'success', $data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
