<?php

namespace App\Models\Buttons;


class ActionButtons extends ButtonsStates
{
    private $nextState = [
        '/start' => ['state' => 'ActionButtons', 'method' => 'mainMenu'],
        'Идти' => ['state' => 'MoveButtons', 'method' => 'moveMenu'],
        'Атаковать' => 'attackMenu',
        'Говорить' => 'sayMenu',
        'Инвентарь' => 'inventoryMenu',
        'Исследовать' => ['state' => 'ActionButtons', 'method' => 'mainMenu']
    ];
    public function getMenu($data) {

        $message = $this->gameButtons->getMessage();
        //1.передача состояния
        $this->gameButtons->switchButtonsState($this->nextState[$message]['state']);
        //2.получение кнопок
        $methodName = $this->nextState[$message]['method'];

        if($data !== false) {
            return $this->buttons->$methodName($data);
        } else {
            return $this->buttons->$methodName();
        }
    }
}
