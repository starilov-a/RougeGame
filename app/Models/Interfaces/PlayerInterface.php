<?php


namespace App\Models\Interfaces;


interface PlayerInterface extends MobsInterface, UseItemInterface, MoveInterface
{
    public function getInfo($about);
}
