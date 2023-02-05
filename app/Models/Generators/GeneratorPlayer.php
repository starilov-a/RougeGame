<?php


namespace App\Models\Generators;


use App\Models\Entitys\Player;

class GeneratorPlayer extends GeneratorMap
{
    public function generate($name = 'player') {
        return new Player($name);
    }

    public function generateItem() {

    }

    public function generateMobs() {

    }

    public function generateTypeRoom() {

    }

}
