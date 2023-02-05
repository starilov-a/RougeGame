<?php

namespace App\Models;


class GameButtons
{
    public $buttonsState = 'ActionButtons';
    protected $lastButtonsState = '';
    protected $message = '';

    public function getMenu($buttonsState, $data = false) {
        return $buttonsState->getMenu($data);
    }

    public function setMessage ($message) {
        $this->message = $message;
    }

    public function getMessage() {
        return $this->message;
    }

    public function switchButtonsState($newState) {
        $this->lastButtonsState = $this->buttonsState;
        $this->buttonsState = $newState;
    }

}
