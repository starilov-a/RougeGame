<?php

namespace App\Models\Buttons;


class MoveButtons extends ButtonsStates
{
    static $action = 'goRoom';

    public function getMenu() {
        //1.передача состояния
        $this->gameButtons->switchButtonsState('MainMenuButtons');
        //2.получение кнопок
        return $this->buttons->mainMenu();
    }

    public function returnMenu() {
        //1.передача состояния
        $this->gameButtons->switchButtonsState('MainMenuButtons');
        //2.получение кнопок
        return $this->buttons->mainMenu();
    }

    public function playerAction() {
        $message = $this->gameButtons->getMessage();
        $methodName = self::$action[$message]['menuMethod'];
        return $this->gameController->playerActions->$methodName($message);
    }
}
