<?php

namespace App\Models;

use App\Exceptions\GeneralTelegramExeption;
use App\Http\Controllers\GameController;
use App\Models\Entitys\Player;
use App\Models\Map\Map;
use Illuminate\Support\Facades\Log;

class GameActions
{
    public GameController $gameController;

    public function __construct(GameController $gameController){
        $this->gameController = $gameController;
    }

    public function roomsNearPlayer() {
        $rooms = $this->gameController->map->getFloor($this->gameController->player->getLvl())->getNearRoom($this->gameController->player);
        return $rooms;
    }
}
