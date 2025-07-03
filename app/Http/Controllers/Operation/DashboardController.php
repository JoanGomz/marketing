<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use App\Models\LandbotConversations;
use App\Models\LandbotMessage;
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

    /**
     * Obtiene las estadísticas de conversaciones
     * @return \Illuminate\Http\JsonResponse
     */
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

            $chartData = [
                'labels' => $conversationsByPark->pluck('parque_nombre')->toArray(),
                'series' => $conversationsByPark->pluck('total_conversaciones')->toArray()
            ];

            $data = [
                'total_conversaciones' => $totalConversations,
                'conversaciones_por_sede' => $conversationsByPark,
                'chart_data' => $chartData
            ];

            return $this->responseLivewire('success', 'success', $data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene las estadísticas de eventos solicitados
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStacticsEvents()
    {
        try {
            //fiesta cumpleaños
            $happyBirthdayCount = LandbotMessage::where('conversation_data', 'LIKE', '%Fiesta Cumplea%')
                ->where('author_type', 'cliente')
                ->count();

            //Eventos Corporativos
            $corporateEventsCount = LandbotMessage::where('conversation_data', 'LIKE', '%Eventos corporativos%')
                ->where('author_type', 'cliente')
                ->count();

            //Evento de colegios
            $schoolEventsCount = LandbotMessage::where('conversation_data', 'LIKE', '%Evento de colegios%')
                ->where('author_type', 'cliente')
                ->count();

            //Evento de conjuntos
            $communityEventsCount = LandbotMessage::where('conversation_data', 'LIKE', '%Evento de conjuntos%')
                ->where('author_type', 'cliente')
                ->count();

            // Preparar datos para ApexCharts
            $eventLabels = [
                'Fiesta Cumpleaños',
                'Eventos Corporativos',
                'Evento de Colegios',
                'Evento de Conjuntos'
            ];

            $eventCounts = [
                $happyBirthdayCount,
                $corporateEventsCount,
                $schoolEventsCount,
                $communityEventsCount
            ];

            // Formato para gráfico de dona/pie
            $pieChartData = [
                'labels' => $eventLabels,
                'series' => $eventCounts
            ];

            // Formato para gráfico de barras
            $barChartData = [
                'categories' => $eventLabels,
                'series' => [
                    [
                        'name' => 'Eventos Solicitados',
                        'data' => $eventCounts
                    ]
                ]
            ];

            $data = [
                'happy_birthday' => $happyBirthdayCount,
                'corporate_events' => $corporateEventsCount,
                'school_events' => $schoolEventsCount,
                'community_events' => $communityEventsCount,
                'total_events' => array_sum($eventCounts),
                'pie_chart' => $pieChartData,
                'bar_chart' => $barChartData
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
