<?php

namespace App\Models\Map;


class Map implements ViewInterface
{
    private $floors;
    private $playerLvl = 0;

    public function __construct(array $attributes = []) {
        $this->floors = $attributes['floors'];
    }

    public function getView() {
        return $this->floors[$this->playerLvl]->getView();
    }

    public function getInfo() {

    }

    public function getFloor($lvl) {
        return $this->floors[$lvl];
    }

    public function getRoomsNearPlayer($player) {
        return $this->getFloor($player->getLvl())->getNearRoom($player);
    }
}
