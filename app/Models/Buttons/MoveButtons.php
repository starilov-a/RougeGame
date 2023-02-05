<?php

namespace App\Models\Buttons;


class MoveButtons extends ButtonsStates
{
    public function getMenu($data) {
        //1.передача состояния
        $this->gameButtons->switchButtonsState('ActionButtons');
        //2.получение кнопок
        return $this->buttons->mainMenu();
    }
}
