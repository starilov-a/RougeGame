<?php

namespace App\Models\Buttons;


class MoveButtons extends ButtonsStates
{
    public function getMenu($data) {
        $message = $this->gameButtons->getMessage();
        if($message == 'Назад') {
            return $this->buttons->mainMenu();
        }
        //1.передача состояния
        $this->gameButtons->switchButtonsState('ActionButtons');
        //2.получение кнопок
        return $this->buttons->mainMenu();
    }

    public function returnMenu() {
        //1.передача состояния
        $this->gameButtons->switchButtonsState('ActionButtons');
        //2.получение кнопок
        return $this->buttons->mainMenu();
    }
}
