<?php

namespace App\Models\Entitys;

use App\Models\Interfaces\PlayerInterface;

class Player implements PlayerInterface
{
    protected $name = 'player';
    protected $abilities = [];
    protected $items = [];
    protected $characteristics = [];
    protected $hiddenStats = [];
    protected $currentRoom = 0;
    protected $lvl = 0;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getLvl() {
        return $this->lvl;
    }

    protected function exitRoom($room) {
        $room->playerExit();
    }

    public function getCurrentRoom() {
        return $this->currentRoom;
    }

    public function goRoom($fromRoom, $toRoom) {
        $this->exitRoom($fromRoom);
        $this->currentRoom = $toRoom->id;
        $toRoom->playerVisited();

        return $toRoom->getTitle();
    }

    public function goFloor()
    {
        // TODO: Implement goFloor() method.
    }

    public function attack() {

    }

    public function takeDamage()
    {
        // TODO: Implement takeDamage() method.
    }

    public function useItem($item) {
        $item->use();
    }

    public function takeItem($item) {

    }

    public function dropItem($item)
    {
        // TODO: Implement dropItem() method.
    }

    public function say($to) {

    }
    public function answer() {

    }

    public function giveInfo()
    {
        // TODO: Implement giveInfo() method.
    }

    public function getInfo($about) {

    }
}
