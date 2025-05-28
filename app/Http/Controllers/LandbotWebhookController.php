<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandbotMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LandbotWebhookController extends Controller
{
    /**
     * Maneja las notificaciones entrantes de Landbot
     */
    public function handleWebhook(Request $request)
    {
        // Log de datos recibidos
        Log::info('Webhook de Landbot recibido', ['data' => $request->all()]);
        
        try {
            // Extraer datos
            $data = $request->all();
            
            if (empty($data)) {
                return response()->json(['success' => false, 'message' => 'No se recibieron datos'], 400);
            }
            
            // Procesar los datos según la estructura de Landbot
            $chatId = $data['chat_id'] ?? uniqid('chat-');
            $customerId = $data['customer_id'] ?? null; // Usando chat_id como customer_id
            $customerPhone = $data['customer_phone'] ?? null;
            $messageContent = $data['message_chat'] ?? 'Sin mensaje';
            $isFirstMessage = $data['is_first_message'] ?? 0;
            $isRobot = $data['is_robot'] ?? 0;
            $exist = $data['exist'] ?? 0;
            
            // Determinar el tipo de remitente
            $senderType = $isRobot ? 'bot' : 'customer';
            if ($isFirstMessage) {
                $senderType = 'first_message';
            }
            
            // Generar un message_id único basado en el chat_id y timestamp
            $messageId = $chatId . '_' . time() . '_' . uniqid();
            
            // Preparar datos para guardar
            $messageData = [
                'customer_id' => $customerId,
                'message_id' => $messageId,
                'content' => $messageContent,
                'sender_type' => $senderType,
                'message_timestamp' => Carbon::now(),
                'raw_data' => json_encode($data),
                'conversation_data' => $messageContent,
                'customer_phone' => $customerPhone,
                'conversation_date' => Carbon::now(),
                'chat_id' => $chatId,
                'is_first_message' => (bool)$isFirstMessage,
                'is_robot' => (bool)$isRobot,
                'exist' => (bool)$exist
            ];
            
            // Verificar si ya existe un mensaje similar reciente (evitar duplicados)
            $recentMessage = LandbotMessage::where('chat_id', $chatId)
                ->where('content', $messageContent)
                ->where('created_at', '>=', Carbon::now()->subMinutes(2))
                ->first();
            
            if ($recentMessage) {
                Log::info('Mensaje duplicado detectado, actualizando existente', ['chat_id' => $chatId]);
                $recentMessage->update([
                    'raw_data' => json_encode($data),
                    'message_timestamp' => Carbon::now()
                ]);
                return response()->json(['success' => true, 'action' => 'updated']);
            }
            
            // Guardar nuevo mensaje
            $newMessage = LandbotMessage::create($messageData);
            Log::info('Nuevo mensaje guardado', [
                'id' => $newMessage->id,
                'chat_id' => $chatId,
                'sender_type' => $senderType
            ]);
            
            return response()->json([
                'success' => true,
                'action' => 'created',
                'message_id' => $messageId
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error procesando webhook de Landbot', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Endpoint de prueba para verificar que el webhook funciona
     */
    public function test()
    {
        return response()->json([
            'success' => true,
            'message' => 'El endpoint del webhook está configurado correctamente',
            'timestamp' => now()->toIso8601String(),
            'server_time' => now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Obtener historial de conversación por chat_id
     */
    public function getConversationHistory($customerPhone)
    {
        try {
            $messages = LandbotMessage::where('customer_phone', $customerPhone)
                ->orderBy('message_timestamp', 'asc')
                ->get();
            
            return response()->json([
                'success' => true,
                'chat_id' => $chatId,
                'messages' => $messages,
                'total_messages' => $messages->count()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}