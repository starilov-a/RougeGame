<?php

namespace App\Models\Generators;

use Illuminate\Database\Eloquent\Model,
    App\Models\Map\Room,
    App\Models\Map\Map,
    App\Models\Map\Floor,
    \Generator;
use Nette\Utils\Random;

class GeneratorMap extends Model implements GeneratorInterface
{
    private $seed;
    private $countLvls = 1;
    private $sizeFoor = ['height' => 4, 'weight' => 4];
    private $rooms;
    private $floors;

    //TODO разделение генераторов

    public function generate() {
        $this->rooms = $this->generateRooms();
        $this->floors = $this->generateFloors($this->rooms);
        return new Map(['floors' =>$this->floors]);
    }

    //Генератор комнат
    protected function generateRooms() {
        for ($lvl=0;$lvl<$this->countLvls;$lvl++) {
            $count = $this->generateCountRooms($lvl);
            for($i=0;$i<$count;$i++)
                $rooms[$lvl][$i] = new Room(['id' => $i, 'title' => 'Комната_'.$i]);
        }
        return $rooms;
    }

    //Генератор кол-ва комнат
    protected function generateCountRooms($lvl) {
        return $countRoom = 5; //random(1,2) + 5 + $lvl * 2.6;
    }

    //Генератор уровня
    protected function generateFloors($rooms) {
        //для каждого уровня
        for ($lvl=0;$lvl<$this->countLvls;$lvl++) {
            //заполняем null;
            $schemaFloor = array_fill(0, $this->sizeFoor['height'], null);
            foreach ($schemaFloor as $id => $items)
                $schemaFloor[$id] = array_fill(0, $this->sizeFoor['weight'], null);
            //заполняем первую комнату

            $floorRooms = $rooms[$lvl];

            //заполняем первую комнату
            $h = rand(0,$this->sizeFoor['height']);
            $w = rand(0,$this->sizeFoor['weight']);
            $schemaFloor[$w][$h] = $floorRooms[0]->id;
            $rooms[$lvl][0]->setCoords($w,$h);
            unset($floorRooms[0]);

            //проходим пока все комнаты этажа не зкончатся
            while (count($floorRooms) > 0){
                //выбираем комнату из оставшихся
                foreach ($floorRooms as $id => $room){
                    $setRoom = false;
                    for($h=0;$h < $this->sizeFoor['height']; $h++) {
                        for($w=0;$w < $this->sizeFoor['weight']; $w++) {
                            //если комната занята - пропуск
                            if(isset($schemaFloor[$h][$w]))
                                continue;
                            //если нет соседей - пропуск
                            if(!isset($schemaFloor[$h+1][$w]) && !isset($schemaFloor[$h-1][$w]) &&
                                !isset($schemaFloor[$h][$w+1]) && !isset($schemaFloor[$h][$w-1]))
                                continue;
                            //50% что ничего не произайдет
                            if(rand(0,1))
                                continue;

                            $setRoom = true;
                            //выставляем id для карты
                            $schemaFloor[$h][$w] = $id;
                            //выставляем координаты для комнаты
                            $rooms[$lvl][$id]->setCoords($w,$h);
                            //удаляем комнату из очереди
                            unset($floorRooms[$id]);
                            break;
                        }
                        if($setRoom)
                            break;
                    }
                }
            }
            //создание связей для каждой комнаты этажа
            $floors[] = new Floor(['lvl' => $lvl, 'rooms' => $rooms[$lvl],'schemaFloor' => $schemaFloor]);
            //TODO не удаляется элемент в карте (может выйти за границу)
            unset($schemaFloor);
        }
        return $floors;
    }
}
