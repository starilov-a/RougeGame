<?php

namespace App\Models;


class GameButtons
{
    public $buttonsState = 'ActionButtons';
    protected $lastButtonsState = '';
    protected $message = '';

    public function __construct($message) {
        $this->message = $message;
    }

    public function getMenu($buttonsState) {
        if ($this->message == 'Назад') {
            return $buttonsState->returnMenu();
        }
        return $buttonsState->getMenu();
    }

    public function getMessage() {
        return $this->message;
    }

    public function switchButtonsState($newState) {
        $this->lastButtonsState = $this->buttonsState;
        $this->buttonsState = $newState;
    }

}
