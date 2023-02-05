<?php


namespace App\Models\Generators;

class CaseGenerator
{
    public $map;
    public $player;

    public function __construct() {
        $this->map = New GeneratorMap();
        $this->player = New GeneratorPlayer();
    }
}
