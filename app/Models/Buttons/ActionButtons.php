<?php

namespace App\Models\Buttons;


use App\Models\GameActions;

class ActionButtons extends ButtonsStates
{
    static $action = [
        '/start' => ['state' => 'ActionButtons', 'menuMethod' => 'mainMenu'],
        'Идти' => ['state' => 'MoveButtons', 'menuMethod' => 'moveMenu', 'actionMethod' => 'roomsNearPlayer'],
        'Атаковать' => 'attackMenu',
        'Говорить' => 'sayMenu',
        'Инвентарь' => 'inventoryMenu',
        'Исследовать' => ['state' => 'ActionButtons', 'menuMethod' => 'mainMenu']
    ];

    public function getMenu() {
        $message = $this->gameButtons->getMessage();
        //1.передача состояния
        $this->gameButtons->switchButtonsState(self::$action[$message]['state']);
        //2.получение кнопок
        $data = $this->getData();
        $methodName = self::$action[$message]['menuMethod'];
        if($data !== false) {
            return $this->buttons->$methodName($data);
        } else {
            return $this->buttons->$methodName();
        }
    }

    public function returnMenu() {
        //1.передача состояния
        $this->gameButtons->switchButtonsState('ActionButtons');
        //2.получение кнопок
        return $this->buttons->mainMenu();
    }

    protected function getData() {
        if (isset(self::$action[$this->gameButtons->getMessage()]['actionMethod'])) {
            $gameActions = new GameActions($this->gameController);
            $gameMethod = self::$action[$this->gameButtons->getMessage()]['actionMethod'];
            return $gameActions->$gameMethod();
        }
        return false;
    }
}
