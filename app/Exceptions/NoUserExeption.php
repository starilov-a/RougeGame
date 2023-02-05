<?php

namespace App\Exceptions;


class NoUserExeption extends GeneralTelegramExeption
{
    protected $message = 'Такого юзера не существует';
}
