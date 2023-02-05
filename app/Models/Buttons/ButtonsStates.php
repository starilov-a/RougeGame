<?php

namespace App\Models\Buttons;


//реализация шаблона Состояние
abstract class ButtonsStates
{
    protected $gameButtons;
    protected $buttons;

    public function __construct($gameButtons) {
        $this->gameButtons= $gameButtons;
        $this->buttons = new Buttons();
    }

    abstract public function getMenu($data);
}
