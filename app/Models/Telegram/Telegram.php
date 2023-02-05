<?php

namespace App\Models\Telegram;

use Illuminate\Support\Facades\Log;

class Telegram
{
    private $webhook = 'https://api.telegram.org/bot5558278236:AAHI-LWRav9eV33TX1As37Fq34hXSq5zlRI/setWebhook?url=https://e6ea-5-149-159-46.eu.ngrok.io/webhook';
    private $url = 'https://api.telegram.org/bot';
    private $apikey;
    private $http;

    public function __construct($http ,$key) {
        $this->apikey = $key;
        $this->http = $http;
    }

    public function sendMessage($chatId, $message, $buttons = false) {
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html'
        ];
        if($buttons)
            $data['reply_markup'] = $buttons;

        return $this->http::post($this->url.$this->apikey.'/sendMessage', $data);
    }
}
