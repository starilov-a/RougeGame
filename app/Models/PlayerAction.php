<?php

namespace App\Models;

use App\Http\Controllers\GameController;
use App\Models\Entitys\Player;
use App\Models\Map\Map;
use Illuminate\Support\Facades\Log;

class PlayerAction
{
    public GameController $gameController;

    public function __construct(GameController $gameController){
        $this->gameController = $gameController;
    }

    public function checkMap() {
        $message = "Вы раскрыли карту\r\n\r\n";
        $message .= $this->gameController->map->getView();

        return $message;
    }

    public function goRoom() {
        //Получение нужных комнат
        $toRoom = $this->gameController->map->getFloor($this->gameController->player->getLvl())->getRoomByTitle($this->gameController->gameButtons->getMessage());
        $fromRoom = $this->gameController->map->getFloor($this->gameController->player->getLvl())->getRoom($this->gameController->player);
        //движение в указанную комнату и получение ответа
        $message = "Вы вошли в " . $this->gameController->player->goRoom($fromRoom, $toRoom);

        return $message;
    }
}
