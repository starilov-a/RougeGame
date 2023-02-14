<?php

namespace App\Models\Buttons;


use App\Models\GameActions;

class MainMenuButtons extends ButtonsStates
{
    static $action = [
        '/start' => ['state' => 'MainMenuButtons', 'menuMethod' => 'mainMenu'],
        'Идти' => ['state' => 'MoveButtons', 'menuMethod' => 'moveMenu', 'gameMethod' => 'roomsNearPlayer', 'wordMethod' => 'whereGo'],
        'Атаковать' => 'attackMenu',
        'Говорить' => 'sayMenu',
        'Инвентарь' => 'inventoryMenu',
        'Исследовать' => ['state' => 'MainMenuButtons', 'menuMethod' => 'mainMenu', 'playerMethod' => 'checkMap', 'wordMethod' => 'viewMap']
    ];

    public function getMenu() {
        $message = $this->gameButtons->getMessage();
        //1.передача состояния
        $this->gameButtons->switchButtonsState(self::$action[$message]['state']);
        //2.получение кнопок
        $data = $this->getGameData();
        $methodName = self::$action[$message]['menuMethod'];
        if($data !== false) {
            return $this->buttons->$methodName($data);
        } else {
            return $this->buttons->$methodName();
        }
    }

    public function returnMenu() {
        //1.передача состояния
        $this->gameButtons->switchButtonsState('MainMenuButtons');
        //2.получение кнопок
        return $this->buttons->mainMenu();
    }

    protected function getGameData() {
        if (isset(self::$action[$this->gameButtons->getMessage()]['gameMethod'])) {
            $gameMethod = self::$action[$this->gameButtons->getMessage()]['gameMethod'];
            return $this->gameActions->$gameMethod();
        }
        return false;
    }

    public function playerAction() {
        if (isset(self::$action[$this->gameButtons->getMessage()]['playerMethod'])){
            $methodName = self::$action[$this->gameButtons->getMessage()]['playerMethod'];
            $text = '';
            if (isset(self::$action[$this->gameButtons->getMessage()]['wordMethod'])) {
                $wordMethod = self::$action[$this->gameButtons->getMessage()]['wordMethod'];
                $text =  $this->words->$wordMethod();
            }
            return $text . $this->playerActions->$methodName();
        }
        return false;
    }
}
