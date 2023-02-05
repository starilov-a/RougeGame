<?php

namespace App\Models\Buttons;


//реализация шаблона Состояние
abstract class ButtonsStates
{
    public static $action;
    protected $gameButtons;
    protected $buttons;
    protected $gameController;

    public function __construct($gameButtons, $gameController) {
        $this->gameButtons = $gameButtons;
        $this->gameController = $gameController;
        $this->buttons = new Buttons();
    }

    abstract public function getMenu();

    abstract public function returnMenu();
}
