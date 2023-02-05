<?php

namespace App\Http\Controllers;

use App\Models\Telegram\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function index(Request $request, GameController $gameController, Telegram $telegram) {
        $content = $request->getContent();
        //response('Hello World', 200);exit;
        $json = json_decode($content);


        $userMessage = '';
        if (isset($json->message)) {
            $userId = $json->message->from->id;
            $userMessage = $json->message->text;
        }

        $gameController->setMessage($userMessage);
        $gameController->setUserId($userId);



        //получение кнопок
        $message = '';
        list($message, $messageBtn) = isset($gameController->commands[$userMessage]) ? $gameController->staticAction() : $gameController->customAction();

        $telegram->sendMessage($userId, $message, $messageBtn);
    }
}
