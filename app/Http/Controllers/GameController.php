<?php

namespace App\Http\Controllers;

use App\Models\Entitys\Player;
use App\Models\GameButtons,
    App\Models\GameSession,
    App\Models\Buttons\ActionButtons,
    App\Models\Generators\CaseGenerator;
use App\Models\Map\Map;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    protected $userId;
    protected $gameSession;
    protected $gameButtons;

    public Player $player;
    public Map $map;

    public $commands = [
        '/start' => 'newGame',
        'Идти' => 'menuGoRoom',
        'Атаковать',
        'Говорить',
        'Инвентарь',
        'Исследовать' => 'checkMap',//Временно
        'Назад' => 'menuReturn'
    ];

    public function __construct(GameSession $gameSession, GameButtons $gameButtons){
        $this->gameSession = $gameSession;
        $this->gameButtons = $gameButtons;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setMessage($message) {
        $this->gameButtons->setMessage($message);
    }

    public function staticAction() {

        if ($this->gameButtons->getMessage() != '/start')
            $this->loadGame();

        $methodName = $this->commands[$this->gameButtons->getMessage()];
        $messageResponse = $this->$methodName();
        $this->saveGame();

        return $messageResponse;
    }

    public function customAction() {
        $this->loadGame();
        switch ($this->gameButtons->buttonsState) {
            case('App\Models\Buttons\MoveButtons'):
                $messageResponse = $this->goRoom();
                break;
            default:
                $messageResponse = 'Error';
        }
        $this->saveGame();

        return $messageResponse;
    }

    protected function newGame() {
        //Создание игровой сессии
        $generator = new CaseGenerator();
        $this->map = $generator->map->generate();
        $this->player = $generator->player->generate();

        $message = 'Игра Создана!';
        $messageBtn = $this->gameButtons->getMenu(new ActionButtons($this->gameButtons));

        return [$message, $messageBtn];
    }

    protected function menuGoRoom() {

        $rooms = $this->map->getFloor($this->player->getLvl())->getNearRoom($this->player);

        $message = 'Хмм, куда бы пойти?';
        $messageBtn = $this->gameButtons->getMenu(new $this->gameButtons->buttonsState($this->gameButtons), $rooms);

        return [$message, $messageBtn];
    }

    protected function menuSearch() {
        //Получение нужных комнат
        $toRoom = $this->map->getFloor($this->player->getLvl())->getRoomByTitle($this->gameButtons->getMessage());
        $fromRoom = $this->map->getFloor($this->player->getLvl())->getRoom($this->player);
        //движение в указанную комнату и получение ответа
        $message = $this->player->goRoom($fromRoom, $toRoom);
        $messageBtn = $this->gameButtons->getMenu(new $this->gameButtons->buttonsState($this->gameButtons));

        return [$message, $messageBtn];
    }

    protected function menuReturn() {
        //Возрат состояния кнопок
        $message = 'Нажал назад';
        $messageBtn = $this->gameButtons->getMenu(new $this->gameButtons->buttonsState($this->gameButtons));

        return [$message, $messageBtn];
    }

    protected function checkMap() {
        $message = "Вы раскрыли карту\r\n\r\n";
        $message .= $this->map->getView();

        $messageBtn = $this->gameButtons->getMenu(new $this->gameButtons->buttonsState($this->gameButtons));

        return [$message, $messageBtn];
    }

    protected function goRoom() {
        //Получение нужных комнат
        $toRoom = $this->map->getFloor($this->player->getLvl())->getRoomByTitle($this->gameButtons->getMessage());
        $fromRoom = $this->map->getFloor($this->player->getLvl())->getRoom($this->player);
        //движение в указанную комнату и получение ответа
        $message = $this->player->goRoom($fromRoom, $toRoom);
        $messageBtn = $this->gameButtons->getMenu(new $this->gameButtons->buttonsState($this->gameButtons));

        return [$message, $messageBtn];
    }

    protected function saveGame() {
        return $this->gameSession->saveSession($this->userId, [
            'player' => $this->player,
            'map' => $this->map,
            'buttonsState' => $this->gameButtons->buttonsState,
        ]);
    }

    protected function loadGame() {
        $gameInfo = $this->gameSession->loadSession($this->userId);
        $this->map = $gameInfo['map'];
        $this->player = $gameInfo['player'];
        $this->gameButtons->buttonsState = 'App\Models\Buttons\\'.$gameInfo['buttonsState'];
    }

}
