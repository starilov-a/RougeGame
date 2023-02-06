<?php

namespace App\Http\Controllers;

use App\Models\GameButtons,
    App\Models\Telegram\Telegram,
    App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function index(Request $request, Telegram $telegram) {
        $json = json_decode($request->getContent());

        $userMessage = '';
        $userId = '';
        if (isset($json->message)) {
            $userId = $json->message->from->id;
            $userMessage = $json->message->text;
        }
        //$telegram->sendMessage($userId, '2020');exit;
        $gameController = new GameController(new GameButtons($userMessage), new User($userId, $userMessage));

        //получение кнопок
        $message = '';
        $messageBtn = [];
        list($message, $messageBtn) = $gameController->pushButton();

        $telegram->sendMessage($userId, $message, $messageBtn);
    }
}
