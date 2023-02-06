<?php

namespace App\Models;

use App\Http\Controllers\GameController;
use App\Models\Entitys\Player;
use App\Models\Map\Map;
use Illuminate\Support\Facades\Log;

class PlayerActions
{
    public Player $player;
    public Map $map;

    public function __construct(GameController $gameController){
        $this->player = $gameController->player;
        $this->map = $gameController->map;
    }

    public function checkMap() {
        $message = "Вы раскрыли карту\r\n\r\n";
        $message .= $this->map->getView();

        return $message;
    }

    public function goRoom($titleRoom) {
        //Получение нужных комнат
        $toRoom = $this->map->getFloor($this->player->getLvl())->getRoomByTitle($titleRoom);
        $fromRoom = $this->map->getFloor($this->player->getLvl())->getRoom($this->player);
        //движение в указанную комнату и получение ответа
        $message = "Вы вошли в " . $this->player->goRoom($fromRoom, $toRoom);

        return $message;
    }
}
