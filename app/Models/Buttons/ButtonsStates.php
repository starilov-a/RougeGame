<?php

namespace App\Models\Buttons;


//реализация шаблона Состояние
use App\Models\GameActions;
use App\Models\PlayerActions;

abstract class ButtonsStates
{
    public static $action;
    protected $gameButtons;
    protected $buttons;
    protected $gameActions;
    protected $playerActions;

    public function __construct($gameButtons, $gameController) {
        $this->gameButtons = $gameButtons;
        $this->buttons = new Buttons();
        $this->gameActions = new GameActions($gameController);
        $this->playerActions = new PlayerActions($gameController);
    }

    abstract public function getMenu();

    abstract public function returnMenu();

    public function playerAction() {
        return false;
    }

    protected function getGameData() {
        return false;
    }
}
