<?php

namespace App\Models\Map;

use Illuminate\Database\Eloquent\Model;

class Room extends Model implements ViewInterface
{
    public $id;

    protected $type;
    protected $alias = 'd';

    protected $title;
    protected $isVisited = false;
    protected $neightbour = [];
    protected $coords = [];

    public function __construct(array $attributes = []) {
        $this->id = $attributes['id'];
        $this->title = $attributes['title'];
        if($this->id === 0)
            $this->playerVisited();
    }

    public function getTitle() {
        return $this->title;
    }

    public function setNeighbour($room) {
        $this->neightbour[] = $room->id;
    }

    public function getNeighbour() {
        return $this->neightbour;
    }

    public function setCoords($x,$y) {
        $this->coords = [$x,$y];
    }

    public function getView() {
        if ($this->active)
            return 'x';
        elseif ($this->isVisited)
            return $this->alias;
        else
            return "?";
    }

    public function playerExit() {
        $this->active = false;
    }

    public function playerVisited() {
        $this->isVisited = true;
        $this->active = true;
    }
}
