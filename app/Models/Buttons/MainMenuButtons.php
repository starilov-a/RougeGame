<?php

namespace App\Models\Buttons;


use App\Models\GameActions;
use Illuminate\Support\Facades\Log;

class MainMenuButtons extends ButtonsStates
{
    static $action = [
        '/start' => ['nextState' => 'MainMenuButtons', 'menuMethod' => 'mainMenu'],
        'Идти' => ['nextState' => 'MoveButtons', 'menuMethod' => 'moveMenu', 'gameMethod' => 'roomsNearPlayer', 'wordMethod' => 'whereGo'],
        'Атаковать' => 'attackMenu',
        'Говорить' => 'sayMenu',
        'Инвентарь' => 'inventoryMenu',
        'Исследовать' => ['nextState' => 'MainMenuButtons', 'menuMethod' => 'mainMenu', 'playerMethod' => 'checkMap', 'wordMethod' => 'viewMap']
    ];

    public function getMenu() {
        $message = $this->gameButtons->getMessage();
        //1.передача состояния
        $this->gameButtons->switchButtonsState(self::$action[$message]['nextState']);
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
        $text = '';

        if (isset(self::$action[$this->gameButtons->getMessage()]['wordMethod'])) {
            $wordMethod = self::$action[$this->gameButtons->getMessage()]['wordMethod'];
            $text .= $this->words->$wordMethod();
        }

        if (isset(self::$action[$this->gameButtons->getMessage()]['playerMethod'])){
            $methodName = self::$action[$this->gameButtons->getMessage()]['playerMethod'];
            $text .= $this->playerActions->$methodName();
        }

        return $text;
    }
}
