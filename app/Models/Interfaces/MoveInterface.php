<?php


namespace App\Models\Interfaces;


interface MoveInterface
{
    public function goRoom($fromRoom, $toRoom);
    public function goFloor();
}
