<?php

namespace App\Models\Buttons;


use Illuminate\Support\Facades\Log;

class MoveButtons extends ButtonsStates
{
    static $action = 'goRoom';

    public function getMenu() {
        //1.передача состояния
        $this->gameButtons->switchButtonsState('MainMenuButtons');
        //2.получение кнопок
        return $this->buttons->mainMenu();
    }

    public function lastMenu() {
        //1.передача состояния
        $this->gameButtons->switchButtonsState('MainMenuButtons');
        //2.получение кнопок
        return $this->buttons->mainMenu();
    }

    public function playerAction() {
        $methodName = self::$action;
        return $this->playerActions->$methodName($this->gameButtons->getMessage());
    }
}
