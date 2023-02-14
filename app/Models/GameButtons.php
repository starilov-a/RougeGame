<?php

namespace App\Models;


class GameButtons
{
    public $stateString = 'MainMenuButtons';
    public $state;
    protected $message = '';

    public function __construct($message) {
        $this->message = $message;
    }

    public function getMenu() {
        if ($this->message == 'Назад') {
            return $this->state->returnMenu();
        }
        return $this->state->getMenu();
    }

    public function playerAction() {
        return $this->state->playerAction();
    }

    public function getMessage() {
        return $this->message;
    }

    public function switchButtonsState($newState) {
        $this->stateString = $newState;
    }

}
