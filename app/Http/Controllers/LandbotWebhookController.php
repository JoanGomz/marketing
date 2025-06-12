<?php

namespace App\Http\Controllers;

use App\Models\LandbotConversations;
use Illuminate\Http\Request;
use App\Models\LandbotMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
            $data = $request->all();
            if (empty($data)) {
                return response()->json(['success' => false, 'message' => 'No se recibieron datos'], 400);
            }
            $data = $data['messages'][0];
            $phoneWithoutCountryCode = substr($data['customer']['phone'], 2);
            $data['customer']['phone'] = $phoneWithoutCountryCode;
            DB::beginTransaction();
            $newConversarion = $this->saveConversation($data);
            $response = $this->saveMessage($data, $newConversarion);
            DB::commit();
            return $this->responseLivewire('success', 'success', $response);
        } catch (\Exception $e) {
            DB::rollBack();
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

    public function saveConversation($data)
    {
        $conversation = LandbotConversations::where('landbot_chat_id', $data['_raw']['chat'])->first();
        if (!$conversation) {
            $conversation = new LandbotConversations();
            $conversation->nombre = $data['customer']['name'];
            $conversation->telefono = $data['customer']['phone'];
            $conversation->landbot_chat_id = $data['_raw']['chat'];
            $conversation->status = 'pendiente';
            if (!$conversation->save()) {
                Log::error('Error al guardar la conversación', ['data' => $data]);
                throw new \Exception('No se pudo guardar la conversación');
            }
        }

        return $conversation;
    }

    /**
     * Endpoint de prueba para verificar que el webhook funciona
     */
    public function saveMessage($data, $conversation)
    {
        // Procesar los datos según la estructura de Landbot
        $chatId = $data['_raw']['chat'];
        $messageContent = $data['data'];
        $messageId = $chatId . '_' . time() . '_' . uniqid();  // Generar un message_id único basado en el chat_id y timestamp

        // Preparar datos para guardar
        $messageData = [
            // 'customer_id' => $customerId,
            'message_id' => $messageId,
            'message_timestamp' => Carbon::now(),
            'raw_data' => json_encode($data),
            'conversation_data' => $messageContent,
            'customer_phone' => $data['customer']['phone'],
            'conversation_date' => Carbon::now(),
            'landbot_chat_id' => $chatId,
            'author_type' => $data['_raw']['author_type'] == 'user' ? 'cliente' : $data['_raw']['author_type'],
            'conversation_id' => $conversation->id,
        ];

        // Verificar si ya existe un mensaje similar reciente (evitar duplicados)
        $recentMessage = LandbotMessage::where('landbot_chat_id', $chatId)
            ->where('conversation_data', $messageContent)
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
            'landbot_chat_id' => $chatId,
        ]);

        $conversation->updated_at = Carbon::now();
        $conversation->status = 'pendiente';
        $conversation->save();

        return $messageId;
    }

    /**
     * Obtener historial de conversación por conversation_id
     */
    public function getConversationHistory($conversation_id)
    {
        try {
            $messages = LandbotMessage::where('conversation_id', $conversation_id)
                ->orderBy('message_timestamp', 'asc')
                ->get();

            $response = [
                'conversation_id' => $conversation_id,
                'messages' => $messages,
                'total_messages' => $messages->count()
            ];
            return $this->responseLivewire('success', 'success', $response);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener todas las conversaciones
     */
    public function getAllConversations($status = null)
    {
        try {
            // Incluir siempre: id, foreign_key, y los campos que necesitas
            $query = LandbotConversations::with(['lastMessage:id,conversation_id,conversation_data']);

            if ($status) {
                $query->where('status', $status);
            }

            $conversations = $query->orderBy('updated_at', 'desc')->get();

            return $this->responseLivewire('success', 'success', $conversations);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function saveNote(Request $request, $conversationId)
    {
        try {
            $note = $request->input('note');
            if (empty($note)) {
                return response()->json(['success' => false, 'message' => 'Nota no puede estar vacía'], 400);
            }

            $conversation = LandbotConversations::findOrFail($conversationId);
            $conversation->note = $note;
            $conversation->save();

            return $this->responseLivewire('success', 'Nota guardada correctamente', []);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function changeStatusConversation(Request $request, $conversationId)
    {
        try {
            $status = $request->input('status');
            if (empty($status)) {
                return response()->json(['success' => false, 'message' => 'Estado no puede estar vacío'], 400);
            }

            $conversation = LandbotConversations::findOrFail($conversationId);
            $conversation->status = $status;
            $conversation->save();

            return $this->responseLivewire('success', 'Estado de la conversación actualizado correctamente', []);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
