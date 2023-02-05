<?php

namespace App\Models;


use App\Exceptions\NoUserExeption;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class GameSession extends Model
{
    protected $fillable = ['userId', 'gameInfo'];

    public function loadSession($userId) {
        $gameInfo = unserialize(json_decode($this->where('userId', $userId)->first()->gameInfo));
        throw_if(empty($gameInfo), NoUserExeption::class);
        return ;
    }

    public function saveSession($userId, $gameInfo) {
        return $this->updateOrCreate(
            ['userId' => $userId],
            ['gameInfo' => json_encode(serialize($gameInfo))]
        );
    }

    public function endSession() {
        return false;
    }
}
