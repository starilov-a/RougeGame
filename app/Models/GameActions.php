<?php

namespace App\Models;

use App\Exceptions\GeneralTelegramExeption;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Log;

class GameActions
{
    public GameController $gameController;

    public function __construct(GameController $gameController){
        $this->gameController = $gameController;
    }

    public function roomsNearPlayer() {
        return $this->gameController->map->getFloor($this->gameController->player->getLvl())->getNearRoom($this->gameController->player);
    }
}
