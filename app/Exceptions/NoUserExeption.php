<?php

namespace App\Exceptions;


use App\Models\Telegram\Telegram;

class NoUserExeption extends GeneralTelegramExeption
{
    protected $message = 'Такого юзера не существует';

    public function report() {

    }

    public function render(Telegram $telegram) {
        $telegram->sendMessage($this->message() . ' (ОШИБКА)');
    }
}
