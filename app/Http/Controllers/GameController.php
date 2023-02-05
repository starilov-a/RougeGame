<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralTelegramExeption;
use App\Models\Entitys\Player;
use App\Models\PlayerAction,
    App\Models\GameActions;
use App\Models\GameButtons,
    App\Models\Generators\CaseGenerator,
    App\Models\User;
use App\Models\Map\Map;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    protected $user;
    public $gameButtons;

    public Player $player;
    public Map $map;

    public $commands = [
        '/start',
        'Идти',
        'Атаковать',
        'Говорить',
        'Инвентарь',
        'Исследовать',
        'Назад',
    ];

    public function __construct(GameButtons $gameButtons, User $user){
        $this->gameButtons = $gameButtons;
        $this->user = $user;
    }

    public function staticCommand() {
        //Исключениее для новой игры
        //TODO найти другое решение
        if ($this->user->message == '/start') {
            $this->createGame();
            $message = 'Создана новая игра!';
            $messageBtn = $this->gameButtons->getMenu(new $this->gameButtons->buttonsState($this->gameButtons, $this));
            return [$message, $messageBtn];
        }

        $this->loadGame();

        //TODO добавить функционал сообщений для кнопок
        $message = 'Клик!';
        $messageBtn = $this->gameButtons->getMenu(new $this->gameButtons->buttonsState($this->gameButtons, $this));

        $this->saveGame();

        return [$message, $messageBtn];
    }

    public function customCommand() {
        //срабатывает при клике на рандомное значение
        $this->loadGame();
        $playerActions = new PlayerAction($this);

        $method = $this->gameButtons->buttonsState::$action;

        $message = $playerActions->$method();
        $messageBtn = $this->gameButtons->getMenu(new $this->gameButtons->buttonsState($this->gameButtons, $this));

        $this->saveGame();

        return [$message, $messageBtn];
    }

    protected function saveGame() {
        return $this->user->gameSession->saveSession($this->user->id, [
            'player' => $this->player,
            'map' => $this->map,
            'buttonsState' => $this->gameButtons->buttonsState,
        ]);
    }

    protected function loadGame() {
        $gameInfo = $this->user->gameSession->loadSession($this->user->id);
        $this->map = $gameInfo['map'];
        $this->player = $gameInfo['player'];
        $this->gameButtons->buttonsState = 'App\Models\Buttons\\'.$gameInfo['buttonsState'];
    }

    protected function createGame() {
        $generator = new CaseGenerator();
        $this->map = $generator->map->generate();
        $this->player = $generator->player->generate();
        $this->gameButtons->buttonsState = 'App\Models\Buttons\ActionButtons';
    }

}
