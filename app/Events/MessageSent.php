<?php

namespace App\Events;

use App\Models\LandbotMessage;

class MessageSent
{
    public $message;

    public function __construct(LandbotMessage $message)
    {
        $this->message = $message;
        $this->sendToAbly();
    }

    private function sendToAbly()
    {
        try {
            $data = [
                'name' => 'MessageSent',
                'data' => [
                    'message' => $this->message->toArray(),
                    'conversation_id' => $this->message->conversation_id,
                ]
            ];

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://rest.ably.io/channels/chat/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Authorization: Basic ' . base64_encode(env('ABLY_KEY')),
                    'Content-Type: application/json'
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 10,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 201) {
                error_log("Error enviando a Ably: HTTP $httpCode - $response");
            }

        } catch (\Exception $e) {
            error_log('Error en MessageSent: ' . $e->getMessage());
        }
    }
}