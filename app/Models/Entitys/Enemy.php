<?php

namespace App\Models\Entitys;

use App\Models\Interfaces\MobsInterface;
use Illuminate\Database\Eloquent\Model;

class Enemy extends Model implements MobsInterface {

    public function attack() {

    }

    public function takeDamage()
    {
        // TODO: Implement takeDamage() method.
    }

    public function say() {

    }

    public function getInfo() {

    }
}
