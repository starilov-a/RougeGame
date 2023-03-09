<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralTelegramExeption;
use App\Models\Entitys\Player,
    App\Models\GameActions,
    App\Models\PlayerActions,
    App\Models\GameButtons,
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

    public function __construct(GameButtons $gameButtons, User $user){
        $this->gameButtons = $gameButtons;
        $this->user = $user;

    }

    public function index() {
        //Исключениее для новой игры
        //TODO найти другое решение
        if ($this->user->message == '/start') {
            $this->createGame();
            $message = 'Создана новая игра!';
            $messageBtn = $this->gameButtons->getMenu();
            $this->saveGame();
            return [$message, $messageBtn];
        }

        $this->loadGame();
        $playerActionMsg = $this->playerAction();
        $worldMsg = $this->worldTic();

        //Получение сообщения - добавить функционал получения сообщений
        $message = $playerActionMsg . $worldMsg;
        //Получение кнопки
        $messageBtn = $this->gameButtons->getMenu();

        $this->saveGame();
        return [$message, $messageBtn];
    }

    protected function playerAction() {
        if ($this->user->message != 'Назад')
            return $this->gameButtons->playerAction();
        return 'Назад';
    }

    protected function worldTic() {

    }

    protected function saveGame() {
        return $this->user->gameSession->saveSession($this->user->id, [
            'player' => $this->player,
            'map' => $this->map,
            'buttonsState' => $this->gameButtons->stateString,
        ]);
    }

    protected function loadGame() {
        $gameInfo = $this->user->gameSession->loadSession($this->user->id);
        $this->map = $gameInfo['map'];
        $this->player = $gameInfo['player'];
        $buttinStateNamespace = '\App\Models\Buttons\\'.$gameInfo['buttonsState'];
        $this->gameButtons->state = new $buttinStateNamespace($this->gameButtons, $this);
    }

    protected function createGame() {
        $generator = new CaseGenerator();
        $this->map = $generator->map->generate();
        $this->player = $generator->player->generate();
        $this->gameButtons->state = new \App\Models\Buttons\MainMenuButtons($this->gameButtons, $this);
    }
}
