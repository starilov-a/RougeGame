<?php

namespace App\Exceptions;

use App\Models\Telegram\Telegram;
use Exception;


class GeneralTelegramExeption extends Exception
{
    public function report() {

    }

    public function render(Telegram $telegram) {
        $telegram->sendMessage($this->message());
    }
}
