<?php

namespace App\Services;

use App\Events\conversationUpdate;
use App\Events\MessageSent;
use App\Models\LandbotConversations;
use App\Models\LandbotMessage;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LandbotService extends BaseService
{
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => env('LANDBOT_API_URL'),
            'headers' => [
                'Content-Type' => env('LANDBOT_CONTENT_TYPE'),
                'Authorization' => 'token ' . env('LANDBOT_API_KEY')
            ],
            'timeout' => 50,
            'http_errors' => false,
            'verify' => storage_path('certificates/cacert.pem')
        ]);
    }

    /**
     * Procesa los datos del webhook de Landbot
     */
    public function processWebhookData(array $data): string
    {
        try {
            if (empty($data)) {
                throw new \Exception('No se recibieron datos');
            }

            $messageData = $data['messages'][0];
            $phoneWithoutCountryCode = substr($messageData['customer']['phone'], 2);
            $messageData['customer']['phone'] = $phoneWithoutCountryCode;

            DB::beginTransaction();
            $conversation = $this->saveConversation($messageData);
            $messageId = $this->saveMessage($messageData, $conversation);
            DB::commit();

            return $messageId;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Guarda o encuentra una conversación
     */
    public function saveConversation(array $data): LandbotConversations
    {
        $conversation = LandbotConversations::where('landbot_chat_id', $data['_raw']['chat'])->first();

        if (!$conversation) {
            $conversation = LandbotConversations::create([
                'nombre' => $data['customer']['name'],
                'telefono' => $data['customer']['phone'],
                'landbot_chat_id' => $data['_raw']['chat'],
                'landbot_customer_id' => $data['customer']['id'],
                'status' => 'pendiente'
            ]);

            if (!$conversation) {
                Log::error('Error al guardar la conversación', ['data' => $data]);
                throw new \Exception('No se pudo guardar la conversación');
            }
        }

        return $conversation;
    }

    /**
     * Guarda un mensaje
     */
    public function saveMessage(array $data, LandbotConversations $conversation): string
    {
        $chatId = $data['_raw']['chat'];
        $messageId = $chatId . '_' . time() . '_' . uniqid();

        $this->createNewMessage($data, $conversation, $messageId);

        // Enviar mensaje si es del usuario de nuestro sistema
        if ($data['_raw']['author_type'] == 'usuario') {
            $this->sendTextMessage($data, $conversation);
        }

        return $messageId;
    }


    /**
     * Crea un nuevo mensaje
     */
    private function createNewMessage(array $data, LandbotConversations $conversation, string $messageId): LandbotMessage
    {
        $messageData = [
            'message_id' => $messageId,
            'message_timestamp' => Carbon::now(),
            'raw_data' => json_encode($data),
            'conversation_data' => $data['data'],
            'customer_phone' => $data['customer']['phone'],
            'conversation_date' => Carbon::now(),
            'landbot_chat_id' => $data['_raw']['chat'],
            'author_type' => $data['_raw']['author_type'] == 'user' ? 'cliente' : $data['_raw']['author_type'],
            'conversation_id' => $conversation->id,
        ];

        $newMessage = LandbotMessage::create($messageData);
        broadcast(new MessageSent($newMessage));

        Log::info('Nuevo mensaje guardado', [
            'id' => $newMessage->id,
            'landbot_chat_id' => $data['_raw']['chat'],
        ]);

        $conversation->updated_at = Carbon::now();
        if ($data['_raw']['author_type'] == 'user') {
            $conversation->status = 'pendiente';
        }
        $conversation->save();

        return $newMessage;
    }

    /**
     * Envía mensaje de texto a través de Landbot
     */
    public function sendTextMessage(array $data, LandbotConversations $conversation): void
    {
        $payload = [
            "message" => $data['data']['body']
        ];

        $response = $this->httpClient->post("v1/customers/{$conversation->landbot_customer_id}/send_text/", [
            'json' => $payload
        ]);

        if ($response->getStatusCode() == 412) {
            Log::error('Error al enviar mensaje a Landbot', [
                'status_code' => $response->getStatusCode(),
                'body' => (string)$response->getBody()
            ]);
            throw new \Exception('No se pueden enviar mensajes por WhatsApp 24h después del último mensaje del cliente');
        }

        if ($response->getStatusCode() !== 200) {
            Log::error('Error al enviar mensaje a Landbot', [
                'status_code' => $response->getStatusCode(),
                'body' => (string)$response->getBody()
            ]);
            throw new \Exception('Error al enviar mensaje: ' . (string)$response->getBody());
        }
    }

    /**
     * Obtiene el historial de conversación
     */
    public function getConversationHistory(int $conversationId): array
    {
        $messages = LandbotMessage::where('conversation_id', $conversationId)
            ->orderBy('message_timestamp', 'asc')
            ->get();

        return [
            'conversation_id' => $conversationId,
            'messages' => $messages,
            'total_messages' => $messages->count()
        ];
    }

    /**
     * Obtiene todas las conversaciones con filtros
     */
    public function getAllConversations(?string $status = null, ?int $userAsingId = null, ?string $search = null)
    {
        $query = LandbotConversations::with([
            'lastMessage:id,conversation_id,conversation_data',
            'client:id,nombre'
        ]);

        if ($status) {
            $query->where('status', $status);
        }

        if ($userAsingId) {
            $query->where('user_asing_id', $userAsingId);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('telefono', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('updated_at', 'desc')->get();
    }

    /**
     * Guarda una nota en la conversación
     */
    public function saveNote(int $conversationId, string $note): LandbotConversations
    {
        if (empty($note)) {
            throw new \Exception('Nota no puede estar vacía');
        }

        $conversation = LandbotConversations::findOrFail($conversationId);
        $conversation->notas = $note;
        $conversation->save();

        return $conversation;
    }

    /**
     * Cambia el estado de una conversación
     */
    public function changeConversationStatus(int $conversationId, string $status): void
    {
        if (empty($status)) {
            throw new \Exception('Estado no puede estar vacío');
        }

        $conversation = LandbotConversations::findOrFail($conversationId);
        $conversation->status = $status;

        if ($status == 'finalizado') {
            $conversation->is_assigned = 0;
            $conversation->user_asing_id = null;
        }

        $conversation->save();
    }

    /**
     * Reinicia el bot para una conversación
     */
    public function restartBot(int $conversationId): string
    {
        $conversation = LandbotConversations::findOrFail($conversationId);
        $botId = env('LANDBOT_BOT_ID');

        $response = $this->httpClient->put("v1/customers/{$conversation->landbot_customer_id}/assign_bot/{$botId}/", [
            'json' => ["launch" => true]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error al reiniciar el bot: ' . (string)$response->getBody());
        }

        return (string)$response->getBody();
    }

    /**
     * Asigna un usuario a una conversación
     */
    public function assignUserToConversation(int $conversationId, int $userId): void
    {
        if (empty($userId)) {
            throw new \Exception('ID de usuario no puede estar vacío');
        }

        $conversation = LandbotConversations::findOrFail($conversationId);
        $conversation->user_asing_id = $userId;
        $conversation->is_assigned = 1;
        $conversation->save();

        event(new conversationUpdate());
    }

    /**
     * Desasigna usuarios de conversaciones activas
     */
    public function unassignUsers(): void
    {
        $conversations = LandbotConversations::where('is_assigned', 1)
            ->where('status', '!=', 'finalizada')
            ->get();

        foreach ($conversations as $conversation) {
            $conversation->user_asing_id = null;
            $conversation->is_assigned = 0;
            $conversation->save();
        }
    }
}
