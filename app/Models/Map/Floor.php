<?php

namespace App\Models\Map;


class Floor implements ViewInterface
{
    protected $lvl;
    protected $rooms;
    protected $schemaFloor;

    public function __construct(array $attributes = []) {
        $this->lvl = $attributes['lvl'];
        $this->rooms = $attributes['rooms'];
        $this->schemaFloor = $attributes['schemaFloor'];

        $this->createRoomLinks($attributes['schemaFloor']);
    }

    public function getRoomByTitle($title) {
        foreach ($this->rooms as $room)
            if($room->getTitle() == $title)
                return $room;
    }

    public function getRoom($item) {
        return $this->rooms[$item->getCurrentRoom()];
    }

    public function getNearRoom($item) {
        $rooms = [];
        $roomIds = $this->rooms[$item->getCurrentRoom()]->getNeighbour();
        foreach ($roomIds as $id)
            $rooms[] =  $this->rooms[$id];
        return $rooms;
    }

    public function getView() {
        $stringMap = '';
        foreach ($this->schemaFloor as $rowsRooms){
            foreach ($rowsRooms as $room){
                if(!is_null($room))
                    $stringMap .= $this->rooms[$room]->getView();
                else
                    $stringMap .= "0";
            }
            $stringMap .= "\r\n";
        }
        return $stringMap;
    }

    //связь между комнатами
    public function createRoomLinks($map) {
        //поиск соседей
        foreach ($map as $x => $itemsY) {
            foreach ($itemsY as $y => $idRoom) {
                if(!empty($idRoom) || $idRoom === 0){
                    //установка соседей
                    if(!empty($map[$x+1][$y]))
                        $this->rooms[$map[$x][$y]]->setNeighbour($this->rooms[$map[$x+1][$y]]);
                    if(!empty($map[$x][$y+1]))
                        $this->rooms[$map[$x][$y]]->setNeighbour($this->rooms[$map[$x][$y+1]]);
                    if(!empty($map[$x-1][$y]))
                        $this->rooms[$map[$x][$y]]->setNeighbour($this->rooms[$map[$x-1][$y]]);
                    if(!empty($map[$x][$y-1]))
                        $this->rooms[$map[$x][$y]]->setNeighbour($this->rooms[$map[$x][$y-1]]);
                }
            }
        }
    }
}
