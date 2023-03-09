<?php

namespace App\Models\Buttons;


//реализация шаблона Состояние
use App\Models\GameActions;
use App\Models\PlayerActions;
use App\Models\Words\Words;

abstract class ButtonsStates
{
    public static $action;
    protected $gameButtons;
    protected $buttons;
    protected $words;
    protected $playerActions;
    protected $gameActions;

    public function __construct($gameButtons, $gameController) {
        $this->gameButtons = $gameButtons;
        $this->buttons = new Buttons();
        $this->words = new Words();
        $this->playerActions = new PlayerActions($gameController);
        $this->gameActions = new GameActions($gameController);
    }

    abstract public function getMenu();

    abstract public function lastMenu();

    public function playerAction() {
        return false;
    }

    protected function getGameData() {
        return false;
    }
}
